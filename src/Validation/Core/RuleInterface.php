<?php
namespace Flair\Validation\Core {

    /**
     * The RuleInterface is the blueprint to build rules against, and hint with.
     *
     * @author Daniel Sherman
     */
    interface RuleInterface
    {

        /**
         * Gets the callable method/function that will be used by isValid() to validate the value
         * passed to it.
         *
         * @return null|callable Returns the callable method/function if it's set, null otherwise.
         */
        public function getCallable();

        /**
         * Sets the callable method/function that will be used by isValid() to validate the value
         * passed to it. The method/function should always return a bool value.
         *
         * @param callable $callable The callable that will be used by isValid.
         * @return bool Always returns true, on success.
         */
        public function setCallable(callable $callable);

        /**
         * Returns the error message associated with the rule.
         *
         * @return string
         */
        public function getMessage();

        /**
         * Sets the error message associated with the rule.
         *
         * @param string $message The new error message.
         * @throws Exception If $message isn't a string.
         * @return bool Always returns true, on success.
         */
        public function setMessage($message);

        /**
         * Returns the value of the halt flag. The halt flag is used by a validator to determine
         * if an individual rule should prevent processing of other rules in the validator, if
         * isValid() returns false.
         *
         * @return bool
         */
        public function getHalt();

        /**
         * Sets the value of the halt flag. The halt flag is used by a validator to determine
         * if an individual rule should prevent processing of other rules in the validator, if
         * isValid() returns false.
         *
         * @param bool $halt The value to assign to the  flag.
         * @throws Exception If $halt isn't a bool.
         * @return bool Always returns true, on success.
         */
        public function setHalt($halt);

        /**
         * Gets the optional arguments that will be passed along to the callable method/function
         * that will be used by isValid() to validate the value passed to it.
         *
         * @return array The arguments that will be used.
         */
        public function getArguments();

        /**
         * Sets the optional arguments that isValid() will pass to the callable method/function
         * it uses for validating its input.
         *
         * @param array $arguments The arguments to be used.
         * @return bool Always returns true, on success.
         */
        public function setArguments(array $arguments);

        /**
         * Returns true if $value is valid, false otherwise.
         *
         * @param mixed $value The value to be validated.
         * @throws Exception If the callable method hasn't been set, or if the method
         * doesn't return a bool.
         * @return bool
         */
        public function isValid($value);

    }
}
