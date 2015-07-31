<?php
namespace Flair\Validation\Core {

    /**
     * The blueprint to build basic rules against, and hint for all rules with.
     *
     * @author Daniel Sherman
     */
    interface RuleInterface
    {

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
         * @throws InvalidArgumentException If $message isn't a string.
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
         * @param bool $halt The value to assign to the flag.
         * @throws InvalidArgumentException If $halt isn't a bool.
         * @return bool Always returns true, on success.
         */
        public function setHalt($halt);

        /**
         * Returns true if $value is valid, false otherwise.
         *
         * @param mixed $value The value to be validated.
         * @throws LogicException If it's not possible to validate $value.
         * @return bool
         */
        public function isValid($value);

    }
}
