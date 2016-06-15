<?php
namespace Flair\Configuration {

	/**
	 * If a class is part of the Flair\Configuration namespace, and it needs to throw a
	 * LogicException then it should use this class to throw it.
	 *
	 * @author Daniel Sherman
	 */
	class LogicException extends \Flair\Exception\LogicException implements ExceptionInterface {}
}
