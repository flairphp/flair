<?php
namespace Flair\Validation {
    /**
     * The Unit test for the UnexpectedValueException class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\UnexpectedValueException
     */
    class UnexpectedValueExceptionTest extends \Flair\Exception\UnexpectedValueExceptionTest
    {
        /**
         * holds the class name being tested
         *
         * @var string
         */
        protected static $class = 'Flair\Validation\UnexpectedValueException';

        /**
         * holds the interface name the class should be implementing
         *
         * @var string
         */
        protected static $interface = 'Flair\Validation\ExceptionInterface';
    }
}
