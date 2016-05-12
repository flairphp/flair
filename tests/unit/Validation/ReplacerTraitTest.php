<?php
namespace Flair\Validation {

    /**
     * The Unit test for the ReplacerTrait class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Validation\ReplacerTrait
     */
    class ReplacerTraitTest extends \Flair\PhpUnit\TestCase
    {
        /**
         * holds the path to the fixture directory
         *
         * @var string
         */
        protected static $fixturePath = null;

        /**
         *  The object being tested
         *
         * @var mixed
         */
        protected static $obj = null;

        /**
         * set up the needed data before the testing starts.
         */
        public static function setUpBeforeClass()
        {
            self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
            self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;

            require_once self::$fixturePath . 'ReplacerTraitTestObject.php';

            self::$obj = new ReplacerTraitTestObject();
        }

        /**
         * mark the test finished.
         */
        public static function tearDownAfterClass()
        {
            self::setFinishedTest();
        }

        /**
         * Checks the object uses the correct trait, and
         * implements the correct interface.
         *
         * @author Daniel Sherman
         * @test
         */
        public function testConstruct()
        {
            $msg = 'the object does not implement the correct interface';
            $this->assertInstanceOf('Flair\Validation\ReplacerInterface', self::$obj, $msg);

            $msg = 'the object does not use the correct trait';
            $this->assertContains('Flair\Validation\ReplacerTrait', class_uses(self::$obj), $msg);
        }

        /**
         * provides data values that aren't strings
         */
        public function nonStringProvider()
        {
            $data = self::getDataTypeProvider();
            return $data->arrayOfArrays($data->excludeTypes(['string']));
        }

        /**
         * Checks if setPrefix throws an exception when it should
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider nonStringProvider
         * @covers ::setPrefix
         */
        public function testSetPrefixInvalid($type, $val)
        {
            try {
                self::$obj->setPrefix($val);
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
                $this->assertEquals(2, $e->getCode());
                $this->assertEquals('$prefix is not a string!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * Checks if setPrefix works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setPrefix
         */
        public function testSetPrefixValid()
        {
            try {
                self::$obj->setPrefix('xx_');
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if setPrefix throws an exception when it should
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider nonStringProvider
         * @covers ::setSuffix
         */
        public function testSetSuffixInvalid($type, $val)
        {
            try {
                self::$obj->setSuffix($val);
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
                $this->assertEquals(3, $e->getCode());
                $this->assertEquals('$suffix is not a string!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * Checks if setPrefix works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setSuffix
         */
        public function testSetSuffixValid()
        {
            try {
                self::$obj->setSuffix('_xx');
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if getPrefix works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testSetPrefixValid
         * @covers ::getPrefix
         */
        public function testGetPrefix()
        {
            $this->assertEquals('xx_', self::$obj->getPrefix());
        }

        /**
         * Checks if getSuffix works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testSetSuffixValid
         * @covers ::getSuffix
         */
        public function testGetSuffix()
        {
            $this->assertEquals('_xx', self::$obj->getSuffix());
        }

        /**
         * Checks if addReplacement throws an exception when a key is not a string
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider nonStringProvider
         * @covers ::addReplacement
         */
        public function testaddReplacementKeyNotValid($type, $val)
        {
            try {
                self::$obj->addReplacement($val, 'random');
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
                $this->assertEquals(5, $e->getCode());
                $this->assertEquals('$key is not a string!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * Checks if addReplacement works as expected when key is a string
         *
         * @author Daniel Sherman
         * @test
         * @covers ::addReplacement
         */
        public function testaddReplacementKeyValid()
        {
            try {
                self::$obj->addReplacement('validKey01', 'valid');
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if addReplacement throws an exception when a duplicate key is passed
         *
         * @author Daniel Sherman
         * @test
         * @depends testaddReplacementKeyValid
         * @covers ::addReplacement
         */
        public function testaddReplacementKeyDuplicate()
        {
            try {
                self::$obj->addReplacement('validKey01', 'valid');
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\LogicException', $e);
                $this->assertEquals(6, $e->getCode());
                $this->assertEquals('$key already exists!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown');
        }

        /**
         * provides data values that aren't scalar
         */
        public function nonScalarProvider()
        {
            $data = self::getDataTypeProvider();
            return $data->arrayOfArrays($data->excludeTypes(['boolean', 'integer', 'float', 'string']));
        }

        /**
         * Checks if addReplacement throws an exception when $value is not a valid input
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider nonScalarProvider
         * @covers ::addReplacement
         */
        public function testaddReplacementValueNotValid($type, $val)
        {
            try {
                self::$obj->addReplacement('random', $val);
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\LogicException', $e);
                $this->assertEquals(7, $e->getCode());
                $this->assertEquals('$value is not a valid type!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * provides data values that aren't scalar
         */
        public function scalarProvider()
        {
            $data = self::getDataTypeProvider();
            return $data->arrayOfArrays($data->includeTypes(['boolean', 'integer', 'float', 'string']));
        }

        /**
         * Checks if addReplacement doesn't throws an exception when $value is a valid input
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider scalarProvider
         * @covers ::addReplacement
         */
        public function testaddReplacementValueValid($type, $val)
        {
            try {
                self::$obj->addReplacement($type, $val);
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if addReplacement doesn't throws an exception when $value is a valid input
         *
         * @author Daniel Sherman
         * @test
         * @covers ::addReplacement
         */
        public function testaddReplacementValueToString()
        {
            $eObj = new \Exception('', 0);
            try {
                self::$obj->addReplacement('__toString', $eObj);
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);

        }

        /**
         * Checks if updateReplacement throws an exception when a key is not a string
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider nonStringProvider
         * @covers ::updateReplacement
         */
        public function testUpdateReplacementKeyNotValid($type, $val)
        {
            try {
                self::$obj->updateReplacement($val, 'random');
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\InvalidArgumentException', $e);
                $this->assertEquals(9, $e->getCode());
                $this->assertEquals('$key is not a string!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * Checks if update works as expected when key is a string
         *
         * @author Daniel Sherman
         * @test
         * @covers ::updateReplacement
         */
        public function testUpdateReplacementKeyValid()
        {
            try {
                self::$obj->updateReplacement('validKey01', 'valid');
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if updateReplacement throws an exception when $value is not a valid input
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider nonScalarProvider
         * @covers ::updateReplacement
         */
        public function testUpdateReplacementValueNotValid($type, $val)
        {
            try {
                self::$obj->updateReplacement('random', $val);
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\LogicException', $e);
                $this->assertEquals(10, $e->getCode());
                $this->assertEquals('$value is not a valid type!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown for a value of type: ' . $type);
        }

        /**
         * Checks if updateReplacement doesn't throws an exception when $value is a valid input
         *
         * @author Daniel Sherman
         * @test
         * @dataProvider scalarProvider
         * @covers ::updateReplacement
         */
        public function testupdateReplacementValueValid($type, $val)
        {
            try {
                self::$obj->updateReplacement($type, $val);
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);
        }

        /**
         * Checks if updateReplacement doesn't throws an exception when $value is a valid input
         *
         * @author Daniel Sherman
         * @test
         * @covers ::updateReplacement
         */
        public function testUpdateReplacementValueToString()
        {
            $eObj = new \Exception('', 0);
            try {
                self::$obj->updateReplacement('__toString', $eObj);
            } catch (\Exception $e) {
                $this->fail('An exception was thrown');
                return;
            }

            // a dummy assertion to deal with phpunit stupidity
            $this->assertEquals(1, 1);

        }

        /**
         * Checks if hasReplacement works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testaddReplacementKeyValid
         * @covers ::hassReplacement
         */
        public function testhasReplacement()
        {
            $this->assertTrue(self::$obj->hasReplacement('validKey01'));
            $this->assertFalse(self::$obj->hasReplacement('inValidKey'));

        }

        /**
         * Checks if getReplacement works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testaddReplacementKeyValid
         * @covers ::getReplacement
         */
        public function testGetReplacement()
        {
            $this->assertEquals('valid', self::$obj->getReplacement('validKey01'));

            try {
                self::$obj->getReplacement('inValidKey');
            } catch (\Exception $e) {
                $this->assertInstanceOf('Flair\Validation\OutOfBoundsException', $e);
                $this->assertEquals(4, $e->getCode());
                $this->assertEquals('$key does not exist!', $e->getMessage());
                return;
            }
            $this->fail('An exception was not thrown');
        }

        /**
         * Checks if deleteReplacement works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testaddReplacementKeyValid
         * @covers ::deleteReplacement
         */
        public function testDeleteReplacement()
        {
            $this->assertTrue(self::$obj->hasReplacement('validKey01'));
            self::$obj->deleteReplacement('validKey01');
            $this->assertFalse(self::$obj->hasReplacement('validKey01'));
        }

        /**
         * Checks if GetKeys works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testaddReplacementKeyValid
         * @depends testaddReplacementValueValid
         * @depends testaddReplacementValueToString
         * @depends testDeleteReplacement
         * @covers ::getKeys
         */
        public function testGetKeys()
        {
            $expected = ['boolean', 'integer', 'float', 'string', '__toString'];
            $this->assertEquals($expected, self::$obj->getKeys());
        }

        /**
         * Checks if doReplacements works as expected
         *
         * @author Daniel Sherman
         * @test
         * @depends testSetPrefixValid
         * @depends testSetSuffixValid
         * @depends testaddReplacementKeyValid
         * @depends testaddReplacementValueValid
         * @depends testaddReplacementValueToString
         * @depends testDeleteReplacement
         * @covers ::getKeys
         */
        public function testDoReplacements()
        {
            self::$obj->deleteReplacement('__toString');
            self::$obj->setPrefix('__');
            self::$obj->setSuffix('__');

            $template = '__boolean____integer____float____string__';
            $expected = '111.15A string';
            $this->assertEquals($expected, self::$obj->doReplacements($template));
        }

    }
}
