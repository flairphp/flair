<?php
namespace Flair\Validation\Rules {

    /**
     * A bare bones rule, that can be used or extended, that leverages the power of callables.
     *
     * @author Daniel Sherman
     */
    class Caller implements
    \Flair\Validation\RuleInterface,
    \Flair\Validation\RuleMessageInterface,
    \Flair\Validation\RuleReplacerInterface
    {

        /**
         * Add the needed methods.
         */
        use \Flair\Validation\RuleTrait;
        use \Flair\Validation\RuleMessageTrait;
        use \Flair\Validation\RuleReplacerTrait;

        /**
         * The callable function/method actually used to perform the validation
         * of input to isValid().
         *
         * @var callable
         */
        protected $call = null;

        /**
         * The optional arguments that isValid() will pass to $callable for validating input.
         *
         * @var array
         */
        protected $arguments = [];

        /**
         * The constructor does what you would expect it to.
         *
         * @todo finish documenting and writing
         */
        public function __construct()
        {}

        /**
         * Gets the callable method/function that will be used by isValid() to validate the value
         * passed to it.
         *
         * @uses call
         * @return callable Returns the callable method/function if it's set, null otherwise.
         */
        protected function getCallable()
        {
            return $this->call;
        }

        /**
         * Sets the callable method/function that will be used by isValid() to validate the value
         * passed to it. The method/function should always return a bool value.
         *
         * @param callable $callable The callable that will be used by isValid().
         * @uses call
         */
        protected function setCallable(callable $callable)
        {
            $this->call = $callable;
        }

        /**
         * Gets the optional arguments that will be passed along to the callable method/function
         * that will be used by isValid() to validate the value passed to it.
         *
         * @uses arguments
         * @return array The arguments that will be used.
         */
        protected function getArguments()
        {
            return $this->arguments;
        }

        /**
         * Sets the optional arguments that isValid() will pass to the callable method/function
         * it uses for validating its input.
         *
         * @param array $arguments The arguments to be used.
         * @uses arguments
         */
        protected function setArguments(array $arguments = [])
        {
            $this->arguments = $arguments;
        }

        /**
         *  Returns true if $value is valid, false otherwise.
         *
         * @todo finish documenting and writing
         */
        public function isValid($value)
        {
            return true;
        }

        /**
         * a dummy method to fulfill the interface needs for testing
         *
         * @todo finish documenting and writing
         */
        public function getErrors()
        {
            return [];
        }

    }
}
