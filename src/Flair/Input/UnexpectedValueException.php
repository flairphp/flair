<?php
namespace Flair\Input {

	/**
	 * If a class is part of the Flair\Input namespace, and it needs to throw a
	 * UnexpectedValueException it should use this class to throw it.
	 *
	 * @author Daniel Sherman
	 */
	class UnexpectedValueException extends \Flair\Exception\UnexpectedValueException implements ExceptionInterface {}
}
