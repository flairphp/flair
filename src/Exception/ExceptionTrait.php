<?php
namespace Flair\Exception {

    /**
     * Provides all the functionality needed to meet the requirements of the
     * {@link ExceptionInterface} Interface.
     *
     * @author Daniel Sherman
     */
    trait ExceptionTrait
    {
        /**
         * a unique id for the exception that can be given to the user and
         * then referenced in the logs.
         *
         * @var string $id
         */
        protected $id = null;

        /**
         * stores additional output to give an exception context. The array can be indexed or associative,
         * as well as infinitively nested. Any values other than arrays, scalars, or objects
         * with __toString() Methods will be ignored when converted to a string.
         *
         * @var array $context
         */
        protected $context = [];

        /**
         * Generates and stores $id class attribute.
         *
         * @var array $context
         * @uses id
         */
        protected function setId()
        {
            $this->id = str_replace('.', '', uniqid('', true));
        }

        /**
         * Helper function used to convert a nested array to a string with with indents.
         *
         * @author Daniel Sherman
         * @param array $array the array that needs to be turned into a string
         * @param integer $indent the number of spaces that a nested array should be indented.
         * @return string
         * @uses arrayToString
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
                } elseif (method_exists($val, '__toString')) {
                    # got a method with a __toString method
                    $buffer .= sprintf($format, '');
                    $buffer .= $key . ' => ' . $val->__toString() . PHP_EOL;
                }
            }

            return $buffer;
        }

        /**
         * Returns a unique id that makes every exception uniquely identifiable.
         *
         * @author Daniel Sherman
         * @uses id
         * @return string
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Returns the context array that was passed in during object instantiation.
         *
         * @author Daniel Sherman
         * @uses context
         * @return array
         */
        public function getContext()
        {
            return $this->context;
        }

        /**
         * Returns the context array that was passed in during object instantiation as a string.
         *
         * @author Daniel Sherman
         * @uses context
         * @uses arrayToString
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
         * @uses getId
         * @uses getMessage
         * @uses getCode
         * @uses getFile
         * @uses getLine
         * @uses getPrevious
         * @uses getTraceAsString
         * @uses getContextAsString
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

            $previous = $this->getPrevious();
            if ($previous !== null) {
                $exception .= $previous->__toString();
                $exception .= PHP_EOL . PHP_EOL;
            }

            return $exception;
        }

    }
}
