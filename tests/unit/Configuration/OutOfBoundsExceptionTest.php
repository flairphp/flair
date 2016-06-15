<?php
namespace Flair\Configuration {
	/**
	 * The Unit test for the OutOfBoundsException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\OutOfBoundsException
	 */
	class OutOfBoundsExceptionTest extends \Flair\Exception\OutOfBoundsExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Configuration\OutOfBoundsException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Configuration\ExceptionInterface';
	}
}
