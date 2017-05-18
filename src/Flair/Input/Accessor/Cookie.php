<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Cookie input.
	 *
	 * @author Daniel Sherman
	 */
	class Cookie implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Cookie variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Cookie variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_COOKIE);
		}

		/**
		 * Returns the value of the Cookie variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Cookie variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_COOKIE[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Cookie variable does not exist', 6);
			}
		}
	}
}