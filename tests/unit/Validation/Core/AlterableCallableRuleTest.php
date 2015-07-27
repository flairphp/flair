<?php
namespace Flair\Validation\Core {

    /**
     * the needed test class
     */
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '_testCallable' . DIRECTORY_SEPARATOR . 'TestCallable.php';

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\Core\Rule
     */
    class AlterableCallableRuleTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * holds a list of basic types to test against.
         *
         * @var array
         */
        protected static $types = [];

        /**
         * holds a list of callable types to test against.
         *
         * @var array
         */
        protected static $callableTypes = [];

        /**
         * holds an object of callables
         *
         * @var object
         */
        public static $callables = null;

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
                'instantiate' => [new \TestCallable(), 'returnsGivenType'],
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
            $rule = new AlterableCallableRule([self::$callables, 'returnsGivenType'], [], 'error Message', true);

            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Validation\Core\AlterableCallableRule', $rule, $msg);

            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Validation\Core\RuleInterface', $rule, $msg);

            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Validation\Core\AlterableCallableRuleInterface', $rule, $msg);

            $msg = 'the object does not use the correct trait';
            $this->assertContains('Flair\Validation\Core\AlterableCallableRuleTrait', class_uses($rule), $msg);

            return $rule;
        }

        /**
         * checks setMessage only accepts strings
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setMessage
         */
        public function testSetMessage(AlterableCallableRule $rule)
        {
            foreach (self::$types as $type => $val) {
                if ($type === 'string') {
                    $msg = "A string was not accepted.";
                    $this->assertTrue($rule->setMessage($val), $msg);
                } else {
                    try {
                        $rule->setMessage($val);
                    } catch (\Exception $e) {
                        $class = 'Flair\Validation\Core\InvalidArgumentException';
                        $this->assertInstanceOf($class, $e, 'wrong Exception Class');
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
         * @depends testConstruct
         * @covers ::getMessage
         */
        public function testGetMessage(AlterableCallableRule $rule)
        {
            $msg = 'Did not get back a string!';
            $this->assertTrue(is_string($rule->getMessage()), $msg);
        }

        /**
         * checks setHalt only accepts bools
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setHalt
         */
        public function testSetHalt(AlterableCallableRule $rule)
        {
            foreach (self::$types as $type => $val) {
                if ($type === 'boolean') {
                    $msg = "A boolean was not accepted.";
                    $this->assertTrue($rule->setHalt($val), $msg);
                } else {
                    try {
                        $rule->setHalt($val);
                    } catch (\Exception $e) {
                        $class = 'Flair\Validation\Core\InvalidArgumentException';
                        $this->assertInstanceOf($class, $e, 'wrong Exception Class');
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
         * @depends testConstruct
         * @covers ::getHalt
         */
        public function testGetHalt(AlterableCallableRule $rule)
        {
            $msg = 'Did not get back a bool!';
            $this->assertTrue(is_bool($rule->getHalt()), $msg);
        }

        /**
         * checks setArguments only accepts arrays
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setArguments
         */
        public function testSetArguments(AlterableCallableRule $rule)
        {
            $msg = 'an array was not accepted!';
            $this->assertTrue($rule->setArguments([]), $msg);
        }

        /**
         * checks getArguments only returns arrays
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::getArguments
         */
        public function testGetArguments(AlterableCallableRule $rule)
        {
            $msg = 'an array was not returned!';
            $this->assertTrue(is_array($rule->getArguments()), $msg);
        }

        /**
         * checks setCallable handles types properly. Either the assertion
         * will pass or phpunit will throw an exception.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setCallable
         */
        public function testSetCallable(AlterableCallableRule $rule)
        {
            foreach (self::$callableTypes as $type => $val) {
                $this->assertTrue($rule->setCallable($val));
            }
        }

        /**
         * checks getCallable always returns a callable from an instantiated object.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testSetCallable
         * @covers ::getCallable
         */
        public function testGetCallable(AlterableCallableRule $rule)
        {
            $callable = [self::$callables, 'returnsGivenType'];
            $msg = 'Unable to set callable';
            $this->assertTrue($rule->setCallable($callable), $msg);

            $result = $rule->getCallable();
            $msg = 'Did not get back what was passed in!';
            $this->assertSame($callable, $result, $msg);

            return $rule;
        }

        /**
         * checks isValid only returns boolean
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testSetCallable
         * @covers ::isValid
         */
        public function testIsValid(AlterableCallableRule $rule)
        {
            $msg = 'Unable to set callable';
            $this->assertTrue($rule->setCallable([self::$callables, 'returnsGivenType']), $msg);

            foreach (self::$types as $type => $val) {
                try {
                    $msg = "A $type was returned";
                    $result = $rule->isValid('anyRandomValue');
                    $this->assertTrue(is_bool($result), $msg);
                } catch (\Exception $e) {
                    $class = 'Flair\Validation\Core\UnexpectedValueException';
                    $this->assertInstanceOf($class, $e, 'wrong Exception Class');
                    $this->assertEquals(3, $e->getCode(), $msg . ': wrong Code');
                }
            }
        }
    }
}
