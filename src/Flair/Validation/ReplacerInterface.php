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
		 * @throws InvalidArgumentException If $key isn't a string.
		 * @return boolean
		 */
		public function hasReplacement($key);

		/**
		 * Get the replacement value for a given key.
		 *
		 * @param string $key The replacement key to look for.
		 * @throws OutOfBoundsException If $key doesn't exist.
		 * @return mixed The value associated with the key
		 */
		public function getReplacement($key);

		/**
		 * adds a new replacement key & value.
		 *
		 * @param string $key The replacement key .
		 * @param string $key The replacement value.
		 * @throws InvalidArgumentException If $key isn't a string.
		 * @throws LogicException If key already exists.
		 * @throws LogicException If $value isn't a scalars, or object
		 * with a __toString() Method.
		 */
		public function addReplacement($key, $value);

		/**
		 * updates an existing replacement key & value.
		 *
		 * @param string $key The replacement key .
		 * @param string $key The replacement value.
		 * @throws InvalidArgumentException If $key isn't a string.
		 * @throws LogicException If $value isn't a scalars, or object
		 * with a __toString() Method.
		 */
		public function updateReplacement($key, $value);

		/**
		 * adds multiple replacement key & value pairs.
		 *
		 * @param array $replacements The replacement to add.
		 * @throws InvalidArgumentException If an array key isn't a string.
		 * @throws LogicException If a key already exists.
		 * @throws LogicException If a value isn't a scalars, or object
		 * with a __toString() Method.
		 */
		public function addReplacements(array $replacements);

		/**
		 * Deletes a replacement if the key exists.
		 *
		 * @param string $key The replacement key to look for.
		 */
		public function deleteReplacement($key);

		/**
		 * Does the replacements on the input string.
		 *
		 * @param string $message The string to perform replacements on.
		 * @throws InvalidArgumentException If $message isn't a string.
		 * @return string $message with the replacements performed on it
		 */
		public function doReplacements($message);

	}
}
