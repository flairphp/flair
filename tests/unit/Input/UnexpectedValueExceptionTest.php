<?php
namespace Flair\Input {
	/**
	 * The Unit test for the UnexpectedValueException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\UnexpectedValueException
	 */
	class UnexpectedValueExceptionTest extends \Flair\Exception\UnexpectedValueExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Input\UnexpectedValueException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Input\ExceptionInterface';
	}
}
