<?php
namespace Flair\Input\Required {

	/**
	 * A Required object that leverages the power of callables to determine 
	 * if the associated input is required. 
	 *
	 * @author Daniel Sherman
	 */
	class Caller implements \Flair\Input\RequiredInterface {

		/**
		 * The callable function/method used to determine if the input is required.
		 *
		 * @var callable
		 */
		protected $call = null;

		/**
		 * The optional arguments that required() will pass to $call
		 *
		 * @var array
		 */
		protected $arguments = [];

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @param callable $call The callable that will be used by required().
		 * @param array $args The extra arguments that can be passed to $call.
		 * 
		 * @uses setCallable
		 * @uses setArguments
		 */
		public function __construct(callable $call, array $args = []) {
			$this->setCallable($call);
			$this->setArguments($args);
		}

		/**
		 * Gets the callable method/function that will be used by required() 
		 *
		 * @uses call
		 * @return callable Returns the callable method/function.
		 */
		public function getCallable() {
			return $this->call;
		}

		/**
		 * Sets the callable method/function that will be used by required() 
		 * The method/function should always return a bool value.
		 *
		 * @param callable $callable The callable that will be used by isValid().
		 * @uses call
		 */
		public function setCallable(callable $callable) {
			$this->call = $callable;
		}

		/**
		 * Gets the optional arguments that will be passed along to the callable method/function
		 * by required().
		 *
		 * @uses arguments
		 * @return array The arguments that will be used.
		 */
		public function getArguments() {
			return $this->arguments;
		}

		/**
		 * Sets the optional arguments that required() will pass to the callable method/function.
		 *
		 * @param array $arguments The arguments to be used.
		 * @uses arguments
		 */
		public function setArguments(array $arguments = []) {
			$this->arguments = $arguments;
		}

		/**
		 * Determines if the associated input is a required one.
		 *
		 * @uses call
		 * @uses arguments
		 * @throws UnexpectedValueException If the callable method doesn't return a bool.
		 * @return bool
		 */
		public function required() {
			$call = $this->call;
			$args = $this->arguments;

			if (count($args) > 0) {
				//only call call_user_func_array if absolutely needed
				$result = call_user_func_array($call, $args);
			} else {
				$result = $call();
			}

			if (is_bool($result)) {
				return $result;
			}

			$msg = 'The callable method did not return a boolean!';
			throw new \Flair\Input\UnexpectedValueException($msg, 12);
		}
	}
}