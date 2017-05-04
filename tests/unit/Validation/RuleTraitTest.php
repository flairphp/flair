<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the RuleTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\RuleTrait
	 */
	class RuleTraitTest extends \PHPUnit\Framework\TestCase {
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
			self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
			self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;

			require_once self::$fixturePath . 'RuleTraitTestObject.php';

			self::$obj = new RuleTraitTestObject();
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
			$this->assertInstanceOf('Flair\Validation\RuleInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks if we get the correct default halt value
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::halt
		 */
		public function testHaltDefault() {
			$this->assertFalse(self::$obj->halt());
		}

		/**
		 * provides data values that aren't boolean
		 */
		public function nonBooleanProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes(['boolean']));
		}

		/**
		 * Checks if setHalt throws an exception when it should
		 *
		 * @author Daniel Sherman
		 * @test
		 * @dataProvider nonBooleanProvider
		 * @covers ::setHalt
		 */
		public function testSetHaltInvalid($type, $val) {
			try {
				self::$obj->setHalt($val);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(0, $e->getCode());
				$this->assertEquals('$halt is not a bool!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown for a value of type: ' . $type);
		}

		/**
		 * Checks if setHalt works as expected
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::setHalt
		 */
		public function testSetHaltValid() {
			try {
				self::$obj->setHalt(true);
			} catch (\Exception $e) {
				$this->fail('An exception was thrown');
				return;
			}

			// a dummy assertion to deal with phpunit stupidity
			$this->assertEquals(1, 1);
		}

		/**
		 * Checks if we get the correct halt value
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetHaltValid
		 * @covers ::halt
		 */
		public function testHalt() {
			$this->assertTrue(self::$obj->halt());
		}

	}
}
