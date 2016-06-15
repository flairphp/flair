<?php
namespace Flair\Configuration {
	/**
	 * The Unit test for the RuntimeException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\RuntimeException
	 */
	class RuntimeExceptionTest extends \Flair\Exception\RuntimeExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Configuration\RuntimeException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Configuration\ExceptionInterface';
	}
}
