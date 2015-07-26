<?php
namespace Flair\Validation\Core {

    /**
     * Provides all the functionality needed to implement a {@link CallableRule} and meet the
     * requirements of the {@link RuleInterface} Interface. The only thing a developer needs
     * to do to create a rule, is create a constructor that sets the internal attributes.
     *
     * @author Daniel Sherman
     */
    trait CallableRuleTrait
    {

        /**
         * Add the needed methods to meet the requirements of the RuleInterface interface.
         */
        use RuleTrait;

        /**
         * The callable function/method actually used to perform the validation
         * of input to iswValid().
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
         * Gets the callable method/function that will be used by isValid() to validate the value
         * passed to it.
         *
         * @uses call
         * @return null|callable Returns the callable method/function if it's set, null otherwise.
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
         * @return bool Always returns true, on success.
         */
        protected function setCallable(callable $callable)
        {
            $this->call = $callable;
            return true;
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
         * @return bool Always returns true, on success.
         */
        protected function setArguments(array $arguments = [])
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
