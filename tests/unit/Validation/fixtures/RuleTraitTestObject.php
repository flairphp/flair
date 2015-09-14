<?php
namespace Flair\Validation {

	/**
	 * A class to allow testing RuleInterface & RuleTrait
	 *
	 * @author Daniel Sherman
	 */
	class RuleTraitTestObject implements RuleInterface {

		/**
		 * Add the needed methods.
		 */
		use RuleTrait;

		/**
		 *  a dummy method to fulfill the interface needs for testing
		 */
		public function isValid($value) {
			return true;
		}

		/**
		 * a dummy method to fulfill the interface needs for testing
		 */
		public function getErrors() {
			return [];
		}

	}
}