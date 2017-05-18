<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for Args passed in as CLI input.
	 *
	 * @author Daniel Sherman
	 */
	class Argv implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Argv variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Argv variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			global $argv;

			if(isset($argv)){
				return array_key_exists($this->key, $argv);
			}

			return false;
		}

		/**
		 * Returns the value of the Argv variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Argv variable doesn't exist.
		 */
		public function get(){
			global $argv;

			if($this->exists()){
				return $argv[$this->key];
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Argv variable does not exist', 8);
			}
		}
	}
}