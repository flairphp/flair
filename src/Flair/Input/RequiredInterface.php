<?php
namespace Flair\Input {

	/**
	 * The blueprint to build input Required objects against.
	 *
	 * @author Daniel Sherman
	 */
	interface RequiredInterface {

		/**
		 * Determines if the associated input is a required one.
		 *
		 * @return boolean
		 */
		public function required();
	}
}