<?php
namespace Flair\Validation {

	/**
	 * The blueprint to build rules against that handle setting/getting replacer
	 * objects.
	 *
	 * @author Daniel Sherman
	 * @todo finish documentation and method hinting
	 */
	interface RuleReplacerInterface {
		/**
		 * Returns a reference to the internal replacer object.
		 *
		 * @return mixed A replacer object, or null if no replacer has been set
		 */
		public function getReplacer();

		/**
		 * Sets the internal replacer object.
		 *
		 * @param mixed $replacer The value to assign.
		 * @throws InvalidArgumentException If $replacer isn't.
		 */
		public function setReplacer($replacer);

		/**
		 * Indicates if a replacer is currently set.
		 *
		 * @return bool
		 */
		public function hasReplacer();
	}
}
