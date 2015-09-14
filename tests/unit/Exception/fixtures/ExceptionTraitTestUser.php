<?php
namespace Flair\Exception {

	/**
	 * A class to allow testing ExceptionTrait & ExceptionInterface
	 *
	 * @author Daniel Sherman
	 */
	class ExceptionTraitTestUser extends \Exception implements ExceptionInterface {

		/**
		 * Add the needed methods.
		 */
		use ExceptionTrait;

		/**
		 * holds a copy of the context passed into the exception
		 *
		 * @var array
		 */
		public $contextRef = [];

		/**
		 * The constructor does what you would expect it to.
		 *
		 * @author Daniel Sherman
		 * @uses setId
		 * @uses context
		 */
		public function __construct() {
			$pre = new \Exception('A Previous Testing Message', 0);

			parent::__construct('A Testing Message', 1, $pre);
			$this->setId();

			$this->context = [
				'one' => 1,
				'two' => 2,
				'three' => [
					1 => 'apple',
					2 => 'banana',
				],
			];

			$this->contextRef = $this->context;
		}

	}
}
