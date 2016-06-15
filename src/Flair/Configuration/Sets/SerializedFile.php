<?php
namespace Flair\Configuration\Sets {

	/**
	 * The class used to turn a Serialized file into a configuration object.
	 *
	 * @author Daniel Sherman
	 */
	class SerializedFile implements \Flair\Configuration\SetsInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Configuration\SetsTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param string $path The file path to serialized configuration file.
		 * @param integer|string $defaultSetKey The key for the default set.
		 * @uses addSet
		 * @uses setDefaultSetKey
		 * @throws \Exception Can throw several different exceptions if parameters are invalid.
		 */
		public function __construct($path, $defaultSetKey = null) {

			if (!is_string($path)) {
				$msg = '$path is not a string!';
				throw new \Flair\Configuration\InvalidArgumentException($msg, 28);
			}

			$file = @file_get_contents($path);
			if ($file === false) {
				$msg = 'Unable to load $path!';
				throw new \Flair\Configuration\RuntimeException($msg, 29);
			}

			$sets = @unserialize($file, ['allowed_classes' => true]);
			if ($sets === false) {
				$msg = 'Unable to unserialize the input file!';
				throw new \Flair\Configuration\RuntimeException($msg, 30);
			}

			if (!is_array($sets)) {
				$msg = 'The unserialized file, is not an array!';
				throw new \Flair\Configuration\RuntimeException($msg, 31);
			}

			foreach ($sets as $key => $values) {
				$this->addSet($key, $values);
			}

			if (isset($defaultSetKey)) {
				$this->setDefaultSetKey($defaultSetKey);
			}
		}
	}
}
