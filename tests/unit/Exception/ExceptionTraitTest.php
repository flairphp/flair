<?php
namespace Flair\Exception {

    /**
     * The Unit test for the ExceptionTrait class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Exception\ExceptionTrait
     */
    class ExceptionTraitTest extends \Flair\PhpUnit\TestCase
    {
        /**
         * holds the test message
         *
         * @var ExceptionTraitTestUser
         */
        protected static $traitObj = null;

        /**
         * holds the path to the fixture directory
         *
         * @var string
         */
        protected static $fixturePath = null;

        /**
         * set up the needed data before the testing starts.
         */
        public static function setUpBeforeClass()
        {
            self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
            self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;

            require_once self::$fixturePath . 'ExceptionTraitTestUser.php';

            self::$traitObj = new ExceptionTraitTestUser();
        }

        /**
         * mark the test finished.
         */
        public static function tearDownAfterClass()
        {
            self::setFinishedTest();
        }

        /**
         * tests getId gives you what is expected
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getId
         */
        public function testGetId()
        {
            $id = self::$traitObj->getId();

            $msg = 'The exception id is not a string!';
            $this->assertTrue(is_string($id), $msg);

            $msg = 'The exception id is not the proper format!';
            $this->assertRegExp('/^[a-z0-9]{22,}$/', $id, $msg);
        }

        /**
         * tests getContext gives you what is expected
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getContext
         */
        public function testGetContext()
        {
            $context = self::$traitObj->getContext();

            $msg = 'The exception context is not an array!';
            $this->assertTrue(is_array($context), $msg);

            $msg = 'The exception context does not match the reference!';
            $ref = self::$traitObj->contextRef;
            $this->assertEquals($ref, $context, $msg);
        }

        /**
         * tests getContextAsString gives you what is expected
         *
         * @author Daniel Sherman
         * @test
         * @covers ::getContextAsString
         */
        public function testGetContextAsString()
        {
            $context = self::$traitObj->getContextAsString();

            $msg = 'The exception context is not a string!';
            $this->assertTrue(is_string($context), $msg);

            $msg = 'The exception context string does not match the reference string!';
            $refFile = self::$fixturePath . 'ExceptionTraitTestUserContextString.txt';
            $ref = file_get_contents($refFile);
            $this->assertEquals($ref, $context, $msg);
        }

        /**
         * tests __toString gives you what is expected
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__toString
         */
        public function testToString()
        {
            $string = self::$traitObj->__toString();

            $msg = 'The exception __toString is not a string!';
            $this->assertTrue(is_string($string), $msg);
        }
    }
}
