<?php
namespace Flair\Validation {

	/**
	 * Provides most of the functionality needed to implement a Rule group.
	 *
	 * @author Daniel Sherman
	 */
	trait RuleGroupTrait {
		/**
		 * The rules used within the group.
		 *
		 * @var array
		 */
		protected $rules = [];

		/**
		 * holds the keys to the rules that returned false the last time isValid was called.
		 * It should be noted that some rules might not have been run, because of a previous
		 * rule having a halt value of true.
		 *
		 * @var array
		 */
		protected $invalidRuleKeys = [];

		/**
		 * Checks to see if a rule exists within the object.
		 *
		 * @param integer|string $key The key for the rule to look for.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @uses rules
		 * @return boolean
		 */
		public function hasRule($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 12);
			}

			return isset($this->rules[$key]);
		}

		/**
		 * adds a new rule to the object.
		 *
		 * @param integer|string $key The key for the rule to add.
		 * @param RuleInterface $rule The rule to add.
		 * @uses rules
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws LogicException If $key already exists.
		 */
		public function addRule($key, RuleInterface $rule) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 13);
			}

			if (isset($this->rules[$key])) {
				throw new LogicException('$key already exists!', 14);
			}

			$this->rules[$key] = $rule;
		}

		/**
		 * updates/adds a rule in the object.
		 *
		 * @param integer|string $key The key for the rule to update.
		 * @param RuleInterface $rule The rule to update/add.
		 * @uses rules
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function updateRule($key, RuleInterface $rule) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 15);
			}

			$this->rules[$key] = $rule;
		}

		/**
		 * returns a reference to a rule in the object.
		 *
		 * @param integer|string $key The key for the rule to get.
		 * @uses rules
		 * @uses hasRule
		 * @throws OutOfBoundsException If $key doesn't exist.
		 * @return RuleInterface
		 */
		public function getRule($key) {
			if ($this->hasRule($key)) {
				return $this->rules[$key];
			}

			throw new OutOfBoundsException('$key does not exist!', 16);
		}

		/**
		 * deletes a rule from the object if it exists.
		 *
		 * @param integer|string $key The key for the rule to delete.
		 * @uses rules
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function deleteRule($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 17);
			}

			unset($this->rules[$key]);
		}

		/**
		 * adds multiple rules to the object.
		 *
		 * @param array $rules The rules to add.
		 * @uses addRule
		 */
		public function addRules(array $rules) {
			foreach ($rules as $key => $rule) {
				$this->addRule($key, $rule);
			}
		}

		/**
		 * Returns an array of invalid rule keys from the last time isValid was called.
		 *
		 * It should be noted that if updateRule or deleteRule has been called since isValid
		 * was called last the keys returned could be wrong.
		 *
		 * @uses invalidRuleKeys
		 * @return array An array of rule keys.
		 */
		public function getInvalidRulekeys() {
			return $this->invalidRuleKeys;
		}

		/**
		 *  Returns true if $value is valid, false otherwise.
		 *
		 * @param mixed $value The value to be validated.
		 * @uses invalidRuleKeys
		 * @uses rules
		 * @return bool
		 */
		public function isValid($value) {
			$rtn = true;
			$this->invalidRuleKeys = [];

			foreach ($this->rules as $key => $rule) {
				if (!$rule->isValid($value)) {

					// failed to pass validation for a rule
					$rtn = false;
					$this->invalidRuleKeys[] = $key;

					if ($rule->halt()) {
						// the rule says halt execution of any subsequent rules
						break;
					}
				}
			}

			return $rtn;
		}

		/**
		 * Returns an array of error message arrays. One array for each rule that failed validation.
		 *
		 * @uses invalidRuleKeys
		 * @uses rules
		 * @return array An array of error message arrays.
		 */
		public function getErrors() {
			$rtn = [];

			foreach ($this->invalidRuleKeys as $key) {
				$rtn[$key] = $this->rules[$key]->getErrors();
			}

			return $rtn;
		}
	}
}