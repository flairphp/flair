<?php
namespace Flair\Configuration\Sets {

	/**
	 * The Unit test for the SerializedFile class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\Sets\SerializedFile
	 */
	class SerializedFileTest extends \Flair\PhpUnit\TestCase {

		/**
		 * holds the path to the fixture directory
		 *
		 * @var string
		 */
		protected static $fixturePath = null;

		/**
		 * set up the needed data before the testing starts.
		 */
		public static function setUpBeforeClass() {
			self::addDependentTestCase('Flair\Configuration\SetsTraitTest');
			self::skipTestCaseOnFailedDependencies();

			self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
			self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;
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
			$file = null;
			try {
				$test = new SerializedFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(28, $e->getCode());
				$this->assertEquals('$path is not a string!', $e->getMessage());
			}

			$file = self::$fixturePath . 'noSuchFile.txt';
			try {
				$test = new SerializedFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\RuntimeException', $e);
				$this->assertEquals(29, $e->getCode());
				$this->assertEquals('Unable to load $path!', $e->getMessage());
			}

			$file = self::$fixturePath . 'badSerialized.txt';
			try {
				$test = new SerializedFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\RuntimeException', $e);
				$this->assertEquals(30, $e->getCode());
				$this->assertEquals('Unable to unserialize the input file!', $e->getMessage());
			}

			$file = self::$fixturePath . 'nonArraySerialized.txt';
			try {
				$test = new SerializedFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\RuntimeException', $e);
				$this->assertEquals(31, $e->getCode());
				$this->assertEquals('The unserialized file, is not an array!', $e->getMessage());
			}

			$file = self::$fixturePath . 'goodSerialized.txt';
			$test = new SerializedFile($file);

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Configuration\Sets\SerializedFile', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Configuration\SetsInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Configuration\SetsTrait', class_uses($test), $msg);
		}
	}
}