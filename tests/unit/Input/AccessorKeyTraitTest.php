<?php
namespace Flair\Input {

	/**
	 * The Unit test for the AccessorKeyTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\AccessorKeyTrait
	 */
	class AccessorKeyTraitTest extends \PHPUnit\Framework\TestCase {
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

			require_once self::$fixturePath . 'AccessorKeyTraitTestObject.php';

			self::$obj = new AccessorKeyTraitTestObject();
		}

		/**
		 * Checks the object uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 */
		public function testConstruct() {
			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Input\AccessorKeyTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks that the correct default set key is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getKey
		 */
		public function testGetKeyDefault() {
			$this->assertNull(self::$obj->getKey());
		}

		/**
		 * Checks that setKey works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetKeyDefault
		 * @dataProvider setKeyTypeConstraintProvider
		 * @covers ::setKey
		 */
		public function testSetKey($type, $val) {
			self::$obj->setKey($val);
			$msg = "$val was not returned as expected";
			$this->assertEquals($val, self::$obj->getKey(), $msg);
		}

		/**
		 * provides data for testSetKey
		 */
		public function setKeyTypeConstraintProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
			return $data->arrayOfArrays($data->includeTypes(['string', 'integer']));
		}

		/**
		 * Checks that setKey throws an exception when expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetKey
		 * @dataProvider setKeyExceptionTypeConstraintProvider
		 * @covers ::setKey
		 */
		public function testSetKeyException($type, $val) {
			try {
				self::$obj->setKey($val);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Input\InvalidArgumentException', $e);
				$this->assertEquals(0, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown for a value of type: ' . $type);
		}

		/**
		 * provides data for testSetKey
		 */
		public function setKeyExceptionTypeConstraintProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes(['string', 'integer']));
		}
	}
}
