<?php
namespace Flair\Validation\Core {

    /**
     * the needed test class
     */
    require '/_testCallable/TestCallable.php';

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\Core\Rule
     */
    class RuleTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * holds an object of callables
         *
         * @var object
         */
        public static $callables = null;

        /**
         * holds a list of types to test against.
         *
         * @var array
         */
        protected static $callableTypes = [];

        /**
         * Set up stuff before testing
         */
        public static function setUpBeforeClass()
        {
            self::$callables = new \TestCallable();

            self::$callableTypes = [
                'core' => 'is_string',
                'anonymous' => function () {return true;},
                'instantiated' => [self::$callables, 'alwaysTrue'],
                'static method' => ['\TestCallable', 'staticAlwaysTrue'],
                //'instantiate' => [new \TestCallable(), 'alwaysTrue'],
            ];
        }

        /**
         * runs very basic tests
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function testBasic()
        {
            $rule = new Rule([self::$callables, 'alwaysTrue']);

            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Validation\Core\Rule', $rule, $msg);

            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Validation\Core\RuleInterface', $rule, $msg);

            $msg = 'the object does not use the correct trait';
            $this->assertContains('Flair\Validation\Core\RuleTrait', class_uses($rule), $msg);
        }

        /**
         * checks setCallable handles types properly. Either the assertion
         * will pass or phpunit will throw an exception.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setCallable
         */
        public function testSetCallable()
        {
            $rule = new Rule([self::$callables, 'alwaysTrue']);

            foreach (self::$callableTypes as $type => $val) {
                $this->assertTrue($rule->setCallable($val));
            }
        }

        /**
         * checks setCallable handles an instantiated object properly. Either the assertion
         * will pass or phpunit will throw an exception.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setCallable
         */
        public function testSetCallableInstantiated()
        {
            $rule = new Rule([new \TestCallable(), 'alwaysTrue']);
            $this->assertInstanceOf('Flair\Validation\Core\Rule', $rule);
        }

    }
}
