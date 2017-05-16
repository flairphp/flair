<?php
namespace Flair\Input\Accessor {

	/**
	 * The Unit test for the Post class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\Accessor\Post
	 * @backupGlobals enabled
	 */
	class PostTest extends \PHPUnit\Framework\TestCase {
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
			$_POST['testInput'] = 'testInputValue';

			self::$obj = new Post('testInputNone');
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
			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Input\Accessor\Post', self::$obj, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Input\AccessorInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Input\AccessorKeyTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks that the correct key is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getKey
		 */
		public function testGetKey() {
			$msg = "The proper key was not returned as expected";
			$this->assertEquals('testInputNone', self::$obj->getKey(), $msg);
		}

		/**
		 * Checks that setKey works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetKey
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

		/**
		 * Checks that the correct key is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetKey
		 * @covers ::exists
		 */
		public function testExists() {
			self::$obj->setKey('testInputNone');
			$this->assertFalse(self::$obj->exists());

			self::$obj->setKey('testInput');
			$this->assertTrue(self::$obj->exists());
		}

		/**
		 * Checks that the correct value is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testExists
		 * @covers ::get
		 */
		public function testGet() {
			$msg = "The proper value was not returned";
			$this->assertEquals('testInputValue', self::$obj->get(), $msg);
		}

		/**
		 * Checks that an exception is thrown when a non existent key is requested.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGet
		 * @covers ::get
		 */
		public function testGetException() {
			self::$obj->setKey('testInputNone');

			try {
				self::$obj->get();
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Input\OutOfBoundsException', $e);
				$this->assertEquals(1, $e->getCode());
				$this->assertEquals('The Post variable does not exist', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}
	}
}