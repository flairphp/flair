<?php
namespace Flair\Input\Required {

	/**
	 * The simplest Required object type that just returns a preset value.
	 *
	 * @author Daniel Sherman
	 */
	class Boolean implements \Flair\Input\RequiredInterface {

		/**
		 * The value that will be returned by the required method.
		 *
		 * @var boolean
		 */
		protected $val;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param boolean $val The value that should be returned by the required method.
		 * @uses set
		 * @throws InvalidArgumentException If $val isn't a boolean.
		 */
		public function __construct($val = false) {
			$this->set($val);
		}

		/**
		 * Returns the value of key.
		 *
		 * @uses val
		 * @param boolean $val The value that should be returned by the required method.
		 * @throws InvalidArgumentException If $val isn't a boolean.
		 */
		public function set($val) {
			if(!is_bool($val)){
				throw new \Flair\Input\InvalidArgumentException('$val is not a boolean!', 11);
			}

			$this->val = $val;
		}

		/**
		 * Determines if the associated input is a required one.
		 *
		 * @uses val
		 * @return boolean
		 */
		public function required(){
			return $this->val;
		}
	}
}