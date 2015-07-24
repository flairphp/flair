<?php
namespace Flair\Validation\Core {

    /**
     * The RuleTrait provides a minimal implementation of RuleInterface Interface.
     *
     * @author Daniel Sherman
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
         * @return bool Always returns true, on success.
         */
        public function setCallable(callable $callable)
        {
            $this->call = $callable;
            return true;
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
         * @param string $message The error message.
         * @uses message
         * @throws Exception If $message isn't a string.
         * @return bool Always returns true, on success.
         */
        public function setMessage($message)
        {
            if (is_string($message)) {
                $this->message = $message;
                return true;
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
         * @param bool $halt The value to assign to the flag.
         * @uses halt
         * @throws Exception If $halt isn't a bool.
         * @return bool Always returns true, on success.
         */
        public function setHalt($halt)
        {
            if (is_bool($halt)) {
                $this->halt = $halt;
                return true;
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
         * @return bool Always returns true, on success.
         */
        public function setArguments(array $arguments = [])
        {
            $this->arguments = $arguments;
            return true;
        }

        /**
         * Returns true if $value is valid, false otherwise.
         *
         * @param mixed $value The value to be validated.
         * @uses getCallable
         * @uses getArguments
         * @throws Exception If the callable method hasn't been set, or if the method
         * doesn't return a bool.
         * @return bool
         */
        public function isValid($value)
        {
            $call = $this->getCallable();
            $args = $this->getArguments();

            if (!is_callable($call)) {
                throw new Exception('The callable method has not been set!', 2);
            }

            if (count($args) > 0) {
                //only call call_user_func_array if absolutely needed
                array_unshift($args, $value);
                $result = call_user_func_array($call, $args);
            } else {
                $result = $call($value);
            }

            if (is_bool($result)) {
                return $result;
            }

            throw new Exception('The callable method did not return a boolean!', 3);
        }

    }
}
