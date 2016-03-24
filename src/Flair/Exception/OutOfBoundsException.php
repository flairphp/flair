<?php
namespace Flair\Exception {

	/**
	 * A bare bones OutOfBoundsException, that can be used or extended.
	 *
	 * @author Daniel Sherman
	 * @todo test
	 */
	class OutOfBoundsException extends \OutOfBoundsException implements ExceptionInterface {

		/**
		 * Add the needed methods.
		 */
		use ExceptionTrait;

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @author Daniel Sherman
		 * @param string $message the message for the exception
		 * @param integer $code the code for the exception
		 * @param \Exception $previous A previous exception
		 * @param array $context the array that will be returned along with the
		 * exception.
		 * @uses setId
		 * @uses context
		 */
		public function __construct($message = null, $code = 0, $previous = null, array $context = []) {
			parent::__construct($message, $code, $previous);
			$this->setId();
			$this->context = $context;
		}

	}
}
