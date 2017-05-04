<?php
namespace Flair\Validation {

	/**
	 * The Unit test for the Replacer class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\Replacer
	 */
	class ReplacerTest extends \PHPUnit\Framework\TestCase {
		/**
		 * Checks the object is of the correct type, uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$test = new Replacer();

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Validation\Replacer', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\ReplacerInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\ReplacerTrait', class_uses($test), $msg);
		}

	}
}
