<?php
namespace Flair\AutoLoader {

    /**
     * The Unit test for the psr0 class.
     *
     * @author Daniel Sherman
     * @coversDefaultClass \Flair\AutoLoader\Psr0
     */
    class Psr0Test extends \PHPUnit_Framework_TestCase
    {

        /**
         * holds a list of types to test against, that should not be accepted.
         *
         * @var array
         */
        protected static $types = [];

        /**
         * The object being tested
         *
         * @var Flair\AutoLoader\Psr0
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
            $this->testObject = new Psr0();
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
            $this->assertInstanceOf('Flair\AutoLoader\Psr0', $this->testObject, $msg);
        }

        /**
         * Checks if getDefaultPathPrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::getDefaultPathPrefix
         */
        public function testGetDefaultPathPrefix()
        {
            $val = $this->testObject->getDefaultPathPrefix();
            $this->assertEquals('', $val, 'The default path should be blank');
        }

        /**
         * Checks if setDefaultPathPrefix works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setDefaultPathPrefix
         */
        public function testSetDefaultPathPrefix()
        {
            $setTo = '/www/libs/';
            $result = $this->testObject->setDefaultPathPrefix($setTo);
            $this->assertTrue($result, 'The default prefix did not saved sucessfully');

            $val = $this->testObject->getDefaultPathPrefix();
            $this->assertEquals($setTo, $val, 'The default prefix is not what it should be!');
        }

        /**
         * Checks if setDefaultPathPrefix forces the proper type constraint.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::setDefaultPathPrefix
         */
        public function testSetDefaultPathPrefixTypeConstraint()
        {
            foreach (self::$types as $type => $val) {

                $result = $this->testObject->setDefaultPathPrefix($val);
                $msg = "A value of type $type was accepted";

                if ($type !== 'string') {
                    $this->assertFalse($result, $msg);
                } else {
                    $this->assertTrue($result, $msg);
                }
            }
        }

        /**
         * Checks if getPrefixes works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::getPrefixes
         */
        public function testGetPrefixes()
        {
            $val = $this->testObject->getPrefixes();
            $this->assertTrue(is_array($val), 'An array was not returned');
        }

        /**
         * Checks if addPrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::addPrefix
         */
        public function testAddPrefix()
        {
            $prefix = 'Flair\Autoloader';
            $pathPrefix = '/www/libs/';

            $result = $this->testObject->addPrefix($prefix, $pathPrefix);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $prefixes = [$prefix => $pathPrefix];
            $storedPrefixes = $this->testObject->getPrefixes();
            $this->assertEquals($prefixes, $storedPrefixes, 'the prefix did not get saved properly!');
        }

        /**
         * Checks if addPrefix works as expected when no pathprefix is passed.
         * @author Daniel Sherman
         * @test
         * @covers ::addPrefix
         */
        public function testAddPrefixDefault()
        {
            $prefix = 'Flair\Autoloader';
            $pathPrefix = '/www/libs/HelloWorld';

            $result = $this->testObject->setDefaultPathPrefix($pathPrefix);
            $this->assertTrue($result, 'The default prefix did not save sucessfully');

            $result = $this->testObject->addPrefix($prefix);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $prefixes = [$prefix => $pathPrefix];
            $storedPrefixes = $this->testObject->getPrefixes();
            $this->assertEquals($prefixes, $storedPrefixes, 'the prefix did not get saved properly!');
        }

        /**
         * Checks if add prefix forces the proper type constraints.
         *
         * @author Daniel Sherman
         * @test
         * @covers ::addPrefix
         */
        public function testAddPrefixTypeConstraint()
        {
            foreach (self::$types as $prefixType => $prefixVal) {
                foreach (self::$types as $pathPrefixType => $pathPrefixVal) {
                    $result = $this->testObject->addPrefix($prefixVal, $pathPrefixVal);
                    $msg = "A prefix type of $prefixType was accepted";
                    $msg .= " with a path prefix type of $pathPrefixType!";

                    if ($prefixType !== 'string') {
                        // we should get false any time $prefixType is not a string
                        $this->assertFalse($result, $msg);
                    } else {
                        if ($pathPrefixType === 'string' || $pathPrefixType === 'null') {
                            // we should get true if a sting or null was passed
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
         * Checks if removePrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::removePrefix
         */
        public function testRemovePrefix()
        {
            $prefix = 'Flair\Autoloader';
            $pathPrefix = '/www/libs/';

            $result = $this->testObject->addPrefix($prefix, $pathPrefix);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $this->testObject->removePrefix($prefix);
            $prefixes = $this->testObject->getPrefixes();
            $this->assertEquals([], $prefixes, 'the prefix did not get removed properly!');
        }

        /**
         * Checks if register works as expected, and doesn't throw an exception
         * @author Daniel Sherman
         * @test
         * @covers ::register
         */
        public function testRegister()
        {
            $e = null;
            try {
                $this->testObject->register();
            } catch (\LogicException $e) {}

            $this->assertNull($e, 'The autloader failed to register');
        }

        /**
         * Checks if deregister works as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::deregister
         */
        public function testDeregisterSuccess()
        {
            $this->testRegister();

            $result = $this->testObject->deregister();
            $this->assertTrue($result, 'Failed to deregister');
        }

        /**
         * Checks if deregister fails as expected.
         * @author Daniel Sherman
         * @test
         * @covers ::deregister
         */
        public function testDeregisterFail()
        {
            $result = $this->testObject->deregister();
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
            $prefix = 'Simple';
            $newPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '_testClasses';

            //configure the object
            $this->testObject->addToIncludePath($newPath);
            $this->testObject->addPrefix($prefix);
            $this->testObject->register();

            // the actual assertions/tests
            $result = $this->testObject->load('simpleClass');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('simpleClass', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $this->testObject->load('simpleNonexistentClass');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $this->testObject->load('ComplexClass');
            $this->assertFalse($result, 'The prefix was not configured');

            // un-configure the object
            $this->testObject->deregister();
            $this->testObject->removePrefix($prefix);
            $this->testObject->removeFromIncludePath($newPath);
            set_include_path($origonalIncludePath);
        }

        /**
         * Checks if load works as expected using the default path prefix
         * @author Daniel Sherman
         * @test
         * @covers ::load
         */
        public function testLoadDefaultPathPrefix()
        {
            $prefix = 'Simple';
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '_testClasses' . DIRECTORY_SEPARATOR;

            //configure the object
            $this->testObject->setDefaultPathPrefix($path);
            $this->testObject->addPrefix($prefix);
            $this->testObject->register();

            // the actual assertions/tests
            $result = $this->testObject->load('simpleClassTwo');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('simpleClassTwo', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $this->testObject->load('simpleNonexistentClassTwo');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $this->testObject->load('ComplexClassTwo');
            $this->assertFalse($result, 'The prefix was not configured');

            // un-configure the object
            $this->testObject->deregister();
            $this->testObject->setDefaultPathPrefix('');
            $this->testObject->removePrefix($prefix);

        }

        /**
         * Checks if load works as expected using the default path prefix
         * @author Daniel Sherman
         * @test
         * @covers ::load
         */
        public function testLoadPassedPathPrefix()
        {
            $prefix = 'Simple';
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . '_testClasses' . DIRECTORY_SEPARATOR;

            //configure the object
            $this->testObject->addPrefix($prefix, $path);
            $this->testObject->register();

            // the actual assertions/tests
            $result = $this->testObject->load('simpleClassThree');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('simpleClassThree', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $this->testObject->load('simpleNonexistentClassThree');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $this->testObject->load('ComplexClassThree');
            $this->assertFalse($result, 'The prefix was not configured');

            // un-configure the object
            $this->testObject->deregister();
            $this->testObject->removePrefix($prefix);
        }

    }
}
