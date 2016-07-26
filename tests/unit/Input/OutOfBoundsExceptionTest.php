<?php
namespace Flair\Input {
	/**
	 * The Unit test for the OutOfBoundsException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\OutOfBoundsException
	 */
	class OutOfBoundsExceptionTest extends \Flair\Exception\OutOfBoundsExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Input\OutOfBoundsException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Input\ExceptionInterface';
	}
}
