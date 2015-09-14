<?php
namespace Flair\Validation {
	/**
	 * The Unit test for the OutOfBoundsException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\OutOfBoundsException
	 */
	class OutOfBoundsExceptionTest extends \Flair\Exception\OutOfBoundsExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Validation\OutOfBoundsException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Validation\ExceptionInterface';
	}
}
