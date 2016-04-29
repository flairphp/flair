<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the ReplacerTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\ReplacerTrait
	 */
	class ReplacerTraitTest extends \Flair\PhpUnit\TestCase {
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

			require_once self::$fixturePath . 'ReplacerTraitTestObject.php';
		}

		/**
		 * mark the test finished.
		 */
		public static function tearDownAfterClass() {
			self::setFinishedTest();
		}

		/**
		 * set up the needed data before each test.
		 */
		protected function setUp() {
			self::$obj = new ReplacerTraitTestObject();
		}

		/**
		 * Checks the object uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 */
		public function testConstruct() {
			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\ReplacerInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\ReplacerTrait', class_uses(self::$obj), $msg);
		}

	}
}
