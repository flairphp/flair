<?php
namespace Flair\Configuration\Sets {

	/**
	 * The class used to turn a JSON file into a configuration object.
	 *
	 * It should be noted that json_decode is used with the assoc flag set to true, so any
	 * objects in the file will be converted to arrays.
	 *
	 * @author Daniel Sherman
	 */
	class JsonFile implements \Flair\Configuration\SetsInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Configuration\SetsTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param string $path The file path to json configuration file.
		 * @param integer|string $defaultSetKey The key for the default set.
		 * @uses addSet
		 * @uses setDefaultSetKey
		 * @throws \Exception Can throw several different exceptions if parameters are invalid.
		 */
		public function __construct($path, $defaultSetKey = null) {

			if (!is_string($path)) {
				$msg = '$path is not a string!';
				throw new \Flair\Configuration\InvalidArgumentException($msg, 25);
			}

			$file = @file_get_contents($path);
			if ($file === false) {
				$msg = 'Unable to load $path!';
				throw new \Flair\Configuration\RuntimeException($msg, 26);
			}

			$sets = json_decode($file, true);
			if (is_null($sets)) {
				$msg = 'Unable to json decode the input file!';
				throw new \Flair\Configuration\RuntimeException($msg, 27);
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
