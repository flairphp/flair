<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the RuleReplacerTrait class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\RuleReplacerTrait
	 */
	class RuleReplacerTraitTest extends \PHPUnit\Framework\TestCase {
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

			require_once self::$fixturePath . 'RuleReplacerTraitTestObject.php';

			self::$obj = new RuleReplacerTraitTestObject();
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
			$this->assertInstanceOf('Flair\Validation\RuleReplacerInterface', self::$obj, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleReplacerTrait', class_uses(self::$obj), $msg);
		}

		/**
		 * Checks to see if getReplacer returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::getReplacer
		 */
		public function testGetReplacerDefault() {
			$this->assertNull(self::$obj->getReplacer());
		}

		/**
		 * Checks to see if hasReplacer returns what is expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::hasReplacer
		 */
		public function testHasReplacerDefault() {
			$this->assertFalse(self::$obj->hasReplacer());
		}

		/**
		 * Checks to see if everything works as expected.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @depends testConstruct
		 * @covers ::hasReplacer
		 * @covers ::setReplacer
		 * @covers ::getReplacer
		 */
		public function testFull() {
			$obj = new Replacer();
			self::$obj->setReplacer($obj);
			$this->assertTrue(self::$obj->hasReplacer());
			$this->assertEquals($obj, self::$obj->getReplacer());

			self::$obj->setReplacer(null);
			$this->assertFalse(self::$obj->hasReplacer());
			$this->assertNull(self::$obj->getReplacer());
		}
	}
}
