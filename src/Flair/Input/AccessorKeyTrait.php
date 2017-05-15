<?php
namespace Flair\Input {

	/**
	 * A simple trait to provide the basic methods needed by the default accessors.
	 *
	 * @author Daniel Sherman
	 */
	trait AccessorKeyTrait {

		/**
		 * The key used when accessing the standard input arrays.
		 *
		 * @var string|integer|null
		 */
		protected $key = null;


		/**
		 * Returns the value of key.
		 *
		 * @uses key
		 * @return string|integer|null
		 */
		public function getKey() {
			return $this->key;
		}

		/**
		 * Set the value of the key.
		 *
		 * @param integer|string $key The key used when accessing the standard input arrays.
		 * @uses key
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function setKey($key) {
			if (!is_string($key) && !is_int($key)) {
				throw new InvalidArgumentException('$key is not a string or integer!', 0);
			}

			$this->key = $key;
		}
	}
}