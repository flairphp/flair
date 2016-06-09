<?php
namespace Flair\Validation {

	/**
	 * A class to allow testing RuleGroupInterface & RuleGroupTrait
	 *
	 * @author Daniel Sherman
	 */
	class RuleGroupTraitTestObject implements RuleGroupInterface {

		/**
		 * Add the needed methods.
		 */
		use RuleGroupTrait;

	}
}