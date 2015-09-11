<?php
namespace Flair\Validation {

    /**
     * Provides a partial implementation needed to meet the requirements of the 
     * {@link RuleInterface} Interface. The only thing a developer needs to do to 
     * create a rule, is implement isValid and getErrors methods.
     *
     * @author Daniel Sherman
     */
    trait RuleTrait
    {
        /**  
         * The halt flag indicates that if a value fails to pass validation, further 
         * processing should halt, and the failure addressed.
         *
         * @var bool
         */
        protected $halt = false;

        /**
         * Returns the value of the halt flag. The halt flag indicates that if a value 
         * fails to pass validation, further processing should halt, and the failure addressed.
         *
         * @uses halt
         * @return bool
         */
        public function halt()
        {
            return $this->halt;
        }

        /**
         * Sets the value of the halt flag. The halt flag indicates that if a value 
         * fails to pass validation, further processing should halt, and the failure addressed.
         *
         * @param bool $halt The value to assign to the flag.
         * @uses halt
         * @throws InvalidArgumentException If $halt isn't a bool.
         */
        public function setHalt($halt)
        {
            if (is_bool($halt)) {
                $this->halt = $halt;
                return;
            }

            throw new InvalidArgumentException('$halt is not a bool!', 1);
        }
    }
}
