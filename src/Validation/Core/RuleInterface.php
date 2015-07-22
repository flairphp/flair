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
         * Returns the value of the flag that indicates if the rule should break the chain if it's
         * chained with other rules and isValid returns false.
         *
         * @return bool
         */
        public function getBreakFlag();

        /**
         * Sets the value of the flag that indicates if the rule should break the chain if it's
         * chained with other rules and isValid returns false.
         *
         * @param bool $break The value to assign to the break flag.
         */
        public function setBreakFlag($break);

    }
}
