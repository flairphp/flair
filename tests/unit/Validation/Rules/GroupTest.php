<?php
namespace Flair\Validation\Rules {

	/**
	 * The Unit test for the Group class.
	 *
	 * @author Daniel Sherman
	 * @coversDefaultClass \Flair\Validation\Rules\Group
	 */
	class GroupTest extends \PHPUnit\Framework\TestCase {
		/**
		 * Checks the object uses the correct trait, and
		 * implements the correct interface.
		 *
		 * @author Daniel Sherman
		 * @test
		 * @covers ::__construct
		 */
		public function testConstruct() {
			$test = new Group();

			$msg = 'the object is not the correct type';
			$this->assertInstanceOf('Flair\Validation\Rules\Group', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleInterface', $test, $msg);

			$msg = 'the object does not implement the correct interface';
			$this->assertInstanceOf('Flair\Validation\RuleGroupInterface', $test, $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleTrait', class_uses($test), $msg);

			$msg = 'the object does not use the correct trait';
			$this->assertContains('Flair\Validation\RuleGroupTrait', class_uses($test), $msg);
		}

	}
}