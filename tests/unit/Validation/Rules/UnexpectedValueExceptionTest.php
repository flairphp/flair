<?php
namespace Flair\Validation\Rules {
    /**
     * The Unit test for the UnexpectedValueException class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\Rules\UnexpectedValueException
     */
    class UnexpectedValueExceptionTest extends \Flair\Validation\UnexpectedValueExceptionTest
    {
        /**
         * holds the class name being tested
         *
         * @var string
         */
        protected static $class = 'Flair\Validation\Rules\UnexpectedValueException';

        /**
         * holds the interface name the class should be implementing
         *
         * @var string
         */
        protected static $interface = 'Flair\Validation\Rules\ExceptionInterface';
    }
}
