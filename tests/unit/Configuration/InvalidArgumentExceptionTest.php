<?php
namespace Flair\Configuration {
	/**
	 * The Unit test for the InvalidArgumentException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\InvalidArgumentException
	 */
	class InvalidArgumentExceptionTest extends \Flair\Exception\InvalidArgumentExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Configuration\InvalidArgumentException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Configuration\ExceptionInterface';
	}
}
