<?php
namespace Flair\AutoLoader {
	/**
	 * The Unit test for the psr4 class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\AutoLoader\Psr4
	 */
	class Psr4Test extends \PHPUnit\Framework\TestCase {
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
			self::$loader = new Psr4();
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
			$this->assertInstanceOf('Flair\AutoLoader\Psr4', self::$loader, $msg);
		}

		/**
		 * Checks if getPrefixes works as expected.
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getPrefixes
		 */
		public function testGetPrefixes() {
			$val = self::$loader->getPrefixes();
			$this->assertTrue(is_array($val), 'An array was not returned');
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
			$baseDir = '/www/libs/';
			$result = self::$loader->addPrefix($prefix, $baseDir);
			$this->assertTrue($result, 'a valid prefix could not be added!');

			$prefixes = [$prefix => $baseDir];
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
			$baseDir = '/www/libs/';
			$result = self::$loader->addPrefix($prefix, $baseDir);
			$this->assertTrue($result, 'a valid prefix could not be added!');

			$prefixes = [$prefix => $baseDir];
			$storedPrefixes = self::$loader->getPrefixes();
			$msg = 'the prefix did not get saved properly!';
			$this->assertEquals($prefixes, $storedPrefixes, $msg);

			$result = self::$loader->removePrefix($prefix);
			$this->assertTrue($result, 'the prefix did not get removed');

			$prefixes = self::$loader->getPrefixes();
			$this->assertEquals([], $prefixes, 'the prefix did not get removed properly!');
		}

		/**
		 * Checks if add prefix forces the proper type constraints.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testGetPrefixes
		 * @depends testRemovePrefix
		 * @dataProvider addPrefixTypeConstraintProvider
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
				if ($pathPrefixType === 'string') {
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
		public function addPrefixTypeConstraintProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
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
		 * @dataProvider addToIncludePathTypeConstraintProvider
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
		public function addToIncludePathTypeConstraintProvider() {
			$data = new \Flair\PhpUnit\DataTypeProvider();
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
		 * Checks if load works as expected using the inclde path
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testAddToIncludePath
		 * @depends testAddPrefix
		 * @covers ::load
		 */
		public function testLoadIncludePath() {
			$origonalIncludePath = get_include_path();
			$prefix = 'Vendor\\Simple';
			$baseDir = 'Vendor' . DIRECTORY_SEPARATOR . 'Simple' . DIRECTORY_SEPARATOR;
			$newPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';
			$newPath .= DIRECTORY_SEPARATOR . 'Psr4';

			//configure the object
			$result = self::$loader->addToIncludePath($newPath);
			$this->assertTrue($result, 'updating the includepath failed');

			$result = self::$loader->addPrefix($prefix, $baseDir);
			$this->assertTrue($result, 'adding a prefix failed');

			// the actual assertions/tests
			$result = self::$loader->load('Vendor\\Simple\\ClassOne');
			$this->assertTrue($result, 'the class file did not get load');

			$result = class_exists('Vendor\\Simple\\ClassOne', false);
			$this->assertTrue($result, 'the class is not in scope');

			$result = self::$loader->load('Vendor\\Simple\\NonexistentClassOne');
			$this->assertFalse($result, 'the class/file does not exist');

			$result = self::$loader->load('Vendor\\Complex\\ClassOne');
			$this->assertFalse($result, 'The prefix was not configured');

			// reconfigure the object
			set_include_path($origonalIncludePath);
		}

		/**
		 * Checks if load works as expected
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @depends testAddPrefix
		 * @depends testRemovePrefix
		 * @covers ::load
		 */
		public function testLoad() {
			$prefix = 'Vendor\\Simple';
			$baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';
			$baseDir .= DIRECTORY_SEPARATOR . 'Psr4' . DIRECTORY_SEPARATOR;
			$baseDir .= 'Vendor' . DIRECTORY_SEPARATOR . 'Simple' . DIRECTORY_SEPARATOR;

			//configure the object
			$result = self::$loader->addPrefix($prefix, $baseDir);
			$this->assertTrue($result, 'adding a prefix failed');

			// the actual assertions/tests
			$result = self::$loader->load('Vendor\\Simple\\ClassTwo');
			$this->assertTrue($result, 'the class file did not get load');

			$result = class_exists('Vendor\\Simple\\ClassTwo', false);
			$this->assertTrue($result, 'the class is not in scope');

			$result = self::$loader->load('Vendor\\Simple\\NonexistentClassTwo');
			$this->assertFalse($result, 'the class/file does not exist');

			$result = self::$loader->load('Vendor\\Complex\\ClassTwo');
			$this->assertFalse($result, 'The prefix was not configured');

			// reconfigure the object
			$result = self::$loader->removePrefix($prefix);
			$this->assertTrue($result, 'removing a prefix failed');
		}
	}
}
