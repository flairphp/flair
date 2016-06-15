<?php
namespace Flair\Configuration {

	/**
	 * If a class is part of the Flair\Configuration namespace, and it needs to throw a
	 * RuntimeException then it should use this class to throw it.
	 *
	 * @author Daniel Sherman
	 */
	class RuntimeException extends \Flair\Exception\RuntimeException implements ExceptionInterface {}
}
