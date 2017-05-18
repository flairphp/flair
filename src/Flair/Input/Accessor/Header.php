<?php
namespace Flair\Input\Accessor {

	/**
	 * The Accessor for a header.
	 *
	 * Please note that this class can't be unit tested.
	 *
	 * @author Daniel Sherman
	 */
	class Header implements \Flair\Input\AccessorInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Input\AccessorKeyTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param integer|string $key The key for the Header variable.
		 * @uses setKey
		 * @throws InvalidArgumentException If $key isn't a string or Integer.
		 */
		public function __construct($key) {
			$this->setKey($key);
		}

		/**
		 * Checks to see if the Header variable is present/available.
		 *
		 * @return boolean
		 */
		public function exists(){
			if(function_exists('apache_request_headers')){
				$headers = apache_request_headers();

				if($headers !== false){
					return array_key_exists($this->key, $headers);
				}

				return false;
			}

			return false;
		}

		/**
		 * Returns the value of the Header variable if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the Header variable doesn't exist.
		 */
		public function get(){
			if($this->exists()){
				$headers = apache_request_headers();
				return array_key_exists($this->key, $headers);
			}else{
				throw new \Flair\Input\OutOfBoundsException('The Header variable does not exist', 9);
			}
		}
	}
}