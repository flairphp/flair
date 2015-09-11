<?php
namespace Flair\Validation {

    /**
     * Provides The minimal functionality needed to store, set, & get a 
     * rules error message/template.
     *
     * @author Daniel Sherman
     */
    trait RuleMessageTrait
    {
        /**
         * The error message/template associated with the rule.
         *
         * @var string
         */
        protected $message = '';

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
         * @throws InvalidArgumentException If $message isn't a string.
         * @return bool Always returns true, on success.
         */
        public function setMessage($message)
        {
            if (is_string($message)) {
                $this->message = $message;
                return;
            }

            throw new InvalidArgumentException('$message is not a string!', 0);
        }
    }
}
