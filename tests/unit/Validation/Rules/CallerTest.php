<?php
namespace Flair\Validation\Rules {

	/**
	 * The Unit test for the Caller class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\Rules\Caller
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
			$this->assertInstanceOf('Flair\Validation\Rules\Caller', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleMessageInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleReplacerInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleMessageTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleReplacerTrait', class_uses($test), $msg);
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
			$test = new Caller('is_string', '', $args);
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
		 * validates isValid returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::isValid
		 */
		public function testIsValid() {
			$test = new Caller('is_string');
			$this->assertTrue($test->isValid('hello World'));
			$this->assertFalse($test->isValid(true));
		}

		/**
		 * validates isValid throws an exception when it doesn't get back a boolean.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::isValid
		 */
		public function testIsValidException() {
			$test = new Caller('implode');

			try {
				$test->isValid(['One', 'Two', 'Three']);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\UnexpectedValueException', $e);
				$this->assertEquals(18, $e->getCode());
				$this->assertEquals('The callable method did not return a boolean!', $e->getMessage());
				return;
			}

			$this->fail('An exception was not thrown for a value');
		}

		/**
		 * validates getErrors works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getErrors
		 */
		public function testGetErrors() {
			$test = new Caller('is_string', 'Hello World!');
			$this->assertEquals(['Hello World!'], $test->getErrors());

			$msg = '_Hello_ _World_!';
			$rep = new \Flair\Validation\Replacer(['Hello' => 'Hi', 'World' => 'People']);
			$test = new Caller('is_string', $msg, [], $rep);
			$this->assertEquals(['Hi People!'], $test->getErrors());
		}

	}
}