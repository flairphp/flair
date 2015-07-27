<?php
namespace Flair\Validation\Core {

    /**
     * Provides a minimal implementation of the {@link RuleInterface} Interface. The only thing a
     * developer needs to do to create a rule, is implement a custom isValid Method.
     *
     *
     * @author Daniel Sherman
     */
    trait RuleTrait
    {
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
                return true;
            }

            throw new InvalidArgumentException('$message is not a string!', 0);
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
         * @throws InvalidArgumentException If $halt isn't a bool.
         * @return bool Always returns true, on success.
         */
        public function setHalt($halt)
        {
            if (is_bool($halt)) {
                $this->halt = $halt;
                return true;
            }

            throw new InvalidArgumentException('$halt is not a bool!', 1);
        }
    }
}
