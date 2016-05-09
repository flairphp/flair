<?php
namespace Flair\Validation\Rules {

	/**
	 * The Unit test for the Caller class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\Rules\Caller
	 */
	class CallerTest extends \Flair\PhpUnit\TestCase {
		/**
		 * set up the needed data before the testing starts.
		 */
		public static function setUpBeforeClass() {
			self::addDependentTestCase('Flair\Validation\RuleTraitTest');
			self::addDependentTestCase('Flair\Validation\RuleMessageTraitTest');
			self::addDependentTestCase('Flair\Validation\RuleReplacerTraitTest');
			self::skipTestCaseOnFailedDependencies();
		}

		/**
		 * mark the test finished.
		 */
		public static function tearDownAfterClass() {
			self::setFinishedTest();
		}

		/**
		 * dummy test
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

	}
}