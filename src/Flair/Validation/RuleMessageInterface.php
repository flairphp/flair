<?php
namespace Flair\Validation {

    /**
     * The blueprint to build rules against that handle setting/getting custom 
     * error messages.
     *
     * @author Daniel Sherman
     */
    interface RuleMessageInterface
    {

        /**
         * Returns the error message associated with the rule.
         *
         * @uses message
         * @return string
         */
        public function getMessage();

        /**
         * Sets the error message associated with the rule.
         *
         * @param string $message The error message.
         * @throws InvalidArgumentException If $message isn't a string.
         * @return bool Always returns true, on success.
         */
        public function setMessage($message);
    }
}
