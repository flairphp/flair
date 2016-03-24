<?php
namespace Flair\Validation {

	/**
	 * If a class is part of the Flair\Validation namespace, and it needs to throw a
	 * OutOfBoundsException it should use this class to throw it.
	 *
	 * @author Daniel Sherman
	 */
	class OutOfBoundsException extends \Flair\Exception\OutOfBoundsException implements ExceptionInterface {}
}
