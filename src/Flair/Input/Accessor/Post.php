<?php
namespace Flair\Input\Accessor {

	/**
	 * The simplest implementation of a Sets object. It takes a 2 dimensional array as input.
	 *
	 * @author Daniel Sherman
	 */
	class Post implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Post variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Post variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($_POST, $this->key);
		}

		/**
		 * Returns the value of the Post variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Post variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_POST[$this->key];
			}
		}
	}
}