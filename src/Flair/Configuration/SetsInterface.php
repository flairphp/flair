<?php
namespace Flair\Configuration {

	/**
	 * The blueprint to build Configuration Sets against, and hint for all Sets with.
	 *
	 * @author Daniel Sherman
	 */
	interface SetsInterface {

		/**
		 * Returns the value of the Default Set key.
		 *
		 * @return string|integer|null
		 */
		public function getDefaultSetKey();

		/**
		 * Set the value of the Default Set key.
		 *
		 * @param integer|string $key The key for the default set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function setDefaultSetKey($key);

		/**
		 * does a given set exist.
		 *
		 * @param integer|string $key The Set to look for.
		 * @return boolean
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function hasSet($key);

		/**
		 * adds a new set to the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @param array $values The key value pairs for the Set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws LogicException If $key already exists.
		 */
		public function addSet($key, array $values);

		/**
		 * gets a set from the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @return array The key value pairs for the Set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws OutOfBoundsException If $key doesn't exist.
		 */
		public function getSet($key);

		/**
		 * updates set in the object or adds a new one.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @param array $values The key value pairs for the Set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function updateSet($key, array $values);

		/**
		 * deletes a set from the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function deleteSet($key);

		/**
		 * gets all the sets from the object.
		 *
		 * @return array The returned array is an associative array of associative arrays
		 */
		public function getSets();

		/**
		 * Returns an array of all the set keys in the object.
		 *
		 * @return array
		 */
		public function getSetKeys();

		/**
		 * does a given value exist.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to check in. if no key is given
		 * the default Set key is used.
		 * @return boolean
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 */
		public function hasValue($valueKey, $setKey);

		/**
		 * Adds a value to the object
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param mixed $value The value to add
		 * @param integer|string $setKey The key for the set to add the value to. if no key is given
		 * the default Set key is used.
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws LogicException If $valueKey already exists.
		 * @throws OutOfBoundsException If $setKey doesn't exist.
		 */
		public function addValue($valueKey, $value, $setKey);

		/**
		 * Gets a value from the object.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to get the value from. if no key is given
		 * the default Set key is used.
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws OutOfBoundsException If $valueKey or $setKey doesn't exist.
		 */
		public function getValue($valueKey, $setKey);

		/**
		 * Deletes a value from the object.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to delete the value from. if no key is given
		 * the default Set key is used.
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws OutOfBoundsException If $setKey doesn't exist.
		 */
		public function deleteValue($valueKey, $setKey);

		/**
		 * Returns an array of all the keys in a given set.
		 *
		 * @param integer|string $key The key for the set to check in. if no key is given
		 * the default Set key is used.
		 * @return array
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function getValueKeys($key);

	}
}