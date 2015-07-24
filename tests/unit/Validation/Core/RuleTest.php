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
        protected static $types = [];

        /**
         * Set up stuff before testing
         */
        public static function setUpBeforeClass()
        {
            self::$callables = new \TestCallable();

            self::$types = [
                'boolean' => true,
                'integer' => 1,
                'float' => 1.15,
                'string' => 'hello',
                'array' => [],
                'object' => new \stdClass(),
                'resource' => fopen(__FILE__, "r"),
                'null' => null,
                // core php function
                'callable 1' => 'is_string',
                // anonymous function
                'callable 2' => function () {return true;},
                // instantiated object
                'callable 3' => [self::$callables, 'alwaysTrue'],
                // static method
                'callable 4' => ['\TestCallable', 'staticAlwaysTrue'],
                // instantiate
                'callable 5' => [new \TestCallable(), 'alwaysTrue'],
            ];
        }

        /**
         * runs very basic tests
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function basicTests()
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
         * checks setCallable handles types properly
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setCallable
         */
        public function setCallableTests()
        {
            $rule = new Rule([self::$callables, 'alwaysTrue']);

            foreach (self::$types as $type => $val) {
                $msg = "A value of type '$type' was accepted";

                if (stripos($type, 'callable') === 0) {
                    $result = $rule->setCallable($val);
                    $this->assertTrue($result, $msg);
                } else {
                    try {
                        $rule->setCallable($val);
                    } catch (\PHPUnit_Framework_Error $e) {
                        // the correct code
                        $this->assertSame($e->getCode(), 4096, $msg);

                        // the correct message
                        $start = 'Argument 1 passed to Flair\Validation\Core\Rule::setCallable() must be callable,';
                        $this->assertSame(stripos($e->getMessage(), $start), 0, $msg);
                    }
                }

            }

        }

    }
}
