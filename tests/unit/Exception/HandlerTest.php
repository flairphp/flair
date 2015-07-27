<?php
namespace Flair\Exception {

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Exception\Handler
     */
    class HandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * holds a regular base Flair exception.
         *
         * @var Handler
         */
        protected static $handler = null;

        protected function setUp()
        {
            self::$handler = new Handler();
        }

        /**
         * Checks the object is of the correct type
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function testConstruct()
        {
            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\Exception\Handler', self::$handler, $msg);
        }

        /**
         * makes sure invalid types are not accepted
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider setBufferingFailProvider
         * @covers ::setBuffering
         */
        public function testSetBufferingFail($type, $val)
        {
            $msg = "an input of type $type was accepted";
            $this->assertFalse(self::$handler->setBuffering($val), $msg);
        }

        /**
         * provides data for testSetHaltFails
         */
        public function setBufferingFailProvider()
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
