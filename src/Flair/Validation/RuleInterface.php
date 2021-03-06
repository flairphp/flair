<?php
namespace Flair\Validation {

	/**
	 * The blueprint to build basic rules against, and hint for all rules with.
	 *
	 * @author Daniel Sherman
	 */
	interface RuleInterface {

		/**
		 * Returns the value of the halt flag. The halt flag indicates that if a value
		 * fails to pass validation, further processing should halt, and the failure addressed.
		 *
		 * @return bool
		 */
		public function halt();

		/**
		 * Sets the value of the halt flag. The halt flag indicates that if a value
		 * fails to pass validation, further processing should halt, and the failure addressed.
		 *
		 * @param bool $halt The value to assign to the flag.
		 * @throws InvalidArgumentException If $halt isn't a bool.
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

		/**
		 * Returns an array of one or more error messages.
		 *
		 * @return array
		 */
		public function getErrors();
	}
}
