<?php
namespace Flair\Validation {

	/**
	 * A class to allow testing RuleMessageInterface & RuleMessageTrait
	 *
	 * @author Daniel Sherman
	 */
	class RuleMessageTraitTestObject implements RuleMessageInterface {

		/**
		 * Add the needed methods.
		 */
		use RuleMessageTrait;
	}
}