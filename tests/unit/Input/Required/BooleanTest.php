<?php
namespace Flair\Input\Required {

	/**
	 * The Unit test for the Boolean class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Input\Required\Boolean
	 * @backupGlobals enabled
	 */
	class BooleanTest extends \PHPUnit\Framework\TestCase {
		/**
		 *  The object being tested
		 *
		 * @var mixed
		 */
		protected static $obj = null;

		/**
		 * Checks the object is of the correct type, and implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$obj = new Boolean();

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Input\Required\Boolean', $obj, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Input\RequiredInterface', $obj, $msg);
		}

		/**
		 * Checks that set throws an exception when it doesn't get a boolean.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @dataProvider nonBooleanProvider
		 * @covers ::set
		 */
		public function testSetException($type, $val) {
			$obj = new Boolean();

			try {
				$obj->set($val);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Input\InvalidArgumentException', $e);
				$this->assertEquals(11, $e->getCode());
				$this->assertEquals('$val is not a boolean!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown for a value of type: ' . $type);
		}

		/**
		 * Checks that __construct throws an exception when it doesn't get a boolean.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetException
		 * @dataProvider nonBooleanProvider
		 * @covers ::__construct
		 */
		public function testConstructException($type, $val) {
			try {
				$obj = new Boolean($val);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Input\InvalidArgumentException', $e);
				$this->assertEquals(11, $e->getCode());
				$this->assertEquals('$val is not a boolean!', $e->getMessage());
				return;
			}
		}
			
		/**
		 * provides a non boolean input for some tests
		 */
		public function nonBooleanProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes(['boolean']));
		}

		/**
		 * Checks that required returns the value set by the constructor or set method.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstructException
		 * @covers ::required
		 */
		public function testRequired() {
			$obj = new Boolean();
			$this->assertFalse($obj->required());

			$obj = new Boolean(false);
			$this->assertFalse($obj->required());

			$obj->set(true);
			$this->assertTrue($obj->required());

			$obj = new Boolean(true);
			$this->assertTrue($obj->required());

			$obj->set(false);
			$this->assertFalse($obj->required());
		}
	}
}