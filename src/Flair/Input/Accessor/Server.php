<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Server input.
	 *
	 * @author Daniel Sherman
	 */
	class Server implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Server variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Server variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_SERVER);
		}

		/**
		 * Returns the value of the Server variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Server variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_SERVER[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Server variable does not exist', 4);
			}
		}
	}
}