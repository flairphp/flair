<?php
namespace Flair\Configuration\Sets {

	/**
	 * The Unit test for the jsonFile class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\Sets\JsonFile
	 */
	class JsonFileTest extends \PHPUnit\Framework\TestCase {

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
			self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
			self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;
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
				$test = new JsonFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\InvalidArgumentException', $e);
				$this->assertEquals(25, $e->getCode());
				$this->assertEquals('$path is not a string!', $e->getMessage());
			}

			$file = self::$fixturePath . 'noSuchFile.json';
			try {
				$test = new JsonFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\RuntimeException', $e);
				$this->assertEquals(26, $e->getCode());
				$this->assertEquals('Unable to load $path!', $e->getMessage());
			}

			$file = self::$fixturePath . 'bad.json';
			try {
				$test = new JsonFile($file);
				$this->fail('An exception was not thrown');
				return;
			} catch (\Exception $e) {
				$this->assertInstanceOf('Flair\Configuration\RuntimeException', $e);
				$this->assertEquals(27, $e->getCode());
				$this->assertEquals('Unable to json decode the input file!', $e->getMessage());
			}

			$file = self::$fixturePath . 'good.json';
			$test = new JsonFile($file);

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Configuration\Sets\JsonFile', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Configuration\SetsInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Configuration\SetsTrait', class_uses($test), $msg);
		}
	}
}