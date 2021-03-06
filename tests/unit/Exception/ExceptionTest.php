<?php
namespace Flair\Exception {
	/**
	 * The Unit test for the Exception class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Exception\Exception
	 */
	class ExceptionTest extends \PHPUnit\Framework\TestCase {
		/**
		 * holds a list of context data.
		 *
		 * @var array
		 */
		protected static $context = [
			'fruit' => [
				'one' => 'Apple',
				'two' => 'Banana',
				'three' => 'Orange',
			],
			'holes' => [
				'first',
				'second',
				'third',
			],
			'nested' => [
				'a' => [1, 2, 3],
				'b' => ['one', 'two', 'three'],
			],
			'random' => 'stuff',
		];

		/**
		 * holds the test message
		 *
		 * @var string
		 */
		protected static $msg = 'My exception message!';

		/**
		 * holds the test code
		 *
		 * @var int
		 */
		protected static $code = 999;

		/**
		 * holds the class name being tested
		 *
		 * @var string
		 */
		protected static $class = 'Flair\Exception\Exception';

		/**
		 * holds the interface name the class should be implementing
		 *
		 * @var string
		 */
		protected static $interface = 'Flair\Exception\ExceptionInterface';

		/**
		 * A data provider that returns an exception with a null previous exception
		 *
		 * @author Daniel Sherman
		 */
		public function nullPreviousExceptionProvider() {
			try {
				throw new self::$class(self::$msg, self::$code, null, self::$context);
			} catch (\Exception $e) {
				return [[$e]];
			}
		}

		/**
		 * A data provider that returns an exception with a previous exception
		 * of the same type
		 *
		 * @author Daniel Sherman
		 */
		public function exceptionProvider() {
			$previous = new self::$class('parent', 1);
			try {
				throw new self::$class(self::$msg, self::$code, $previous, self::$context);
			} catch (\Exception $e) {
				return [[$e]];
			}
		}

		/**
		 * Checks the object is of the correct type, uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::__construct
		 */
		public function testConstruct($e) {
			$msg = 'the object is not the correct type';
			$this->assertInstanceOf(self::$class, $e, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf(self::$interface, $e, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Exception\ExceptionTrait', class_uses($e), $msg);
		}

		/**
		 * Checks the exception Id is of the correct type.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::getId
		 */
		public function testGetIdFromObject($e) {
			$msg = 'the id is not the correct type';
			$this->assertTrue(is_string($e->getId()), $msg);
		}

		/**
		 * Checks the exception context is of the correct type.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::getContext
		 */
		public function testGetContextFromObject($e) {
			$context = $e->getContext();

			$msg = 'the context is not the correct type';
			$this->assertTrue(is_array($context), $msg);

			$msg = 'the context is not what it should be';
			$this->assertEquals(self::$context, $context, $msg);
		}

		/**
		 * Checks the toString function for the context attribute returns the correct type.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::getContextAsString
		 */
		public function testGetContextAsStringFromObject($e) {
			$msg = 'the return value was not what it should be';
			$this->assertTrue(is_string($e->getContextAsString()), $msg);
		}

		/**
		 * Checks __toString() works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::__toString()
		 */
		public function testToStringFromObject($e) {
			$msg = 'the return value was not what it should be';
			$this->assertTrue(is_string($e->__toString()), $msg);
		}

		/**
		 * Checks getPrevious works as expected. when null is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider nullpreviousExceptionProvider
		 * @covers ::getPrevious()
		 */
		public function testGetPreviousNull($e) {
			$msg = 'the object is not the correct type';
			$this->assertNull($e->getPrevious(), $msg);
		}

		/**
		 * Checks getPrevious works as expected. when an exception is returned
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider exceptionProvider
		 * @covers ::getPrevious()
		 */
		public function testGetPrevious($e) {
			$msg = 'the object is not the correct type';
			$this->assertInstanceOf(self::$class, $e->getPrevious(), $msg);
		}
	}
}
