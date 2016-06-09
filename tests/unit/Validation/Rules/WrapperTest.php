<?php
namespace Flair\Validation\Rules {

	/**
	 * The Unit test for the Wrapper class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\Rules\Wrapper
	 */
	class WrapperTest extends \Flair\PhpUnit\TestCase {
		/**
		 * set up the needed data before the testing starts.
		 */
		public static function setUpBeforeClass() {
			self::addDependentTestCase('Flair\Validation\RuleTraitTest');
			self::addDependentTestCase('Flair\Validation\RuleMessageTraitTest');
			self::addDependentTestCase('Flair\Validation\RuleReplacerTraitTest');
			self::addDependentTestCase('Flair\Validation\RuleGroupTraitTest');
			self::skipTestCaseOnFailedDependencies();
		}

		/**
		 * mark the test finished.
		 */
		public static function tearDownAfterClass() {
			self::setFinishedTest();
		}

		/**
		 * Checks the object uses the correct traits, and
		 * implements the correct interfaces.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$test = new Wrapper();

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleMessageInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleReplacerInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleGroupInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleMessageTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleReplacerTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleGroupTrait', class_uses($test), $msg);
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
			$rules = [
				0 => new Caller(
					'is_string',
					'input is not a string'
				),
				1 => new Caller(
					function ($email) {
						$regex = ";^[a-z0-9!#$%&'*+/\=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/\=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$;i";

						if (preg_match($regex, $email) === 1) {
							return true;
						}
						return false;
					},
					'input is not a valid email address'
				),
			];

			$msg = 'The wrapper error message';

			$test = new Wrapper($rules, $msg);

			$this->assertEquals([$msg], $test->getErrors());
		}

	}
}