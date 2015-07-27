<?php
namespace Flair\Exception {
    /**
     * The class provides some basic functionality for handling exceptions that go uncaught.
     *
     * This class should only be instantiated once per execution, ideally it should be called
     * as soon as possible. The class provides the following functionality.
     *<ul>
     *    <li>A  output buffer that allows clearing partially generated output.</li>
     *    <li>An option to log the uncaught exception to the error log.</li>
     *    <li>An option to log the uncaught exception with a PSR-3 compliant logger.</li>
     *    <li>An option to generate an output message if an output buffer was used.</li>
     *    <li>An option to generate a custom output message (using a template file)
     *    if an output buffer was used.</li>
     *</ul>
     *
     * @author Daniel Sherman
     * @todo set up unit tests for the class
     */
    class Handler
    {

        /**
         * is a global output buffer in use. This flag is not absolute, as output buffering cannot be
         *
         * @var boolean $buffer
         */
        protected $buffer = false;

        /**
         * should a caught exception generate output
         *
         * @var boolean $output
         */
        protected $output = false;

        /**
         * should a caught exception be logged
         *
         * @var boolean $log
         */
        protected $log = true;

        /**
         * the file path to an optional template file that
         * will be used to generate output if output should be generated.
         *
         * @var string $template
         */
        protected $template = null;

        /**
         * an optional logger to be called instead of the default. The method
         * will be passed the exception object.
         *
         * @var callable $template
         */
        protected $logger = null;

        /**
         * Sets the buffering flag and tries to start an output buffer if true is passed.
         * This method should only be called once.
         *
         * @author Daniel Sherman
         * @param boolean $buffer Should buffering be used.
         * @uses buffer
         * @return boolean true on success false otherwise.
         */
        public function setBuffering($buffer)
        {
            if ($this->buffer) {
                // buffering is already on so just return
                return true;
            }

            if (is_bool($buffer)) {
                $this->buffer = $buffer;

                if ($buffer) {
                    return ob_start();
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        /**
         * Sets the output flag.
         *
         * @author Daniel Sherman
         * @param boolean $output Should output be generated.
         * @uses output
         * @return boolean true on success false otherwise.
         */
        public function setOutput($output)
        {
            if (is_bool($output)) {
                $this->output = $output;
                return true;
            }
            return false;
        }

        /**
         * Sets the logging flag.
         *
         * @author Daniel Sherman
         * @param boolean $log Should the exception be logged when caught.
         * @uses log
         * @return boolean true on success false otherwise.
         */
        public function setLogging($log)
        {
            if (is_bool($log)) {
                $this->log = $log;
                return true;
            }
            return false;
        }

        /**
         * Sets the path to an optional template that is used during output generation.
         *
         * @author Daniel Sherman
         * @param sting $template The file path to an optional file that will
         * be used to generate output.
         * @uses template
         * @return boolean true on success false otherwise.
         */
        public function setTemplate($template)
        {
            if (!is_string($template)) {
                return false;
            }

            $resolvedTemplate = stream_resolve_include_path($template);
            if ($resolvedFile !== false) {

                // the file was found so see if it can be read
                if (is_readable($resolvedTemplate)) {
                    $this->template = $template;
                    return true;
                }
            }

            return false;
        }

        /**
         * Sets an optional logging method to use instead of the default.
         * This makes the class psr-3 compliant.
         *
         * @author Daniel Sherman
         * @param callable $logger The method to use.
         * @uses logger
         * @return boolean true
         */
        public function setLogger(callable $logger)
        {
            $this->logger = $logger;
        }

        /**
         * Registers the object with php so it can handle uncaught exceptions.
         *
         * @author Daniel Sherman
         */
        public function register()
        {
            set_exception_handler([$this, 'catcher']);
        }

        /**
         * Handles The uncaught exceptions, & clears the output buffers if directed to.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be handled
         * @uses buffer
         * @uses output
         * @uses log
         * @uses outputter
         * @uses logException
         */
        public function catcher($e)
        {
            if ($this->buffer) {
                while (ob_get_level()) {
                    ob_end_clean();
                }
            }

            if ($this->output) {
                $this->outputter($e);
            }

            if ($this->log) {
                $this->logException($e);
            }
        }

        /**
         * logs the exception appropriately.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be logged
         * @uses logger
         */
        protected function logException($e)
        {
            if ($this->logger !== null) {
                $method = $this->logger;
                $method($e);
            } else {
                error_log($e->_toString());
            }
        }

        /**
         * renders error output.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be outputted
         * @uses template
         * @uses defaultOutputter
         */
        protected function outputter($e)
        {
            if ($this->template !== null) {
                require $this->template;
            } else {
                $this->defaultOutputter($e);
            }
        }

        /**
         * Renders the default error output
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be outputted
         */
        protected function defaultOutputter($e)
        {
            $message = 'Fatal Error: ';

            if ($e instanceof ExceptionInterface) {
                $message .= $e->getId();
            }

            $interface = php_sapi_name();
            if (substr($interface, 0, 3) != 'cli') {
                // it should be noted that the response code will be ignored
                // if data has already been sent to the browser.
                http_response_code(500);
            }

            exit($message);
        }

    }
}
