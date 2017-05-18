<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for File input.
	 *
	 * @author Daniel Sherman
	 */
	class File implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the File variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the File variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			return array_key_exists($this->key, $_FILES);
		}

		/**
		 * Returns the value of the File variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the File variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				return $_FILES[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The File variable does not exist', 7);
			}
		}
	}
}