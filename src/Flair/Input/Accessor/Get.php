<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Get input.
	 *
	 * @author Daniel Sherman
	 */
	class Get implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Get variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Get variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_GET);
		}

		/**
		 * Returns the value of the Get variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Get variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_GET[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Get variable does not exist', 2);
			}
		}
	}
}