<?php
namespace Flair\Exception {

    /**
     * A bare bones InvalidArgumentException, that can be used or extended.
     *
     * @author Daniel Sherman
     */
    class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
    {

        /**
         * Add the needed methods.
         */
        use ExceptionTrait;

        /**
         * The constructor does what you would expect it to.
         *
         * @author Daniel Sherman
         * @param string $message the message for the exception
         * @param integer $code the code for the exception
         * @param \Exception $previous A previous exception
         * @param array $context the array that will be returned along with the
         * exception.
         * @uses setId
         * @uses context
         */
        public function __construct($message, $code, $previous = null, array $context = [])
        {
            parent::__construct($message, $code, $previous);
            $this->setId();
            $this->context = $context;
        }

    }
}
