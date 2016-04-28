<?php
namespace Flair\Validation {

	/**
	 * The blueprint to build rules against that handle setting/getting replacer
	 * objects.
	 *
	 * @author Daniel Sherman
	 */
	interface RuleReplacerInterface {
		/**
		 * Returns a reference to the internal replacer object.
		 *
		 * @return Replacer A replacer object, or null if no replacer has been set
		 */
		public function getReplacer();

		/**
		 * Sets the internal replacer object.
		 *
		 * @param Replacer $replacer The value to assign.
		 * @throws InvalidArgumentException If $replacer isn't.
		 */
		public function setReplacer(ReplacerInterface $replacer);

		/**
		 * Indicates if a replacer is currently set.
		 *
		 * @return bool
		 */
		public function hasReplacer();
	}
}
