<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Env input.
	 *
	 * @author Daniel Sherman
	 */
	class Env implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Env variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Env variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_ENV);
		}

		/**
		 * Returns the value of the Env variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Env variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_ENV[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Env variable does not exist', 5);
			}
		}
	}
}