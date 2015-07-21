<?php
namespace Flair\Exception {

    /**
     * The Exception class is the class that all other Exception
     * classes should be extended from.
     *
     * The Exception class is designed to control how non fatal errors are
     * handled. The class can be extended by child classes to provide additonal
     * control over exceptions. The Exception class is an extension of
     * the internal php Exception class.
     *
     * @author Daniel Sherman
     */
    class Exception extends \Exception
    {

        /**
         * a unique id for the exception that can be given to the user and
         * then refrenced in the logs.
         *
         * @var string $id
         */
        protected $id = null;

        /**
         * An array used to store additonal output in the exception, to give context to it.
         * The array can be indexed or associative, as well as being infinitively nested.
         * Any values other than arrays or scalars will be ignored when converted to a string.
         *
         * @var array $context
         */
        protected $context = [];

        /**
         * The constructor does what you would expect it to.
         *
         * @author Daniel Sherman
         * @param string $message the message for the exception
         * @param integer $code the code for the exception
         * @param array $extras the array that will be returned along with the
         * exception.
         * @uses _id
         * @uses _context
         */
        public function __construct($message, $code, array $context = null)
        {
            parent::__construct($message, $code);

            $this->id = str_replace('.', '', uniqid('', true));

            if (is_array($context)) {
                # extras is valid, so set it
                $this->context = $context;
            }
        }

        /**
         * Simple accessing method that returns the $id class attribute.
         *
         * @author Daniel Sherman
         * @uses _id
         * @return string
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Simple accessing method that returns the $extras class attribute.
         *
         * @author Daniel Sherman
         * @uses _context
         * @return array
         */
        public function getContext()
        {
            return $this->context;
        }

        /**
         * Helper function used to convert a nested array to a string with with indents.
         *
         * @author Daniel Sherman
         * @param array $array the array that needs to be turned into a string
         * @param integer $indent the number of spaces that a nested array should be indented.
         * @return string
         */
        protected function arrayToString(array $array, $indent = 0)
        {
            # string used to store the output
            $buffer = ''; # string used to store the output

            # format to use when pushing values to the buffer
            $format = '%' . $indent . 's';

            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    # $value is an array perform a recursive call
                    $buffer .= sprintf($format, '') . $key . ' => ' . PHP_EOL;
                    $buffer .= $this->arrayToString($val, $indent + 4);
                } elseif (is_scalar($val)) {
                    # push $value to the buffer
                    $buffer .= sprintf($format, '');
                    $buffer .= $key . ' => ' . $val . PHP_EOL;
                }
            }

            return $buffer;
        }

        /**
         * returns the $extras class attribute as a string.
         *
         * @author Daniel Sherman
         * @uses _context
         * @return string
         */
        public function getContextAsString()
        {
            return rtrim($this->arrayToString($this->context));
        }

        /**
         * Generates and returns a string representation of the exception.
         *
         * @author Daniel Sherman
         * @return string
         */
        public function __toString()
        {
            $separator = sprintf("%'-80s", '-');
            $wrapper = sprintf("%'#80s", '#');

            $exception = $wrapper . PHP_EOL;
            $exception .= 'Class: ' . get_class($this) . PHP_EOL;
            $exception .= 'Id: ' . $this->getId() . PHP_EOL;
            $exception .= 'Message: ' . $this->getMessage() . PHP_EOL;
            $exception .= 'Code: ' . $this->getCode() . PHP_EOL;
            $exception .= 'File: ' . $this->getFile() . PHP_EOL;
            $exception .= 'Line: ' . $this->getLine() . PHP_EOL;
            $exception .= $separator . PHP_EOL;
            $exception .= $this->getTraceAsString() . PHP_EOL;
            $exception .= $separator . PHP_EOL;
            $exception .= $this->getContextAsString() . PHP_EOL;
            $exception .= $wrapper . PHP_EOL;

            return $exception;
        }

    }
}
