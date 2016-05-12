<?php
namespace Flair\Validation {

	/**
	 * The blueprint to build Rule groups against.
	 *
	 * @author Daniel Sherman
	 */
	interface RuleGroupInterface {

		/**
		 * Checks to see if a rule exists within the object.
		 *
		 * @param integer|string $key The key for the rule to look for.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @return boolean
		 */
		public function hasRule($key);

		/**
		 * adds a new rule to the object.
		 *
		 * @param integer|string $key The key for the rule to add.
		 * @param RuleInterface $rule The rule to add.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws LogicException If $key already exists.
		 */
		public function addRule($key, RuleInterface $rule);

		/**
		 * updates/adds a rule in the object.
		 *
		 * @param integer|string $key The key for the rule to update.
		 * @param RuleInterface $rule The rule to update/add.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function updateRule($key, RuleInterface $rule);

		/**
		 * returns a reference to a rule in the object.
		 *
		 * @param integer|string $key The key for the rule to get.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws OutOfBoundsException If $key doesn't exist.
		 * @return RuleInterface
		 */
		public function getRule($key);

		/**
		 * deletes a rule from the object if it exists.
		 *
		 * @param integer|string $key The key for the rule to delete.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function deleteRule($key);

		/**
		 * adds multiple rules to the object.
		 *
		 * @param array $rules The rules to add.
		 */
		public function addRules(array $rules);

		/**
		 * Returns an array of invalid rule keys from the last time isValid was called.
		 *
		 * @return array An array of the rule keys.
		 */
		public function getInvalidRulekeys();
	}
}