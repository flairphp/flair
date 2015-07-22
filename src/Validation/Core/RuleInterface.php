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
         * Returns true if $value is valid, false otherwise.
         *
         * @param mixed $value The value to be validated.
         * @return bool
         */
        public function isValid($value);

        /**
         * Sets the error message associated with the rule.
         *
         * @param string $message The new error message.
         */
        public function setMessage($message);

        /**
         * Returns the error message associated with the rule.
         *
         * @return string
         */
        public function getMessage();

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
         */
        public function setHalt($halt);

        /**
         * Sets the callable method/function that will be used by isvalid to
         * validate the value passed to it.
         *
         * @param callable $callable The callable that will be used by isValid.
         */
        public function setCallable(callable $callable);

        /**
         * Gets the callable method/function that will be used by isvalid to
         * validate the value passed to it.
         *
         * @return null|callable Returns the callable method/function if it's set, null otherwise.
         */
        public function getCallable();
    }
}
