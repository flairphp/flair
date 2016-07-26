<?php
namespace Flair\Input {

	/**
	 * The blueprint to build input Accessors against, and hint for all Accessors with.
	 *
	 * @author Daniel Sherman
	 */
	interface AccessorInterface {

		/**
		 * Checks to see if the input is present/available
		 *
		 * @return boolean
		 */
		public function exists();

		/**
		 * Returns the value of the input if it exists.
		 *
		 * @uses exists
		 * @return mixed
		 * @throws OutOfBoundsException If the input doesn't exist.
		 */
		public function get();

		/**
		 * Indicates if an input is required.
		 *
		 * @return boolean
		 */
		public function required();

		/**
		 * Indicates if an input is valid.
		 *
		 * @return boolean
		 * @uses get
		 * @throws OutOfBoundsException If the input doesn't exist.
		 */
		public function valid();

		/**
		 * checks if the input exists and is valid.
		 *
		 * @uses exists
		 * @uses valid
		 * @return boolean
		 */
		public function existsAndValid();

	}
}