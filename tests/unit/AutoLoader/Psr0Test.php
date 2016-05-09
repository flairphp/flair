<?php
namespace Flair\AutoLoader {
	/**
	 * The Unit test for the psr0 class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\AutoLoader\Psr0
	 */
	class Psr0Test extends \Flair\PhpUnit\TestCase {
		/**
		 * holds a loader
		 *
		 * @var Psr0
		 */
		protected static $loader = null;

		/**
		 * set up the needed data before each test.
		 */
		protected function setUp() {
			self::$loader = new Psr0();
		}

		/**
		 * mark the test finished.
		 */
		public static function tearDownAfterClass() {
			self::setFinishedTest();
		}

		/**
		 * Checks the object is of the correct type
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\AutoLoader\Psr0', self::$loader, $msg);
		}

		/**
		 * Checks if getDefaultPathPrefix works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getDefaultPathPrefix
		 */
		public function testGetDefaultPathPrefix() {
			$val = self::$loader->getDefaultPathPrefix();
			$this->assertEquals('', $val, 'The default path should be blank');
		}

		/**
		 * Checks if setDefaultPathPrefix works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testGetDefaultPathPrefix
		 * @covers ::setDefaultPathPrefix
		 */
		public function testSetDefaultPathPrefix() {
			$setTo = '/www/libs/';
			$result = self::$loader->setDefaultPathPrefix($setTo);
			$this->assertTrue($result, 'The default prefix did not saved successfully');

			$val = self::$loader->getDefaultPathPrefix();
			$this->assertEquals($setTo, $val, 'The default is not what it should be');
		}

		/**
		 * Checks if setDefaultPathPrefix forces the proper type constraint.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetDefaultPathPrefix
		 * @dataProvider testSetDefaultPathPrefixTypeConstraintProvider
		 * @covers ::setDefaultPathPrefix
		 */
		public function testSetDefaultPathPrefixTypeConstraint($type, $val) {
			$result = self::$loader->setDefaultPathPrefix($val);
			$msg = "A value of type $type was accepted";

			if ($type !== 'string') {
				$this->assertFalse($result, $msg);
			} else {
				$this->assertTrue($result, $msg);
			}
		}

		/**
		 * provides data for testSetDefaultPathPrefixTypeConstraint
		 */
		public function testSetDefaultPathPrefixTypeConstraintProvider() {
			$data = self::getDataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes());
		}

		/**
		 * Checks if getPrefixes works as expected. and the value passed into
		 * addPrefix saved correctly.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getPrefixes
		 */
		public function testGetPrefixes() {
			$val = self::$loader->getPrefixes();
			$this->assertTrue(is_array($val), 'An array was not returned');
			$this->assertEquals(0, count($val), 'the array was not empty');
		}

		/**
		 * Checks if addPrefix works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetPrefixes
		 * @covers ::addPrefix
		 */
		public function testAddPrefix() {
			$prefix = 'Flair\Autoloader';
			$pathPrefix = '/www/libs/';
			$result = self::$loader->addPrefix($prefix, $pathPrefix);
			$this->assertTrue($result, 'a valid prefix could not be added!');

			$prefixes = [$prefix => $pathPrefix];
			$storedPrefixes = self::$loader->getPrefixes();
			$msg = 'the prefix did not get saved properly!';
			$this->assertEquals($prefixes, $storedPrefixes, $msg);
		}

		/**
		 * Checks if removePrefix works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddPrefix
		 * @depends testGetPrefixes
		 * @covers ::removePrefix
		 */
		public function testRemovePrefix() {
			$prefix = 'Flair\Autoloader';
			$pathPrefix = '/www/libs/';
			$result = self::$loader->addPrefix($prefix, $pathPrefix);
			$this->assertTrue($result, 'a valid prefix could not be added!');

			$prefixes = [$prefix => $pathPrefix];
			$storedPrefixes = self::$loader->getPrefixes();
			$msg = 'the prefix did not get saved properly!';
			$this->assertEquals($prefixes, $storedPrefixes, $msg);

			$result = self::$loader->removePrefix($prefix);
			$this->assertTrue($result, 'the prefix did not get removed');
			$prefixes = self::$loader->getPrefixes();
			$this->assertEquals([], $prefixes, 'the prefix did not get removed properly!');
		}

		/**
		 * Checks if addPrefix works as expected when no pathprefix is passed.
		 * @author Daniel Sherman
		 * @test
		 * @depends testSetDefaultPathPrefix
		 * @depends testAddPrefix
		 * @depends testGetPrefixes
		 * @covers ::addPrefix
		 */
		public function testAddPrefixDefault() {
			$prefix = 'Flair\Autoloader';
			$pathPrefix = '/www/libs/HelloWorld';

			$result = self::$loader->setDefaultPathPrefix($pathPrefix);
			$this->assertTrue($result, 'The default prefix did not save successfully');

			$result = self::$loader->addPrefix($prefix);
			$this->assertTrue($result, 'a valid prefix could not be added!');

			$prefixes = [$prefix => $pathPrefix];
			$storedPrefixes = self::$loader->getPrefixes();
			$msg = 'the prefix did not get saved properly!';
			$this->assertEquals($prefixes, $storedPrefixes, $msg);
		}

		/**
		 * Checks if add prefix forces the proper type constraints.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testAddPrefixDefault
		 * @depends testGetPrefixes
		 * @depends testRemovePrefix
		 * @dataProvider testAddPrefixTypeConstraintProvider
		 * @covers ::addPrefix
		 */
		public function testAddPrefixTypeConstraint($prefixType, $prefixVal, $pathPrefixType, $pathPrefixVal) {
			$result = self::$loader->addPrefix($prefixVal, $pathPrefixVal);
			$msg = "A prefix type of $prefixType was accepted";
			$msg .= " with a path prefix type of $pathPrefixType!";

			if ($prefixType !== 'string') {
				// we should get false any time $prefixType is not a string
				$this->assertFalse($result, $msg);
			} else {
				if ($pathPrefixType === 'string' || $pathPrefixType === 'null') {
					// we should get true if a sting or null was passed
					$this->assertTrue($result, $msg);
				} else {
					// false should be returned for everything else
					$this->assertFalse($result, $msg);
				}
			}
		}

		/**
		 * provides data for testAddPrefixTypeConstraint
		 */
		public function testAddPrefixTypeConstraintProvider() {
			$data = self::getDataTypeProvider();
			$tmp = $data->arrayOfArrays($data->excludeTypes());
			$tmp2 = $tmp;
			$rtn = [];
			foreach ($tmp as $val) {
				foreach ($tmp2 as $val2) {
					$rtn[] = array_merge($val, $val2);
				}
			}

			return $rtn;
		}

		/**
		 * Checks if register works as expected, and doesn't throw an exception
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::register
		 */
		public function testRegister() {
			$e = null;
			try {
				self::$loader->register();
			} catch (\LogicException $e) {}

			$this->assertNull($e, 'The autloader failed to register');
		}

		/**
		 * Checks if deregister works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testRegister
		 * @covers ::deregister
		 */
		public function testDeregisterSuccess() {
			$e = null;
			try {
				self::$loader->register();
			} catch (\LogicException $e) {}
			$this->assertNull($e, 'The autloader failed to register');

			$result = self::$loader->deregister();
			$this->assertTrue($result, 'Failed to deregister');
		}

		/**
		 * Checks if deregister fails as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::deregister
		 */
		public function testDeregisterFail() {
			$result = self::$loader->deregister();
			$this->assertFalse($result, 'deregisterd something that was not registered');
		}

		/**
		 * Checks if addToIncludePath works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::addToIncludePath
		 */
		public function testAddToIncludePath() {
			$newPath = '/someCrapola';
			$origonalPath = get_include_path();

			$result = self::$loader->addToIncludePath($newPath);
			$this->assertTrue($result, 'The include path failed to update');

			$expected = $origonalPath . PATH_SEPARATOR . $newPath;
			$newpath = get_include_path();
			$this->assertEquals($expected, $newpath, 'The include is not what it should be');

			set_include_path($origonalPath);
		}

		/**
		 * Checks if addToIncludePath handles types properly.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @dataProvider testAddToIncludePathTypeConstraintProvider
		 * @covers ::addToIncludePath
		 */
		public function testAddToIncludePathTypeConstraint($type, $val) {
			$origonalPath = get_include_path();

			$result = self::$loader->addToIncludePath($val);
			$msg = "A value of type $type was accepted";

			if ($type !== 'string') {
				$this->assertFalse($result, $msg);
			} else {
				$this->assertTrue($result, $msg);
			}

			set_include_path($origonalPath);
		}

		/**
		 * provides data for testAddToIncludePathTypeConstraint
		 */
		public function testAddToIncludePathTypeConstraintProvider() {
			$data = self::getDataTypeProvider();
			return $data->arrayOfArrays($data->excludeTypes());
		}

		/**
		 * Checks if removeFromIncludePath works.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::removeFromIncludePath
		 */
		public function testRemoveFromIncludePath() {
			$newPath = '/www';
			$origonalPath = get_include_path();
			set_include_path($origonalPath . PATH_SEPARATOR . $newPath);

			$result = self::$loader->removeFromIncludePath($newPath);
			$this->assertTrue($result, 'The path was not removed from the include path');

			$updatedPath = get_include_path();
			$this->assertEquals($origonalPath, $updatedPath, 'The include path is not what it should be');

			set_include_path($origonalPath);
		}

		/**
		 * Checks if load works as expected using the include path
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testAddToIncludePath
		 * @depends testAddPrefix
		 * @covers ::load
		 */
		public function testLoadIncludePath() {
			$origonalIncludePath = get_include_path();

			$prefix = 'Simple';
			$newPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';

			//configure the object
			$result = self::$loader->addToIncludePath($newPath);
			$this->assertTrue($result, 'updating the includepath failed');

			$result = self::$loader->addPrefix($prefix);
			$this->assertTrue($result, 'adding a prefix failed');

			// the actual assertions/tests
			$result = self::$loader->load('SimpleClass');
			$this->assertTrue($result, 'the class file did not get load');
			$result = class_exists('SimpleClass', false);
			$this->assertTrue($result, 'the class is not in scope');

			$result = self::$loader->load('SimpleNonexistentClass');
			$this->assertFalse($result, 'the class/file does not exist');

			$result = self::$loader->load('ComplexClass');
			$this->assertFalse($result, 'The prefix was not configured');

			set_include_path($origonalIncludePath);
		}

		/**
		 * Checks if load works as expected using the default path prefix
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testSetDefaultPathPrefix
		 * @depends testAddPrefix
		 * @covers ::load
		 */
		public function testLoadDefaultPathPrefix() {
			$prefix = 'Simple';
			$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

			//configure the object
			$result = self::$loader->setDefaultPathPrefix($path);
			$this->assertTrue($result, 'setting the default prefix failed');

			$result = self::$loader->addPrefix($prefix);
			$this->assertTrue($result, 'adding a prefix failed');

			// the actual assertions/tests
			$result = self::$loader->load('SimpleClassTwo');
			$this->assertTrue($result, 'the class file did not get load');

			$result = class_exists('SimpleClassTwo', false);
			$this->assertTrue($result, 'the class is not in scope');

			$result = self::$loader->load('SimpleNonexistentClassTwo');
			$this->assertFalse($result, 'the class/file does not exist');

			$result = self::$loader->load('ComplexClassTwo');
			$this->assertFalse($result, 'The prefix was not configured');
		}

		/**
		 * Checks if load works as expected using the default path prefix
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testAddPrefix
		 * @covers ::load
		 */
		public function testLoadPassedPathPrefix() {
			$prefix = 'Simple';
			$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

			//configure the object
			$result = self::$loader->addPrefix($prefix, $path);
			$this->assertTrue($result, 'adding a prefix failed');

			// the actual assertions/tests
			$result = self::$loader->load('SimpleClassThree');
			$this->assertTrue($result, 'the class file did not get load');

			$result = class_exists('SimpleClassThree', false);
			$this->assertTrue($result, 'the class is not in scope');

			$result = self::$loader->load('SimpleNonexistentClassThree');
			$this->assertFalse($result, 'the class/file does not exist');

			$result = self::$loader->load('ComplexClassThree');
			$this->assertFalse($result, 'The prefix was not configured');
		}
	}
}
