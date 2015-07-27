<?php
namespace Flair\Exception {

    /**
     * The Unit test for the UnexpectedValueException class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Exception\UnexpectedValueException
     */
    class UnexpectedValueExceptionTest extends \PHPUnit_Framework_TestCase
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
         * @var int
         */
        protected static $code = 999;

        /**
         * holds a previous exception
         *
         * @var \Exception
         */
        protected static $previous = null;

        /**
         * A simple helper function that returns a thrown exception.
         *
         * @author Daniel Sherman
         */
        protected function thrower($multi = false)
        {

            if ($multi) {
                $grandParent = new UnexpectedValueException('grandParent', 0);
                $previous = new UnexpectedValueException('parent', 1, $grandParent);
            } else {
                $previous = self::$previous;
            }

            try {
                throw new UnexpectedValueException(self::$msg, self::$code, $previous, self::$context);
            } catch (\Exception $e) {
                return $e;
            }
        }

        /**
         * Checks the object is of the correct type, uses the correct trait, and
         * implements the correct interface.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function testConstruct()
        {
            $exception = $this->thrower();

            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Exception\UnexpectedValueException', $exception, $msg);

            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Exception\ExceptionInterface', $exception, $msg);

            $msg = 'the object does not use the correct trait';
            $this->assertContains('Flair\Exception\ExceptionTrait', class_uses($exception), $msg);
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

        /**
         * Checks getPrevious  works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getPrevious()
         */
        public function testGetPrevious()
        {
            $e = $this->thrower();
            $msg = 'the object is not the correct type';
            $this->assertNull($e->getPrevious(), $msg);

            $e = $this->thrower(true);
            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Exception\UnexpectedValueException', $e->getPrevious(), $msg);
        }

    }
}
