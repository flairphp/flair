<?php
namespace Flair\Validation {

	/**
	 * The blueprint to build Replacer against.
	 *
	 * @author Daniel Sherman
	 */
	interface ReplacerInterface {
		/**
		 * Sets the value of the prefix used when doing replacements.
		 *
		 * @param string $prefix The value to assign to the prefix.
		 * @throws InvalidArgumentException If $prefix isn't a string.
		 */
		public function setPrefix($prefix);

		/**
		 * Returns the value of the prefix used when doing replacements.
		 *
		 * @return string the prefix
		 */
		public function getPrefix();

		/**
		 * Sets the value of the suffix used when doing replacements.
		 *
		 * @param string $suffix The value to assign to the suffix.
		 * @throws InvalidArgumentException If $suffix isn't a string.
		 */
		public function setSuffix($suffix);

		/**
		 * Returns the value of the suffix used when doing replacements.
		 *
		 * @return string the suffix
		 */
		public function getSuffix();

		/**
		 * Checks to see if a replacement key exists.
		 *
		 * @param string $key The replacement key to look for.
		 * @return boolean
		 */
		public function hasReplacement($key);

		/**
		 * Get the replacement value for a given key.
		 *
		 * @param string $key The replacement key to look for.
		 * @return mixed The value associated with the key
		 * @throws OutOfBoundsException If $key doesn't exist.
		 */
		public function getReplacement($key);

	}
}
