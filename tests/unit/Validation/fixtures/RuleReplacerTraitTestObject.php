<?php
namespace Flair\Validation {

	/**
	 * A class to allow testing RuleReplacerInterface & RuleReplacerTrait
	 *
	 * @author Daniel Sherman
	 */
	class RuleReplacerTraitTestObject implements RuleReplacerInterface {

		/**
		 * Add the needed methods.
		 */
		use RuleReplacerTrait;
	}
}