<?php
namespace Flair\Configuration\Sets {

	/**
	 * The simplest implementation of a Sets object. It takes a 2 dimensional array as input.
	 *
	 * @author Daniel Sherman
	 */
	class Arrays implements \Flair\Configuration\SetsInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Configuration\SetsTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param array $rules An array of configuration arrays.
		 * @param integer|string $defaultSetKey The key for the default set.
		 * @uses addSet
		 * @uses setDefaultSetKey
		 * @throws \Exception Can throw several different exceptions if parameters are invalid.
		 */
		public function __construct(array $sets = [], $defaultSetKey = null) {
			foreach ($sets as $key => $values) {
				$this->addSet($key, $values);
			}

			if (isset($defaultSetKey)) {
				$this->setDefaultSetKey($defaultSetKey);
			}
		}
	}
}
