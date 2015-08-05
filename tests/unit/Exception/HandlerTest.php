<?php
namespace Flair\Exception{

    /**
     * the needed test class
     */
    $fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
    require_once $fixturePath . 'HandlerTestLoggers.php';

    /**
     * The Unit test for the Handler class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\Exception\Handler
     */
    class HandlerTest extends \Flair\PhpUnit\TestCase
    {
        /**
         * holds a regular base Flair exception.
         *
         * @var Handler
         */
        protected static $handler = null;

        /**
         * holds the path to the fixture directory.
         *
         * @var string
         */
        protected static $fixturePath = null;

        /**
         * holds a fake logger object
         *
         * @var Handler
         */
        protected static $logger = null;

        /**
         * set up the data for the test case.
         */
        public static function setUpBeforeClass()
        {
            self::$fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
            self::$fixturePath .= 'fixtures' . DIRECTORY_SEPARATOR;
            self::$logger = new HandlerTestLoggers();
        }

        /**
         * set up the needed data before each test.
         */
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
         * makes sure enabling output override works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::enableOutputOverride
         */
        public function testEnableOutputOverride()
        {
            $msg = 'unable to set OutputOverride';
            $result = self::$handler->enableOutputOverride();
            if ($result) {
                //clear the ob just created
                ob_end_flush();
            }
            $this->assertTrue($result, $msg);

            // should get null because it's already been enabled once
            $msg = 'did not get null like we should';
            $result = self::$handler->enableOutputOverride();
            if ($result) {
                //clear the ob just created
                ob_end_flush();
            }
            $this->assertNull($result, $msg);
        }

        /**
         * make sure a valid template can be set.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setTemplate
         */
        public function testSetTemplateValid()
        {
            $temp = self::$fixturePath . 'HandlerTemplate.php';
            $result = self::$handler->setTemplate($temp);
            $msg = 'unable to set a valid template';
            $this->assertTrue($result, $msg);
        }

        /**
         * make sure an invalid template isn't accepted.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setTemplate
         */
        public function testSetTemplateInValid()
        {
            $temp = self::$fixturePath . 'Template.php';
            $result = self::$handler->setTemplate($temp);
            $msg = 'an invalid template got through';
            $this->assertFalse($result, $msg);
        }

        /**
         * make sure only valid file-path strings get through.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setTemplateTypesProvider
         * @covers ::setTemplate
         */
        public function testSetTemplateTypes($type, $val)
        {
            $result = self::$handler->setTemplate($val);
            $this->assertFalse($result);
        }

        /**
         * provides data for testSetMessageFails
         */
        public function setTemplateTypesProvider()
        {
            $data = self::getDataTypeProvider();
            return $data->arrayOfArrays($data->excludeTypes());
        }

        /**
         * make sure a bool is accepted.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setLogging
         */
        public function testsetLoggingBool()
        {
            $result = self::$handler->setLogging(false);
            $this->assertTrue($result);
        }

        /**
         * make sure only a bool is accepted.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setLoggingFailProvider
         * @covers ::setLogging
         */
        public function testSetLoggingFail($type, $val)
        {
            $result = self::$handler->setLogging($val);
            $this->assertFalse($result);
        }

        /**
         * provides data for testSetLoggingFail
         */
        public function setLoggingFailProvider()
        {
            $data = self::getDataTypeProvider();
            return $data->arrayOfArrays($data->excludeTypes(['boolean']));
        }

        /**
         * make sure valid callables are accepted.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @dataProvider setLoggerProvider
         * @covers ::setLogger
         */
        public function testSetLogger($type, $val)
        {
            $result = self::$handler->setLogger($val);
            $this->assertTrue($result);
        }

        /**
         * provides data for testSetLogger
         */
        public function setLoggerProvider()
        {
            $inst = new HandlerTestLoggers();
            return [
                ['core', 'is_string'],
                ['anonymous', function () {return true;}],
                ['instantiated', [$inst, 'publicMethod']],
                ['static method', ['Flair\Exception\HandlerTestLoggers', 'staticMethod']],
                ['instantiate', [new HandlerTestLoggers(), 'publicMethod']],
            ];
        }

        /**
         * makes sure a custom logger gets called
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testSetLogger
         * @covers ::logException
         */
        public function testLogExceptionCustom()
        {
            $result = self::$handler->setLogger([new HandlerTestLoggers(), 'echoMethod']);
            $this->assertTrue($result);
            $e = new Exception('', 0);
            $this->expectOutputString('goodBye');
            self::$handler->logException($e);
        }

        /**
         * makes sure the default output works for regular exceptions
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::generateDefaultOutput
         */
        public function testGenerateDefaultOutput()
        {
            $e = new \Exception('', 0);
            $result = self::$handler->generateDefaultOutput($e);
            $this->assertEquals('Issue: ', $result);
            $stub = $this->getMockBuilder('Flair\Exception\Exception')->disableOriginalConstructor()->getMock();
            $stub->method('getId')->willReturn('123456789');
            $result = self::$handler->generateDefaultOutput($stub);
            $this->assertEquals('Issue: 123456789', $result);
        }

        /**
         * tests that output is generated as expected using a template
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testSetTemplateValid
         * @depends testGenerateDefaultOutput
         * @covers ::generateOutput
         */
        public function testGenerateOutputWithTemplate()
        {
            $temp = self::$fixturePath . 'HandlerTemplate.php';
            $result = self::$handler->setTemplate($temp);
            $msg = 'unable to set a valid template';
            $this->assertTrue($result, $msg);
            $e = new \Exception('', 0);
            $this->expectOutputString('Hello World!');
            self::$handler->generateOutput($e);
        }

        /**
         * tests that output is generated as expected using no template and a regular exception
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testGenerateDefaultOutput
         * @covers ::generateOutput
         */
        public function testGenerateOutputWithRegularException()
        {
            $e = new \Exception('', 0);
            $this->expectOutputString('Issue: ');
            self::$handler->generateOutput($e);
        }

        /**
         * tests that output is generated as expected using no template and a Flair exception
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testGenerateDefaultOutput
         * @covers ::generateOutput
         */
        public function testGenerateOutputWithFlairException()
        {
            $stub = $this->getMockBuilder('Flair\Exception\Exception')->disableOriginalConstructor()->getMock();
            $stub->method('getId')->willReturn('123456789');
            $this->expectOutputString('Issue: 123456789');
            self::$handler->generateOutput($stub);
        }
    }
}
