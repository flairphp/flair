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
         * holds a list of types to test against, that should not be accepted.
         *
         * @var array
         */
        protected static $types = [];

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

            self::$types = [
                'boolean' => true,
                'integer' => 1,
                'float' => 1.15,
                'string' => '/www/libs/',
                'array' => [],
                'object' => new \stdClass(),
                'resource' => fopen(__FILE__, "r"),
                'null' => null,
            ];

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
        public function testConstruct()
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

        /**
         * checks getCallable always returns a callable from an instantiated object.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getCallable
         */
        public function testGetCallable()
        {
            $callable = [new \TestCallable(), 'alwaysTrue'];
            $rule = new Rule($callable);
            $result = $rule->getCallable();
            $msg = 'Did not get back what was passed in!';
            $this->assertSame($callable, $result, $msg);
        }

        /**
         * checks setMessage only accepts strings
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setMessage
         */
        public function testSetMessage()
        {
            $rule = new Rule([new \TestCallable(), 'alwaysTrue']);

            foreach (self::$types as $type => $val) {
                if ($type === 'string') {
                    $msg = "A string was not accepted.";
                    $this->assertTrue($rule->setMessage($val), $msg);
                } else {
                    try {
                        $rule->setMessage($val);
                    } catch (Exception $e) {
                        $this->assertInstanceOf('Flair\Validation\Core\Exception', $e, 'wrong Exception');
                        $this->assertEquals(0, $e->getCode(), 'wrong Code');
                    }
                }
            }
        }

        /**
         * checks getMessage always returns a string.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getMessage
         */
        public function testGetMessage()
        {
            $rule = new Rule([new \TestCallable(), 'alwaysTrue']);
            $msg = 'Did not get back a string!';
            $this->assertTrue(is_string($rule->getMessage()), $msg);
        }

        /**
         * checks setHalt only accepts bools
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setHalt
         */
        public function testSetHalt()
        {
            $rule = new Rule([new \TestCallable(), 'alwaysTrue']);

            foreach (self::$types as $type => $val) {
                if ($type === 'boolean') {
                    $msg = "A boolean was not accepted.";
                    $this->assertTrue($rule->setHalt($val), $msg);
                } else {
                    try {
                        $rule->setHalt($val);
                    } catch (Exception $e) {
                        $this->assertInstanceOf('Flair\Validation\Core\Exception', $e, $msg . ': wrong Exception');
                        $this->assertEquals(1, $e->getCode(), $msg . ': wrong Code');
                    }
                }
            }
        }

        /**
         * checks getHalt always returns a bool.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getHalt
         */
        public function testGetHalt()
        {
            $rule = new Rule([new \TestCallable(), 'alwaysTrue']);
            $msg = 'Did not get back a bool!';
            $this->assertTrue(is_bool($rule->getHalt()), $msg);
        }

        /**
         * checks setArguments only accepts arrays
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setArguments
         */
        public function testSetArguments()
        {
            $rule = new Rule([self::$callables, 'alwaysTrue']);
            $msg = 'an array was not accepted!';
            $this->assertTrue($rule->setArguments([]), $msg);
        }

        /**
         * checks getArguments only returns arrays
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getArguments
         */
        public function testGetArguments()
        {
            $rule = new Rule([self::$callables, 'alwaysTrue']);
            $msg = 'an array was not returned!';
            $this->assertTrue(is_array($rule->getArguments()), $msg);
        }

        /**
         * checks isValid only returns arrays
         *
         * @author Daniel Sherman
         * @test
         * @covers ::isValid
         */
        public function testIsValid()
        {
        }

    }
}
