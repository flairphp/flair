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
	}
}