<?php
namespace Flair\Configuration\Sets {

	/**
	 * The Unit test for the Arrays class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Configuration\Sets\Arrays
	 */
	class ArraysTest extends \Flair\PhpUnit\TestCase {
		/**
		 * set up the needed data before the testing starts.
		 */
		public static function setUpBeforeClass() {
			self::addDependentTestCase('Flair\Configuration\SetsTraitTest');
			self::skipTestCaseOnFailedDependencies();
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
			$sets = [
				'one' => [
					'1',
					'2',
					'3',
				],
				'two' => [
					'one',
					'two',
					'three',
				],
				3 => [
					1,
					2,
					3,
				],
			];

			$test = new Arrays($sets, 3);

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Configuration\Sets\Arrays', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Configuration\SetsInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Configuration\SetsTrait', class_uses($test), $msg);
		}

	}
}