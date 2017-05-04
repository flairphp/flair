<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the RuleMessageTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\ReplacerTrait
	 */
	class RuleMessageTraitTest extends \PHPUnit\Framework\TestCase {
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

			require_once self::$fixturePath . 'RuleMessageTraitTestObject.php';

			self::$obj = new RuleMessageTraitTestObject();
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
			$this->assertInstanceOf('Flair\Validation\RuleMessageInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleMessageTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks to see if get message returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getMessage
		 */
		public function testGetMessage() {
			$this->assertEquals('', self::$obj->getMessage());
		}

		/**
		 * provides data values that aren't strings
		 */
		public function nonStringProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes(['string']));
		}

		/**
		 * Checks if setMessage throws an exception when it should
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @dataProvider nonStringProvider
		 * @covers ::setMessage
		 */
		public function testSetMessageInvalid($type, $val) {
			try {
				self::$obj->setMessage($val);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
				$this->assertEquals(1, $e->getCode());
				$this->assertEquals('$message is not a string!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown for a value of type: ' . $type);
		}

		/**
		 * Checks if setMessage throws an exception when it shouldn't
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::setMessage
		 */
		public function testSetMessageValid() {
			try {
				self::$obj->setMessage('Hello World!');
			} catch (\Exception $e) {
				$this->fail('An exception was thrown');
				return;
			}

			// a dummy assertion to deal with phpunit stupidity
			$this->assertEquals(1, 1);
		}

		/**
		 * Checks if set and get message work together as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetMessage
		 * @depends testSetMessageValid
		 * @covers ::setMessage
		 * @covers ::getMessage
		 */
		public function testSetAndgetMessageValid() {
			$msg = 'I was Saved';
			self::$obj->setMessage($msg);
			$this->assertEquals($msg, self::$obj->getMessage());
		}

	}
}
