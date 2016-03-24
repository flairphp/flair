<?php
namespace Flair\PhpUnit {

	require 'DataTypeProvider.php';

	abstract class TestCase extends \PHPUnit_Framework_TestCase {

		/**
		 * Object to provide data type arrays
		 *
		 * @var DataTypeProvider
		 */
		protected static $dataTypeProvider = null;

		/**
		 * Has the TestCase finished processing.
		 *
		 * @var bool
		 */
		protected static $finishedTest = false;

		/**
		 * Did the TestCase have any failures
		 *
		 * @var bool
		 */
		protected static $hadFailure = false;

		/**
		 * The TestCases this TestCase depends on
		 *
		 * @var array
		 */
		protected static $dependentTestCases = [];

		/**
		 * handle all test failures
		 *
		 * @var \Exception $e
		 * @uses hadFailure
		 */
		protected function onNotSuccessfulTest($e) {
			echo $e->getMessage();
			self::$hadFailure = true;
			parent::onNotSuccessfulTest($e);
		}

		/**
		 * sets the flag indicating the TestCase has finished
		 *
		 * @uses finishedTest
		 */
		protected static function setFinishedTest() {
			self::$finishedTest = true;
		}

		/**
		 * Adds a TestCase to the Dependent list
		 *
		 * @uses $dependentTestCases
		 * @throws \Exception if $testCase isn't a string
		 */
		protected static function addDependentTestCase($testCase) {
			if (is_string($testCase)) {
				self::$dependentTestCases[] = $testCase;
			} else {
				throw new \Exception('$testcase was not a string!');
			}
		}

		/**
		 * calls markTestSkipped if the TestCase is dependent on other TestCases
		 * that failed.
		 *
		 * @uses markTestSkipped
		 * @uses dependentTestCases
		 */
		protected static function skipTestCaseOnFailedDependencies() {
			foreach (self::$dependentTestCases as $testCase) {

				if (!is_callable([$testCase, 'finished'])) {
					self::markTestSkipped("TestCase $testCase is not in scope!");
					return;
				}

				$method = [$testCase, 'finished'];
				if (!$method()) {
					self::markTestSkipped("TestCase $testCase did not finish!");
					return;
				}

				$method = [$testCase, 'hadFailure'];
				if ($method()) {
					self::markTestSkipped("TestCase $testCase had Failures!");
					return;
				}
			}
		}

		/**
		 * Did the TestCase finish
		 *
		 * @uses finishedTest
		 * @return bool
		 */
		public static function finished() {
			return self::$finishedTest;
		}

		/**
		 * Did the TestCase have any failures
		 *
		 * @uses hadFailure
		 * @return bool
		 */
		public static function hadFailure() {
			return self::$hadFailure;
		}

		/**
		 * returns a DataTypeProvider object
		 *
		 * @uses dataTypeProvider
		 * @return DataTypeProvider
		 */
		public static function getDataTypeProvider() {
			if (self::$dataTypeProvider === null) {
				self::$dataTypeProvider = new DataTypeProvider();
			}

			return self::$dataTypeProvider;
		}
	}
}
