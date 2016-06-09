<?php
namespace Flair\Validation\Rules {

	/**
	 * A simple rule that allows one or more rules to be grouped together
	 * to create more complex validation logic, or to work as one rule.
	 *
	 * @author Daniel Sherman
	 */
	class Group implements
	\Flair\Validation\RuleInterface,
	\Flair\Validation\RuleGroupInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Validation\RuleTrait;
		use \Flair\Validation\RuleGroupTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param array $rules an array of one or more rules.
		 * @param boolean $halt Indicates that if a value fails to pass validation, further
		 * processing by other rules should stop.
		 * @uses addRules
		 * @uses setHalt
		 * @throws \Exception Can throw several different exceptions if parameters are invalid.
		 */
		public function __construct(array $rules = [], $halt = false) {
			$this->addRules($rules);
			$this->setHalt($halt);
		}

	}
}
