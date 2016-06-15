<?php
namespace Flair\Validation\Rules {

	/**
	 * A bare bones rule, that can be used or extended, that leverages the power of callables.
	 *
	 * @author Daniel Sherman
	 */
	class Caller implements
	\Flair\Validation\RuleInterface,
	\Flair\Validation\RuleMessageInterface,
	\Flair\Validation\RuleReplacerInterface {

		/**
		 * Add the needed methods.
		 */
		use \Flair\Validation\RuleTrait;
		use \Flair\Validation\RuleMessageTrait;
		use \Flair\Validation\RuleReplacerTrait;

		/**
		 * The callable function/method actually used to perform the validation
		 * of input to isValid().
		 *
		 * @var callable
		 */
		protected $call = null;

		/**
		 * The optional arguments that isValid() will pass to $callable for validating input.
		 *
		 * @var array
		 */
		protected $arguments = [];

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param callable $call The callable that will be used by isValid().
		 * @param string $msg The error message/template.
		 * @param array $args The extra arguments that can be passed to $call.
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
		public function __construct(callable $call, $msg = '', array $args = [], $rep = null, $halt = false) {
			$this->setCallable($call);
			$this->setMessage($msg);
			$this->setArguments($args);
			$this->setReplacer($rep);
			$this->setHalt($halt);
		}

		/**
		 * Gets the callable method/function that will be used by isValid() to validate the value
		 * passed to it.
		 *
		 * @uses call
		 * @return callable Returns the callable method/function.
		 */
		public function getCallable() {
			return $this->call;
		}

		/**
		 * Sets the callable method/function that will be used by isValid() to validate the value
		 * passed to it. The method/function should always return a bool value.
		 *
		 * @param callable $callable The callable that will be used by isValid().
		 * @uses call
		 */
		public function setCallable(callable $callable) {
			$this->call = $callable;
		}

		/**
		 * Gets the optional arguments that will be passed along to the callable method/function
		 * that will be used by isValid() to validate the value passed to it.
		 *
		 * @uses arguments
		 * @return array The arguments that will be used.
		 */
		public function getArguments() {
			return $this->arguments;
		}

		/**
		 * Sets the optional arguments that isValid() will pass to the callable method/function
		 * it uses for validating its input.
		 *
		 * @param array $arguments The arguments to be used.
		 * @uses arguments
		 */
		public function setArguments(array $arguments = []) {
			$this->arguments = $arguments;
		}

		/**
		 *  Returns true if $value is valid, false otherwise.
		 *
		 * @param mixed $value The value to be validated.
		 * @uses getCallable
		 * @uses getArguments
		 * @throws UnexpectedValueException If the callable method doesn't return a bool.
		 * @return bool
		 */
		public function isValid($value) {
			$call = $this->getCallable();
			$args = $this->getArguments();

			if (count($args) > 0) {
				//only call call_user_func_array if absolutely needed
				array_unshift($args, $value);
				$result = call_user_func_array($call, $args);
			} else {
				$result = $call($value);
			}

			if (is_bool($result)) {
				return $result;
			}

			$msg = 'The callable method did not return a boolean!';
			throw new \Flair\Validation\UnexpectedValueException($msg, 18);
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
