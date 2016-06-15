<?php
namespace Flair\Configuration {

	/**
	 * The Unit test for the SetsTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\SetsTrait
	 */
	class SetsTraitTest extends \Flair\PhpUnit\TestCase {
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

			require_once self::$fixturePath . 'SetsTraitTestObject.php';

			self::$obj = new SetsTraitTestObject();
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
		 */
		public function testTraitAndInterface() {
			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Configuration\SetsInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Configuration\SetsTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks that the correct default set key is returned.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testTraitAndInterface
		 * @covers ::getDefaultSetKey
		 */
		public function testGetDefaultSetKey() {
			$this->assertNull(self::$obj->getDefaultSetKey());
		}

		/**
		 * Checks that when setting the default set key, the correct exception is thrown.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetDefaultSetKey
		 * @covers ::setDefaultSetKey
		 */
		public function testSetDefaultSetKeyInvalid() {
			try {
				self::$obj->setDefaultSetKey(null);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(0, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that the correct default set key is set.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetDefaultSetKey
		 * @covers ::setDefaultSetKey
		 */
		public function testSetDefaultSetKeyValid() {
			self::$obj->setDefaultSetKey(1);
			$this->assertEquals(1, self::$obj->getDefaultSetKey());

			self::$obj->setDefaultSetKey('one');
			$this->assertEquals('one', self::$obj->getDefaultSetKey());
		}

		/**
		 * Checks that hasSet works as expected when given bad data.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testTraitAndInterface
		 * @covers ::hasSet
		 */
		public function testHasSetInvalid() {
			try {
				self::$obj->hasSet(null);
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(1, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
				return;
			}
			$this->fail('An exception was not thrown');
		}

		/**
		 * Checks that hasSet works as expected when given good data.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testTraitAndInterface
		 * @covers ::hasSet
		 */
		public function testHasSetValid() {
			$this->assertFalse(self::$obj->hasSet('one'));
		}

		/**
		 * Checks that addSet works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testTraitAndInterface
		 * @depends testHasSetValid
		 * @covers ::addSet
		 * @covers ::hasSet
		 */
		public function testAddSet() {
			try {
				self::$obj->addSet(null, []);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(2, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
			}

			self::$obj->addSet('one', ['one', 'two', 'three', 'four']);
			$this->assertTrue(self::$obj->hasSet('one'));

			try {
				self::$obj->addSet('one', []);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\LogicException', $e);
				$this->assertEquals(3, $e->getCode());
				$this->assertEquals('$key already exists!', $e->getMessage());
				return;
			}
		}

		/**
		 * Checks that getSet works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @covers ::getSet
		 */
		public function testGetSet() {
			try {
				self::$obj->getSet(null);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(4, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->getSet('two');
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(5, $e->getCode());
				$this->assertEquals('$key does not exist!', $e->getMessage());
			}

			$this->assertEquals(['one', 'two', 'three', 'four'], self::$obj->getSet('one'));
		}

		/**
		 * Checks that updateSet works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @depends testGetSet
		 * @covers ::updateSet
		 */
		public function testUpdateSet() {
			$set = [1, 2, 3, 4];
			try {
				self::$obj->updateSet(null, $set);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(6, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
			}

			self::$obj->updateSet('one', $set);
			$this->assertEquals($set, self::$obj->getSet('one'));
		}

		/**
		 * Checks that getSetKeys works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @covers ::getSetKeys
		 */
		public function testGetSetKeys() {
			$this->assertEquals(['one'], self::$obj->getSetKeys());
		}

		/**
		 * Checks that getSets works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @covers ::getSets
		 */
		public function testGetSets() {
			$expected = ['one' => [1, 2, 3, 4]];
			$this->assertEquals($expected, self::$obj->getSets());
		}

		/**
		 * Checks that deleteSet works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @depends testGetSets
		 * @covers ::deleteSet
		 */
		public function testDeleteSet() {
			try {
				self::$obj->deleteSet(null);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(7, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
			}

			self::$obj->deleteSet('one');
			$this->assertEquals([], self::$obj->getSets());
		}

		/**
		 * Checks that hasValue works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddSet
		 * @depends testSetDefaultSetKeyValid
		 * @covers ::hasValue
		 */
		public function testHasValue() {
			$set = [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four'];
			self::$obj->addSet('one', $set);
			self::$obj->SetDefaultSetKey(2);

			try {
				self::$obj->hasValue(null);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(8, $e->getCode());
				$this->assertEquals('$valueKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->hasValue(1, true);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(9, $e->getCode());
				$this->assertEquals('$setKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->hasValue(1);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(10, $e->getCode());
				$this->assertEquals('$setKey does not exist!', $e->getMessage());
			}

			$this->assertTrue(self::$obj->hasValue(1, 'one'));
			self::$obj->SetDefaultSetKey('one');
			$this->assertTrue(self::$obj->hasValue(1));

			$this->assertFalse(self::$obj->hasValue(10, 'one'));
			$this->assertFalse(self::$obj->hasValue(10));
		}

		/**
		 * Checks that addValue works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testHasValue
		 * @depends testSetDefaultSetKeyValid
		 * @depends testGetSet
		 * @covers ::AddValue
		 */
		public function testAddValue() {
			self::$obj->SetDefaultSetKey(2);

			try {
				self::$obj->addValue(null, 'hello');
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(11, $e->getCode());
				$this->assertEquals('$valueKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->addValue(1, 'hello', true);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(12, $e->getCode());
				$this->assertEquals('$setKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->addValue(1, 'hello');
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(13, $e->getCode());
				$this->assertEquals('$setKey does not exist!', $e->getMessage());
			}

			try {
				self::$obj->addValue(1, 'hello', 'one');
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\LogicException', $e);
				$this->assertEquals(14, $e->getCode());
				$this->assertEquals('$valueKey already exists!', $e->getMessage());
			}

			self::$obj->SetDefaultSetKey('one');
			self::$obj->addValue(5, 'five', 'one');
			self::$obj->addValue(6, 'six', 'one');

			$expected = [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six'];
			$this->assertEquals($expected, self::$obj->getSet('one'));
		}

		/**
		 * Checks that getValue works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testHasValue
		 * @depends testAddValue
		 * @depends testSetDefaultSetKeyValid
		 * @covers ::getValue
		 */
		public function testGetValue() {
			self::$obj->SetDefaultSetKey(2);

			try {
				self::$obj->getValue(null);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(15, $e->getCode());
				$this->assertEquals('$valueKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->getValue(1, true);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(16, $e->getCode());
				$this->assertEquals('$setKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->getValue(1);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(17, $e->getCode());
				$this->assertEquals('$setKey does not exist!', $e->getMessage());
			}

			try {
				self::$obj->getValue(18, 'one');
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(18, $e->getCode());
				$this->assertEquals('$valueKey does not exist!', $e->getMessage());
			}

			self::$obj->SetDefaultSetKey('one');
			$this->assertEquals('five', self::$obj->getValue(5, 'one'));
			$this->assertEquals('six', self::$obj->getValue(6));
		}

		/**
		 * Checks that deleteValue works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testHasValue
		 * @depends testAddValue
		 * @depends testSetDefaultSetKeyValid
		 * @depends testGetSet
		 * @covers ::deleteValue
		 */
		public function testDeleteValue() {
			self::$obj->SetDefaultSetKey(2);

			try {
				self::$obj->deleteValue(null);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(19, $e->getCode());
				$this->assertEquals('$valueKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->deleteValue(1, true);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(20, $e->getCode());
				$this->assertEquals('$setKey is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->deleteValue(1);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(21, $e->getCode());
				$this->assertEquals('$setKey does not exist!', $e->getMessage());
			}

			self::$obj->SetDefaultSetKey('one');
			self::$obj->deleteValue(5, 'one');
			self::$obj->deleteValue(6);

			$expected = [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four'];
			$this->assertEquals($expected, self::$obj->getSet('one'));
		}

		/**
		 * Checks that getValueKeys works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testDeleteValue
		 * @depends testSetDefaultSetKeyValid
		 * @covers ::getValueKeys
		 */
		public function testGetValueKeys() {
			self::$obj->SetDefaultSetKey(2);

			try {
				self::$obj->getValueKeys(false);
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(22, $e->getCode());
				$this->assertEquals('$key is not a string or integer!', $e->getMessage());
			}

			try {
				self::$obj->getValueKeys();
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\OutOfBoundsException', $e);
				$this->assertEquals(23, $e->getCode());
				$this->assertEquals('$key does not exist!', $e->getMessage());
			}

			self::$obj->SetDefaultSetKey('one');
			$this->assertEquals([1, 2, 3, 4], self::$obj->getValueKeys());
		}

		/**
		 * Checks that getValueKeys works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testDeleteSet
		 * @depends testDeleteValue
		 * @depends testSetDefaultSetKeyValid
		 * @depends testAddSet
		 * @depends testGetDefaultSetKey
		 * @covers ::autoSetDefaultSet
		 */
		public function testAutoSetDefaultSet() {
			self::$obj->deleteSet('one');

			try {
				self::$obj->autoSetDefaultSet();
				$this->fail('An exception was not thrown');
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\LogicException', $e);
				$this->assertEquals(24, $e->getCode());
				$this->assertEquals('No sets exist in the object!', $e->getMessage());
			}

			self::$obj->addSet(2, [1, 2, 3]);
			self::$obj->addSet(1, [1, 2, 3]);
			self::$obj->addSet(11, [1, 2, 3]);
			self::$obj->autoSetDefaultSet();
			$this->assertEquals(2, self::$obj->getDefaultSetKey());
		}
	}
}
