<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the RuleGroupTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\RuleGroupTrait
	 */
	class RuleGroupTraitTest extends \Flair\PhpUnit\TestCase {
		/**
		 * holds the path to the fixture directory
		 *
		 * @var string
		 */
		protected static $fixturePath = null;

		/**
		 *  The object being tested
		 *
		 * @var mixed
		 */
		protected static $obj = null;

		/**
		 * set up the needed data before the testing starts.
		 */
		public static function setUpBeforeClass() {
			self::addDependentTestCase('Flair\Validation\Rules\CallerTest');
			self::skipTestCaseOnFailedDependencies();

			self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
			self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;

			require_once self::$fixturePath . 'RuleGroupTraitTestObject.php';

			self::$obj = new RuleGroupTraitTestObject();
		}

		/**
		 * mark the test finished.
		 */
		public static function tearDownAfterClass() {
			self::setFinishedTest();
		}

		/**
		 * Checks the object uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleGroupInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleGroupTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks that addRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::addRule
		 */
		public function testAddRuleInvalid() {
			$rule = new Rules\Caller('is_string');

			try {
				self::$obj->addRule(false, $rule);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(13, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that addRule works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::addRule
		 */
		public function testAddRuleValid() {
			$rule = new Rules\Caller('is_string');

			try {
				self::$obj->addRule(0, $rule);
			} catch (\Exception $e) {
				$this->fail('An exception was thrown');
				return;
			}

			// a dummy assertion to deal with phpunit stupidity
			$this->assertEquals(1, 1);
		}

		/**
		 * Checks that hasRule works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddRuleValid
		 * @covers ::hasRule
		 */
		public function testHasRuleValid() {
			$this->assertTrue(self::$obj->hasRule(0));
		}

		/**
		 * Checks that hasRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::hasRule
		 */
		public function testHasRuleInvalid() {
			try {
				self::$obj->hasRule(false);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(12, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that getRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddRuleValid
		 * @covers ::getRule
		 */
		public function testGetRuleInvalid() {
			try {
				self::$obj->getRule(1);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\OutOfBoundsException', $e);
				$this->assertEquals(16, $e->getCode());
				$this->assertEquals('$key does not exist!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that getRule works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddRuleValid
		 * @covers ::getRule
		 */
		public function testGetRuleValid() {
			$rule = new Rules\Caller('is_string');
			self::$obj->addRule(1, $rule);

			$got = self::$obj->getRule(1);
			$this->assertSame($rule, $got);
		}

		/**
		 * Checks that updateRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::updateRule
		 */
		public function testUpdateRuleInvalid() {
			$rule = new Rules\Caller('is_string');

			try {
				self::$obj->UpdateRule(false, $rule);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(15, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that updateRule works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetRuleValid
		 * @covers ::updateRule
		 */
		public function testUpdateRuleValid() {
			$rule = new Rules\Caller('is_string');
			self::$obj->UpdateRule(1, $rule);

			$got = self::$obj->getRule(1);
			$this->assertSame($rule, $got);
		}

		/**
		 * Checks that deleteRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testUpdateRuleValid
		 * @covers ::deleteRule
		 */
		public function testDeleteRuleInvalid() {
			try {
				self::$obj->deleteRule(false);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(17, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that deleteRule fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testUpdateRuleValid
		 * @depends testAddRuleValid
		 * @depends testHasRuleValid
		 * @covers ::deleteRule
		 */
		public function testDeleteRuleValid() {
			$this->assertTrue(self::$obj->hasRule(1));
			self::$obj->deleteRule(1);
			$this->assertFalse(self::$obj->hasRule(1));

			$this->assertTrue(self::$obj->hasRule(0));
			self::$obj->deleteRule(0);
			$this->assertFalse(self::$obj->hasRule(0));
		}

		/**
		 * Checks that addRules works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testDeleteRuleValid
		 * @covers ::addRules
		 */
		public function testAddRulesValid() {
			try {
				self::$obj->addRules([0 => new Rules\Caller('is_string')]);
			} catch (\Exception $e) {
				$this->fail('An exception was thrown');
				return;
			}

			// a dummy assertion to deal with phpunit stupidity
			$this->assertEquals(1, 1);
		}

		/**
		 * Checks that addRules fails as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddRulesValid
		 * @covers ::addRules
		 */
		public function testAddRulesInvalid() {
			try {
				self::$obj->addRules([0 => new Rules\Caller('is_string')]);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\LogicException', $e);
				$this->assertEquals(14, $e->getCode());
				$this->assertEquals('$key already exists!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that isValid returns true when expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddRulesValid
		 * @covers ::isValid
		 */
		public function testIsValidTrue() {
			// delete the old rule
			self::$obj->deleteRule(0);

			//add the new rules
			self::$obj->addRules(
				[
					0 => new Rules\Caller(
						'is_string',
						'input is not a string'
					),
					1 => new Rules\Caller(
						function ($email) {
							$regex = ";^[a-z0-9!#$%&'*+/\=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/\=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$;i";

							if (preg_match($regex, $email) === 1) {
								return true;
							}
							return false;
						},
						'input is not a valid email address'
					),
				]
			);

			$this->assertTrue(self::$obj->isValid('hello@world.com'));
		}

		/**
		 * Checks that isValid returns false when expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testIsValidTrue
		 * @covers ::isValid
		 */
		public function testIsValidFalse() {
			$this->assertFalse(self::$obj->isValid('hello@world'));
		}

		/**
		 * Checks that isValid returns false when expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testIsValidFalse
		 * @covers ::isValid
		 * @covers ::getInvalidRulekeys
		 * @covers ::getErrors
		 */
		public function testErrorHandling() {
			$result = self::$obj->isValid(true);
			$this->assertFalse($result);
			$this->assertEquals([0, 1], self::$obj->getInvalidRulekeys());
			$this->assertEquals([0 => ['input is not a string'], 1 => ['input is not a valid email address']], self::$obj->getErrors());

			// set the halt flag on the first rule
			self::$obj->getRule(0)->setHalt(true);

			// test the second round
			$result = self::$obj->isValid(true);
			$this->assertFalse($result);
			$this->assertEquals([0], self::$obj->getInvalidRulekeys());
			$this->assertEquals([0 => ['input is not a string']], self::$obj->getErrors());

			// test the third round
			$result = self::$obj->isValid('hello.world');
			$this->assertFalse($result);
			$this->assertEquals([1], self::$obj->getInvalidRulekeys());
			$this->assertEquals([1 => ['input is not a valid email address']], self::$obj->getErrors());
		}
	}
}