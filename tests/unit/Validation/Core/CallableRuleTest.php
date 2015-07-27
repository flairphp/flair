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
    class CallableRuleTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * holds a list of basic types to test against.
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
            $rule = new CallableRule([self::$callables, 'returnsGivenType'], [], 'error Message', true);

            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Validation\Core\CallableRule', $rule, $msg);

            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Validation\Core\RuleInterface', $rule, $msg);

            $msg = 'the object does not use the correct trait';
            $this->assertContains('Flair\Validation\Core\CallableRuleTrait', class_uses($rule), $msg);

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
        public function testSetMessage(CallableRule $rule)
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
        public function testGetMessage(CallableRule $rule)
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
        public function testSetHalt(CallableRule $rule)
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
        public function testGetHalt(CallableRule $rule)
        {
            $msg = 'Did not get back a bool!';
            $this->assertTrue(is_bool($rule->getHalt()), $msg);
        }

        /**
         * checks isValid only returns boolean
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::isValid
         */
        public function testIsValid(CallableRule $rule)
        {
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
