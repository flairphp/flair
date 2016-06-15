<?php
namespace Flair\Configuration {
	/**
	 * The Unit test for the LogicException class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\LogicException
	 */
	class LogicExceptionTest extends \Flair\Exception\LogicExceptionTest {
		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Configuration\LogicException';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Configuration\ExceptionInterface';
	}
}
