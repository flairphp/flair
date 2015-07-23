<?php
namespace Flair\Validation\Core {

    /**
     * The Unit test for the Exception class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\Core\Rule
     */
    class RuleTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * Checks the object is of the correct type.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function test()
        {
            $rounds = 10000;

            $called = function () {return true;};
            $rule = new Rule($called);

        }
    }
}
