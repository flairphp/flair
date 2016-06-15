<?php
namespace Flair\Configuration {

	/**
	 * A class to allow testing SetsTrait & SetsInterface
	 *
	 * @author Daniel Sherman
	 */
	class SetsTraitTestObject implements SetsInterface {

		/**
		 * Add the needed methods.
		 */
		use SetsTrait;
	}
}
