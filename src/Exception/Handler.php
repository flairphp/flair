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
     */
    class Handler
    {
        /**
         * should a caught exception generate output
         *
         * @var boolean $output
         */
        protected $output = false;

        /**
         * holds the level of of the output buffer, when output override was enabled.
         *
         * @var int $obLevel
         */
        protected $obLevel = 0;

        /**
         * the file path to an optional template file that
         * will be used to generate output if output should be generated.
         *
         * @var string $template
         */
        protected $template = null;

        /**
         * should a caught exception be logged
         *
         * @var boolean $log
         */
        protected $log = true;

        /**
         * an optional logger to be called instead of the default. The method
         * will be passed the exception object.
         *
         * @var callable $logger
         */
        protected $logger = null;

        /**
         * Enables an output buffer, so that if an exception is caught the output can
         * be overridden with a custom output.
         *
         * @author Daniel Sherman
         * @uses buffer
         * @return null|bool True on success false on failure, and null if it's
         * already been enabled.
         */
        public function enableOutputOverride()
        {
            if ($this->output) {
                // already on so return null
                return null;
            }

            $result = ob_start();
            if ($result) {
                $this->output = true;
                $this->obLevel = ob_get_level();
            }

            return $result;
        }

        /**
         * Sets the path to an optional template that is used during output generation,
         * instead of the default. The template will only be included if output override
         * is enabled.
         *
         * @author Daniel Sherman
         * @param sting $template The file path to the template.
         * @uses template
         * @return boolean true on success false otherwise.
         */
        public function setTemplate($template)
        {
            if (!is_string($template)) {
                return false;
            }

            $resolvedFile = stream_resolve_include_path($template);
            if ($resolvedFile !== false) {

                // the file was found so see if it can be read
                if (is_readable($resolvedFile)) {
                    $this->template = $template;
                    return true;
                }
            }

            return false;
        }

        /**
         * should an uncaught exception be logged. On by default.
         *
         * @author Daniel Sherman
         * @param boolean $log
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
            return true;
        }

        /**
         * logs the exception appropriately.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be logged
         * @uses logger
         */
        public function logException(\Exception $e)
        {
            if ($this->logger !== null) {
                $method = $this->logger;
                $method($e);
            } else {
                // this can't really be unit tested tested
                $lines = explode(PHP_EOL, $e->__toString());
                foreach ($lines as $line) {
                    error_log($line);
                }
            }
        }

        /**
         * generates the default error output
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be outputted
         * @return string the default output
         */
        public function generateDefaultOutput(\Exception $e)
        {
            $message = 'Issue: ';

            if ($e instanceof ExceptionInterface) {
                $message .= $e->getId();
            }

            $interface = php_sapi_name();
            if (substr($interface, 0, 3) != 'cli') {
                // this can't really be unit tested tested

                // it should be noted that the response code will be ignored
                // if data has already been sent to the browser.
                http_response_code(500);
            }

            return $message;
        }

        /**
         * renders error output.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be outputted
         * @uses template
         * @uses generateDefaultOutput
         */
        public function generateOutput(\Exception $e)
        {
            if ($this->template !== null) {
                require $this->template;
            } else {
                echo $this->generateDefaultOutput($e);
            }
        }

        /**
         * Registers the object with php so it can handle uncaught exceptions.
         *
         * @author Daniel Sherman
         */
        public function register()
        {
            // this can't really be unit tested tested
            set_exception_handler([$this, 'catcher']);
        }

        /**
         * Handles The uncaught exceptions. Logs the exception if needed,
         * and generates output if needed.
         *
         * @author Daniel Sherman
         * @param \Exception $e The exception thats needs to be handled
         * @uses log
         * @uses logException
         * @uses output
         * @uses obLevel
         */
        public function catcher(\Exception $e)
        {
            // this can't really be unit tested tested

            if ($this->log) {
                $this->logException($e);
            }

            if ($this->output) {
                while (ob_get_level() >= $this->obLevel) {
                    ob_end_clean();
                }

                $this->generateOutput($e);
            }
        }
    }
}
