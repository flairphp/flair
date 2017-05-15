<?php
namespace Flair\Input {
	/**
	 * The Unit test for the InvalidArgumentException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\InvalidArgumentException
	 */
	class InvalidArgumentExceptionTest extends \Flair\Exception\InvalidArgumentExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Input\InvalidArgumentException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Input\ExceptionInterface';
	}
}
