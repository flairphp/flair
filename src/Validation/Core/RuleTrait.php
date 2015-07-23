<?php
namespace Flair\Validation\Core {

    /**
     * The RuleTrait provides a minimal implementation of RuleInterface Interface.
     *
     * @author Daniel Sherman
     * @todo set up unit tests for the class
     */
    trait RuleTrait
    {
        /**
         * The callable function/method actually used to perform the validation
         * of input to iswValid().
         *
         * @var callable
         */
        protected $call = null;

        /**
         * The error message associated with the rule.
         *
         * @var string
         */
        protected $message = '';

        /**
         * The flag used by a validator to determine if an individual rule should prevent
         * processing of other rules in the validator, if isValid() returns false.
         *
         * @var bool
         */
        protected $halt = false;

        /**
         * The optional arguments that isValid() will pass to $callable for validating input.
         *
         * @var array
         */
        protected $arguments = [];

        /**
         * Gets the callable method/function that will be used by isValid() to validate the value
         * passed to it.
         *
         * @uses call
         * @return null|callable Returns the callable method/function if it's set, null otherwise.
         */
        public function getCallable()
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
        public function setCallable(callable $callable)
        {
            $this->call = $callable;
        }

        /**
         * Returns the error message associated with the rule.
         *
         * @uses message
         * @return string
         */
        public function getMessage()
        {
            return $this->message;
        }

        /**
         * Sets the error message associated with the rule.
         *
         * @param string $message The new error message.
         * @uses message
         */
        public function setMessage($message)
        {
            if (is_string($message)) {
                $this->message = $message;
                return;
            }

            throw new Exception('$message is not a string!', 0);
        }

        /**
         * Returns the value of the halt flag. The halt flag is used by a validator to determine
         * if an individual rule should prevent processing of other rules in the validator, if
         * isValid() returns false.
         *
         * @uses halt
         * @return bool
         */
        public function getHalt()
        {
            return $this->halt;
        }

        /**
         * Sets the value of the halt flag. The halt flag is used by a validator to determine
         * if an individual rule should prevent processing of other rules in the validator, if
         * isValid() returns false.
         *
         * @param bool $halt The value to assign to the  flag.
         * @uses halt
         * @throws Exception If $halt isn't a bool.
         */
        public function setHalt($halt)
        {
            if (is_bool($halt)) {
                $this->halt = $halt;
                return;
            }

            throw new Exception('$halt is not a bool!', 1);
        }

        /**
         * Gets the optional arguments that will be passed along to the callable method/function
         * that will be used by isValid() to validate the value passed to it.
         *
         * @uses arguments
         * @return array The arguments that will be used.
         */
        public function getArguments()
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
        public function setArguments(array $arguments)
        {
            $this->arguments = $arguments;
        }

        /**
         * Returns true if $value is valid, false otherwise.
         *
         * @param mixed $value The value to be validated.
         * @uses getCallable
         * @uses getArguments
         * @throws Exception If $halt isn't a bool.
         * @return bool
         * @todo finish the method
         */
        public function isValid($value)
        {
            $call = $this->getCallable();
            $args = $this->getArguments();

            if (count($args) > 0) {
                //call use func array
            } else {
                //regular call
            }

            //check if result is a bool
            // return it if it is
            // throw exception if it's not

        }

    }
}
