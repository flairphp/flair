<?php
namespace Flair\Validation\Rules {

	/**
	 * A rule that works just like a Group, except with the allowance for overriding error message(s).
	 *
	 * The benefit of the Wrapper class, is that you can utilize preexisting rules, without having to
	 * use their error messages.
	 *
	 * @author Daniel Sherman
	 */
	class Wrapper implements
	\Flair\Validation\RuleInterface,
	\Flair\Validation\RuleMessageInterface,
	\Flair\Validation\RuleReplacerInterface,
	\Flair\Validation\RuleGroupInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Validation\RuleTrait;
		use \Flair\Validation\RuleMessageTrait;
		use \Flair\Validation\RuleReplacerTrait;
		use \Flair\Validation\RuleGroupTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param array $rules an array of one or more rules.
		 * @param string $msg The error message/template.
		 * @param Flair\Validation\ReplacerInterface $rep The optional Replacer.
		 * @param boolean $halt Indicates that if a value fails to pass validation, further
		 * processing should stop.
		 * @uses setCallable
		 * @uses setArguments
		 * @uses setMessage
		 * @uses setReplacer
		 * @uses setHalt
		 * @throws \Exception Can throw several different exceptions if parameters are invalid.
		 */
		public function __construct(array $rules = [], $msg = '', $rep = null, $halt = false) {
			$this->addRules($rules);
			$this->setMessage($msg);
			$this->setReplacer($rep);
			$this->setHalt($halt);
		}

		/**
		 * getErrors takes the sting set with __construct or setMessage and then passes it through
		 * a Replacer if one was set with __construct or setReplacer, before returning it. getErrors
		 * allows for complex error messages to be generated simply & efficiently.
		 *
		 * @uses hasReplacer
		 * @uses getMessage
		 * @uses replacer
		 * @return array An array of error messages.
		 */
		public function getErrors() {
			$msg = $this->getMessage();

			if ($this->hasReplacer()) {
				return [$this->replacer->doReplacements($msg)];
			} else {
				return [$msg];
			}
		}

	}
}