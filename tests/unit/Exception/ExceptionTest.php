<?php
namespace Flair\Exception {

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Exception\Exception
     */
    class ExceptionTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * holds a list of context data.
         *
         * @var array
         */
        protected static $context = [
            'fruit' => [
                'one' => 'Apple',
                'two' => 'Banana',
                'three' => 'Orange',
            ],
            'holes' => [
                'first',
                'second',
                'third',
            ],
            'nested' => [
                'a' => [1, 2, 3],
                'b' => ['one', 'two', 'three'],
            ],
            'random' => 'stuff',
        ];

        /**
         * holds the test message
         *
         * @var string
         */
        protected static $msg = 'My exception message!';

        /**
         * holds the test code
         *
         * @var integere
         */
        protected static $code = 999;

        /**
         * A simple helper function that returns a thrown exception.
         *
         * @author Daniel Sherman
         */
        protected function thrower()
        {
            try {
                throw new Exception(self::$msg, self::$code, self::$context);
            } catch (Exception $e) {
                return $e;
            }
        }

        /**
         * Checks the object is of the correct type.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function testType()
        {
            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Exception\Exception', $this->thrower(), $msg);
        }

        /**
         * Checks the exception Id is of the correct type.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getId
         */
        public function testGetId()
        {
            $msg = 'the id is not the correct type';
            $e = $this->thrower();
            $this->assertTrue(is_string($e->getId()), $msg);
        }

        /**
         * Checks the exception context is of the correct type.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getContext
         */
        public function testGetContext()
        {
            $e = $this->thrower();
            $context = $e->getContext();

            $msg = 'the context is not the correct type';
            $this->assertTrue(is_array($context), $msg);

            $msg = 'the context is not what it should be';
            $this->assertEquals(self::$context, $context, $msg);
        }

        /**
         * Checks the toString function for the context attribute returns the correct type.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getContextAsString
         */
        public function testGetContextAsString()
        {
            $e = $this->thrower();

            $msg = 'the return value was not what it should be';
            $this->assertTrue(is_string($e->getContextAsString()), $msg);
        }

        /**
         * Checks __toString() works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__toString()
         */
        public function testToString()
        {
            $e = $this->thrower();

            $msg = 'the return value was not what it should be';
            $this->assertTrue(is_string($e->__toString()), $msg);
        }

    }
}
