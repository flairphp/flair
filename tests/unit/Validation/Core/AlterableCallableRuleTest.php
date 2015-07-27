<?php
namespace Flair\Validation\Core{

    /**
     * the needed test class
     */
    $fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
    require_once $fixturePath . 'TestCallable.php';

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\Core\Rule
     */
    class AlterableCallableRuleTest extends \PHPUnit_Framework_TestCase
    {
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
            self::$callables = new TestCallable();
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
        public function testSetMessageToString(AlterableCallableRule $rule)
        {
            $msg = "A string was not accepted.";
            $this->assertTrue($rule->setMessage('i am a string'), $msg);
        }

        /**
         * checks setMessage fails on anything thats not a sting
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setMessageFailsProvider
         * @expectedException InvalidArgumentException
         * @expectedExceptionCode 0
         * @covers ::setMessage
         */
        public function testSetMessageFails($type, $val, AlterableCallableRule $rule)
        {
            $rule->setMessage($val);
        }

        /**
         * provides data for testSetMessageFails
         */
        public function setMessageFailsProvider()
        {
            return [
                ['boolean', true],
                ['integer', 1],
                ['float', 1.15],
                ['array', []],
                ['object', new \stdClass()],
                ['resource', fopen(__FILE__, "r")],
                ['null', null],
            ];
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
         * checks setHalt excepts a bool
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setHalt
         */
        public function testSetHaltToBool(AlterableCallableRule $rule)
        {
            $msg = "A boolean was not accepted.";
            $this->assertTrue($rule->setHalt(true), $msg);
        }

        /**
         * checks setHalt fails on anything thats not a bool
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setHaltFailsProvider
         * @expectedException InvalidArgumentException
         * @expectedExceptionCode 1
         * @covers ::setHalt
         */
        public function testSetHaltFails($type, $val, AlterableCallableRule $rule)
        {
            $rule->setHalt($val);
        }

        /**
         * provides data for testSetHaltFails
         */
        public function setHaltFailsProvider()
        {
            return [
                ['string', 'a string'],
                ['integer', 1],
                ['float', 1.15],
                ['array', []],
                ['object', new \stdClass()],
                ['resource', fopen(__FILE__, "r")],
                ['null', null],
            ];
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
         * checks setCallable accepts all the allowed callable types.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setetCallableSuccessProvider
         * @covers ::setCallable
         */
        public function testSetCallableSuccess($type, $val, AlterableCallableRule $rule)
        {
            $this->assertTrue($rule->setCallable($val));
        }

        /**
         * provides data for testSetCallable
         */
        public function setetCallableSuccessProvider()
        {
            $inst = new TestCallable();

            return [
                ['core', 'is_string'],
                ['anonymous', function () {return true;}],
                ['instantiated', [$inst, 'returnsGivenType']],
                ['static method', ['Flair\Validation\Core\TestCallable', 'staticAlwaysTrue']],
                ['instantiate', [new TestCallable(), 'returnsGivenType']],
            ];
        }

        /**
         * checks getCallable always returns a callable from an instantiated object.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
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
         * checks that if is valid gets a bool back from the callable it
         * doesn't throw anything.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::isValid
         */
        public function testIsValidReturnsBool(AlterableCallableRule $rule)
        {
            $result = $rule->isValid(true);
            $this->assertTrue(is_bool($result));
        }

        /**
         * checks isValid throws an excpetion if it doesn't get a boolean
         * result from the callable
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider isValidProvider
         * @expectedException UnexpectedValueException
         * @expectedExceptionCode 3
         * @covers ::isValid
         */
        public function testIsValidFails($type, $val, AlterableCallableRule $rule)
        {
            $rule->isValid($val);
        }

        /**
         * provides data for testIsValidFails
         */
        public function isValidProvider()
        {
            return [
                ['string', 'a string'],
                ['integer', 1],
                ['float', 1.15],
                ['array', []],
                ['object', new \stdClass()],
                ['resource', fopen(__FILE__, "r")],
                ['null', null],
            ];
        }
    }
}
