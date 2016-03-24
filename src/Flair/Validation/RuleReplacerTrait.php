<?php
namespace Flair\Validation {

	/**
	 * Provides The minimal functionality needed to manipulate a replacer.
	 *
	 * @author Daniel Sherman
	 * @todo finish documentation and method hinting
	 */
	trait RuleReplacerTrait {

		/**
		 * The replacer associated with the object.
		 *
		 * @var RuleReplacer
		 */
		protected $replacer = null;

		/**
		 * Returns a reference to the internal replacer object.
		 *
		 * @return mixed A replacer object, or null if no replacer has been set
		 */
		public function getReplacer() {
			return $this->replacer;
		}

		/**
		 * Sets the internal replacer object.
		 *
		 * @param mixed $replacer The value to assign.
		 * @throws InvalidArgumentException If $replacer isn't.
		 */
		public function setReplacer($replacer) {
			$this->replacer = $replacer;
		}

		/**
		 * Indicates if a replacer is currently set.
		 *
		 * @return bool
		 */
		public function hasReplacer() {
			if ($this->replacer !== null) {
				return true;
			} else {
				return false;
			}
		}
	}
}
