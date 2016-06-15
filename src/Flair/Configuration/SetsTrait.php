<?php
namespace Flair\Configuration {

	/**
	 * Contains all the basic functionality need for Configuration Sets.
	 *
	 * @author Daniel Sherman
	 */
	trait SetsTrait {
		/**
		 * The Sets
		 *
		 * @var array
		 */
		protected $sets = [];

		/**
		 * The default Set key
		 *
		 * @var string|integer|null
		 */
		protected $defaultSet = null;

		/**
		 * Returns the value of the Default Set key.
		 *
		 * @uses defaultSet
		 * @return string|integer|null
		 */
		public function getDefaultSetKey() {
			return $this->defaultSet;
		}

		/**
		 * Set the value of the Default Set key.
		 *
		 * @param integer|string $key The key for the default set.
		 * @uses defaultSet
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function setDefaultSetKey($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 0);
			}

			$this->defaultSet = $key;
		}

		/**
		 * does a given set exist.
		 *
		 * @param integer|string $key The Set to look for.
		 * @uses sets
		 * @return boolean
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function hasSet($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 1);
			}

			return isset($this->sets[$key]);
		}

		/**
		 * adds a new set to the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @param array $values The key value pairs for the Set.
		 * @uses sets
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws LogicException If $key already exists.
		 */
		public function addSet($key, array $values) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 2);
			}

			if (isset($this->sets[$key])) {
				throw new LogicException('$key already exists!', 3);
			}

			$this->sets[$key] = $values;
		}

		/**
		 * gets a set from the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @uses sets
		 * @return array The key value pairs for the Set.
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws OutOfBoundsException If $key doesn't exist.
		 */
		public function getSet($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 4);
			}

			if (!isset($this->sets[$key])) {
				throw new OutOfBoundsException('$key does not exist!', 5);
			}

			return $this->sets[$key];
		}

		/**
		 * updates set in the object or adds a new one.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @param array $values The key value pairs for the Set.
		 * @uses sets
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function updateSet($key, array $values) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 6);
			}

			$this->sets[$key] = $values;
		}

		/**
		 * deletes a set from the object.
		 *
		 * @param integer|string $key The key used to identify the Set.
		 * @uses sets
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function deleteSet($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 7);
			}

			unset($this->sets[$key]);
		}

		/**
		 * gets all the sets from the object.
		 *
		 * @uses sets
		 * @return array The returned array is an associative array of associative arrays
		 */
		public function getSets() {
			return $this->sets;
		}

		/**
		 * Returns an array of all the set keys in the object.
		 *
		 * @uses sets
		 * @return array
		 */
		public function getSetKeys() {
			return array_keys($this->sets);
		}

		/**
		 * does a given value exist.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to check in. if no key is given
		 * the default Set key is used.
		 * @uses sets
		 * @uses defaultSet
		 * @return boolean
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws OutOfBoundsException If $setKey doesn't exist.
		 */
		public function hasValue($valueKey, $setKey = null) {
			if (!is_string($valueKey) && !is_int($valueKey)) {
				throw new InvalidArgumentException('$valueKey is not a string or integer!', 8);
			}

			if (!isset($setKey)) {
				$setKey = $this->defaultSet;
			}

			if (!is_string($setKey) && !is_int($setKey)) {
				throw new InvalidArgumentException('$setKey is not a string or integer!', 9);
			}

			if (!isset($this->sets[$setKey])) {
				throw new OutOfBoundsException('$setKey does not exist!', 10);
			}

			return isset($this->sets[$setKey][$valueKey]);
		}

		/**
		 * Adds a value to the object
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param mixed $value The value to add
		 * @param integer|string $setKey The key for the set to add the value to. if no key is given
		 * the default Set key is used.
		 * @uses sets
		 * @uses defaultSet
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws LogicException If $valueKey already exists.
		 * @throws OutOfBoundsException If $setKey doesn't exist.
		 */
		public function addValue($valueKey, $value, $setKey = null) {
			if (!is_string($valueKey) && !is_int($valueKey)) {
				throw new InvalidArgumentException('$valueKey is not a string or integer!', 11);
			}

			if (!isset($setKey)) {
				$setKey = $this->defaultSet;
			}

			if (!is_string($setKey) && !is_int($setKey)) {
				throw new InvalidArgumentException('$setKey is not a string or integer!', 12);
			}

			if (!isset($this->sets[$setKey])) {
				throw new OutOfBoundsException('$setKey does not exist!', 13);
			}

			if (isset($this->sets[$setKey][$valueKey])) {
				throw new LogicException('$valueKey already exists!', 14);
			}

			$this->sets[$setKey][$valueKey] = $value;
		}

		/**
		 * Gets a value from the object.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to get the value from. if no key is given
		 * the default Set key is used.
		 * @uses sets
		 * @uses defaultSet
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws OutOfBoundsException If $valueKey or $setKey doesn't exist.
		 */
		public function getValue($valueKey, $setKey = null) {
			if (!is_string($valueKey) && !is_int($valueKey)) {
				throw new InvalidArgumentException('$valueKey is not a string or integer!', 15);
			}

			if (!isset($setKey)) {
				$setKey = $this->defaultSet;
			}

			if (!is_string($setKey) && !is_int($setKey)) {
				throw new InvalidArgumentException('$setKey is not a string or integer!', 16);
			}

			if (!isset($this->sets[$setKey])) {
				throw new OutOfBoundsException('$setKey does not exist!', 17);
			}

			if (!isset($this->sets[$setKey][$valueKey])) {
				throw new OutOfBoundsException('$valueKey does not exist!', 18);
			}

			return $this->sets[$setKey][$valueKey];
		}

		/**
		 * Deletes a value from the object.
		 *
		 * @param integer|string $valueKey The key for the value in question.
		 * @param integer|string $setKey The key for the set to delete the value from. if no key is given
		 * the default Set key is used.
		 * @uses sets
		 * @uses defaultSet
		 * @throws InvalidArgumentException If $valueKey or $setKey isn't a string or Integer.
		 * @throws OutOfBoundsException If $setKey doesn't exist.
		 */
		public function deleteValue($valueKey, $setKey = null) {
			if (!is_string($valueKey) && !is_int($valueKey)) {
				throw new InvalidArgumentException('$valueKey is not a string or integer!', 19);
			}

			if (!isset($setKey)) {
				$setKey = $this->defaultSet;
			}

			if (!is_string($setKey) && !is_int($setKey)) {
				throw new InvalidArgumentException('$setKey is not a string or integer!', 20);
			}

			if (!isset($this->sets[$setKey])) {
				throw new OutOfBoundsException('$setKey does not exist!', 21);
			}

			unset($this->sets[$setKey][$valueKey]);
		}

		/**
		 * Returns an array of all the keys in a given set.
		 *
		 * @param integer|string $key The key for the set to check in. if no key is given
		 * the default Set key is used.
		 * @uses sets
		 * @return array
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 * @throws OutOfBoundsException If $key doesn't exist.
		 */
		public function getValueKeys($key = null) {
			if (!isset($key)) {
				$key = $this->defaultSet;
			}

			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 22);
			}

			if (!isset($this->sets[$key])) {
				throw new OutOfBoundsException('$key does not exist!', 23);
			}

			return array_keys($this->sets[$key]);
		}

		/**
		 * Can be used to set what the default Set should be if one is
		 * not provided to the constructor.
		 *
		 * This method should be overridden in use, because all is does, is select the
		 * first set in the internal array.
		 *
		 * @uses sets
		 * @uses defaultSet
		 * @throws LogicException If no sets exist in the object.
		 */
		public function autoSetDefaultSet() {
			if (count($this->sets) >= 1) {
				$keys = array_keys($this->sets);
				$this->defaultSet = $keys[0];
				return;
			}

			throw new LogicException('No sets exist in the object!', 24);
		}
	}
}