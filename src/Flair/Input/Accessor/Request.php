<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Request input.
	 *
	 * @author Daniel Sherman
	 */
	class Request implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Request variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Request variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_REQUEST);
		}

		/**
		 * Returns the value of the Request variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Request variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_REQUEST[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Request variable does not exist', 3);
			}
		}
	}
}