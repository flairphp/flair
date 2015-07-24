<?php
namespace Flair\AutoLoader {

    /**
     * The Unit test for the Psr4 class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\AutoLoader\Psr4
     */
    class Psr4Test extends \PHPUnit_Framework_TestCase
    {

        /**
         * holds a list of types to test against, that should not be accepted.
         *
         * @var array
         */
        protected static $types = [];

        /**
         * The object being tested.
         *
         * @var Flair\AutoLoader\Psr4
         */
        protected $testObject = null;

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
        }

        /**
         * Set up the object before each test
         */
        protected function setUp()
        {
            $this->testObject = new Psr4();
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
            $autoLoader = new Psr4();
            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\AutoLoader\Psr4', $autoLoader, $msg);
            return $autoLoader;
        }

        /**
         * Checks if getPrefixes works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::getPrefixes
         */
        public function testGetPrefixes(Psr4 $autoLoader)
        {
            $val = $autoLoader->getPrefixes();
            $this->assertTrue(is_array($val), 'An array was not returned');
            return $autoLoader;
        }

        /**
         * Checks if addPrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testGetPrefixes
         * @covers ::addPrefix
         */
        public function testAddPrefix(Psr4 $autoLoader)
        {
            $prefix = 'Flair\Autoloader';
            $baseDir = '/www/libs/';

            $result = $autoLoader->addPrefix($prefix, $baseDir);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $prefixes = [$prefix => $baseDir];
            $storedPrefixes = $autoLoader->getPrefixes();
            $this->assertEquals($prefixes, $storedPrefixes, 'the prefix did not get saved properly!');
            return $autoLoader;
        }

        /**
         * Checks if removePrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testAddPrefix
         * @covers ::removePrefix
         */
        public function testRemovePrefix(Psr4 $autoLoader)
        {
            $prefix = 'Flair\Autoloader';
            $autoLoader->removePrefix($prefix);
            $prefixes = $autoLoader->getPrefixes();
            $this->assertEquals([], $prefixes, 'the prefix did not get removed properly!');
        }

        /**
         * Checks if add prefix forces the proper type constraints.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::addPrefix
         */
        public function testAddPrefixTypeConstraint(Psr4 $autoLoader)
        {
            foreach (self::$types as $prefixType => $prefixVal) {
                foreach (self::$types as $baseDirType => $baseDirVal) {
                    $result = $autoLoader->addPrefix($prefixVal, $baseDirVal);

                    $msg = "A prefix type of $prefixType was accepted";
                    $msg .= " with a baseDir type of $baseDirType!";

                    if ($prefixType !== 'string') {
                        // we should get false any time $prefixType is not a string
                        $this->assertFalse($result, $msg);
                    } else {
                        if ($baseDirType === 'string') {
                            // we should get true if a sting was passed
                            $this->assertTrue($result, $msg);
                        } else {
                            // false should be returned for enverything else
                            $this->assertFalse($result, $msg);
                        }
                    }
                }
            }
        }

        /**
         * Checks if register works as expected, and doesn't throw an exception
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::register
         */
        public function testRegister(Psr4 $autoLoader)
        {
            $e = null;
            try {
                $autoLoader->register();
            } catch (\LogicException $e) {}

            $this->assertNull($e, 'The autloader failed to register');
            return $autoLoader;
        }

        /**
         * Checks if deregister works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testRegister
         * @covers ::deregister
         */
        public function testDeregisterSuccess(Psr4 $autoLoader)
        {

            $result = $autoLoader->deregister();
            $this->assertTrue($result, 'Failed to deregister');
            return $autoLoader;
        }

        /**
         * Checks if deregister fails as expected.
         * @author Daniel Sherman
         * @test
         * @depends testDeregisterSuccess
         * @covers ::deregister
         */
        public function testDeregisterFail(Psr4 $autoLoader)
        {
            $result = $autoLoader->deregister();
            $this->assertFalse($result, 'deregisterd something that was not registered');
        }

        /**
         * Checks if addToIncludePath works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::addToIncludePath
         */
        public function testAddToIncludePath()
        {
            $newPath = '/www';
            $origonalPath = get_include_path();

            $result = $this->testObject->addToIncludePath($newPath);
            $this->assertTrue($result, 'The include path failed to update');

            $expected = $origonalPath . PATH_SEPARATOR . $newPath;
            $newpath = get_include_path();

            $this->assertEquals($expected, $newpath, 'The include is not what it should be');

            set_include_path($origonalPath);
        }

        /**
         * Checks if addToIncludePath handles types properly.
         * @author Daniel Sherman
         * @test
         * @covers ::addToIncludePath
         */
        public function testAddToIncludePathTypeConstraint()
        {
            $origonalPath = get_include_path();

            foreach (self::$types as $type => $val) {

                $result = $this->testObject->addToIncludePath($val);
                $msg = "A value of type $type was accepted";

                if ($type !== 'string') {
                    $this->assertFalse($result, $msg);
                } else {
                    $this->assertTrue($result, $msg);
                }
            }

            set_include_path($origonalPath);
        }

        /**
         * Checks if removeFromIncludePath works.
         * @author Daniel Sherman
         * @test
         * @covers ::removeFromIncludePath
         */
        public function testRemoveFromIncludePath()
        {
            $newPath = '/www';
            $origonalPath = get_include_path();

            $this->testObject->addToIncludePath($newPath);

            $result = $this->testObject->removeFromIncludePath($newPath);
            $this->assertTrue($result, 'The path was not removed from the include path');

            $updatedPath = get_include_path();
            $this->assertEquals($origonalPath, $updatedPath, 'The include path is not what it should be');

            set_include_path($origonalPath);
        }

        /**
         * Checks if load only accepts strings.
         * @author Daniel Sherman
         * @test
         * @covers ::load
         */
        public function testLoadTypeConstraint()
        {
            foreach (self::$types as $type => $val) {
                if ($type !== 'string') {
                    $result = $this->testObject->load($val);
                    $msg = "A value of type $type was accepted";
                    $this->assertFalse($result, $msg);
                }
            }
        }

        /**
         * Checks if load works as expected using the inclde path
         * @author Daniel Sherman
         * @test
         * @covers ::load
         */
        public function testLoadIncludePath()
        {
            $origonalIncludePath = get_include_path();
            $prefix = 'Vendor\\Simple';
            $baseDir = 'Vendor' . DIRECTORY_SEPARATOR . 'Simple' . DIRECTORY_SEPARATOR;

            $newPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '_TestClasses';
            $newPath .= DIRECTORY_SEPARATOR . 'Psr4';

            //configure the object
            $this->testObject->addToIncludePath($newPath);
            $this->testObject->addPrefix($prefix, $baseDir);
            $this->testObject->register();

            // the actual assertions/tests
            $result = $this->testObject->load('Vendor\\Simple\\ClassOne');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('Vendor\\Simple\\ClassOne', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $this->testObject->load('Vendor\\Simple\\NonexistentClassOne');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $this->testObject->load('Vendor\\Complex\\ClassOne');
            $this->assertFalse($result, 'The prefix was not configured');

            // un-configure the object
            $this->testObject->deregister();
            $this->testObject->removePrefix($prefix);
            $this->testObject->removeFromIncludePath($newPath);
            set_include_path($origonalIncludePath);
        }

        /**
         * Checks if load works as expected
         * @author Daniel Sherman
         * @test
         * @covers ::load
         */
        public function testLoad()
        {
            $prefix = 'Vendor\\Simple';
            $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '_TestClasses';
            $baseDir .= DIRECTORY_SEPARATOR . 'Psr4' . DIRECTORY_SEPARATOR;
            $baseDir .= 'Vendor' . DIRECTORY_SEPARATOR . 'Simple' . DIRECTORY_SEPARATOR;

            //configure the object
            $this->testObject->addPrefix($prefix, $baseDir);
            $this->testObject->register();

            // the actual assertions/tests
            $result = $this->testObject->load('Vendor\\Simple\\ClassTwo');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('Vendor\\Simple\\ClassTwo', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $this->testObject->load('Vendor\\Simple\\NonexistentClassTwo');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $this->testObject->load('Vendor\\Complex\\ClassTwo');
            $this->assertFalse($result, 'The prefix was not configured');

            // un-configure the object
            $this->testObject->deregister();
            $this->testObject->removePrefix($prefix);
        }
    }
}
