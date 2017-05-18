<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Session input.
	 *
	 * Please note, this class will not start or close a session. It only interacts 
	 * with $_SESSION if it exists.
	 *
	 * @author Daniel Sherman
	 */
	class Session implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Session variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Session variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			if(isset($_SESSION)){
				return array_key_exists($this->key, $_SESSION);
			}

			return false;
		}

		/**
		 * Returns the value of the Session variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Session variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_SESSION[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Session variable does not exist', 10);
			}
		}
	}
}