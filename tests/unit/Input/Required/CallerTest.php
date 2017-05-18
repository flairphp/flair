<?php
namespace Flair\Input\Required {

	/**
	 * The Unit test for the Caller class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\Required\Caller
	 */
	class CallerTest extends \PHPUnit\Framework\TestCase {
		/**
		 * Checks the object uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$test = new Caller('is_string');

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('\Flair\Input\Required\Caller', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Input\RequiredInterface', $test, $msg);
		}

		/**
		 * validates getCallable returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getCallable
		 */
		public function testGetCallable() {
			$test = new Caller('is_string');
			$this->assertEquals('is_string', $test->getCallable());
		}

		/**
		 * Validates setCallable works independently of the constructor.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetCallable
		 * @covers ::setCallable
		 */
		public function testSetCallable() {
			$test = new Caller('is_array');
			$test->setCallable('is_bool');
			$this->assertEquals('is_bool', $test->getCallable());
		}

		/**
		 * validates getArguments returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getArguments
		 */
		public function testGetArguments() {
			$args = ['one', 'two', 'three'];
			$test = new Caller('is_string', $args);
			$this->assertEquals($args, $test->getArguments());
		}

		/**
		 * Validates setArguments works independently of the constructor.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetArguments
		 * @covers ::setArguments
		 */
		public function testSetArguments() {
			$test = new Caller('is_array');
			$args = ['four', 'five', 'six'];
			$test->setArguments($args);
			$this->assertEquals($args, $test->getArguments());
		}

		/**
		 * validates required returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetArguments
		 * @covers ::required
		 */
		public function testRequired() {
			$test = new Caller('is_string', ['string']);
			$this->assertTrue($test->required());

			$test->setArguments([true]);
			$this->assertFalse($test->required());
		}

		/**
		 * validates required throws an exception when it doesn't get back a boolean.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testRequired
		 * @covers ::required
		 */
		public function testRequiredException() {
			$test = new Caller('implode', [['One', 'Two', 'Three']]);

			try {
				$test->required();
			} catch (\Exception $e) {
				$this->assertInstanceOf('\Flair\Input\UnexpectedValueException', $e);
				$this->assertEquals(12, $e->getCode());
				$this->assertEquals('The callable method did not return a boolean!', $e->getMessage());
				return;
			}

			$this->fail('An exception was not thrown for a value');
		}


	}
}