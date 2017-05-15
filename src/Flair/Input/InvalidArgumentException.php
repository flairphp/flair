<?php
namespace Flair\Input {

	/**
	 * If a class is part of the Flair\Input namespace, and it needs to throw a
	 * InvalidArgumentExceptionthen it should use this class to throw it.
	 *
	 * @author Daniel Sherman
	 */
	class InvalidArgumentException extends \Flair\Exception\InvalidArgumentException implements ExceptionInterface {}
}
