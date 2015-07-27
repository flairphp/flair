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
         * Checks the object is of the correct type
         *
         * @author Daniel Sherman
         * @test
         * @covers ::__construct
         */
        public function testConstruct()
        {
            $autoLoader = new Psr0();
            $msg = 'the object is not the correct type';
            $this->assertInstanceOf('Flair\AutoLoader\Psr0', $autoLoader, $msg);
            return $autoLoader;
        }

        /**
         * Checks if getDefaultPathPrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::getDefaultPathPrefix
         */
        public function testGetDefaultPathPrefix(Psr0 $autoLoader)
        {
            $val = $autoLoader->getDefaultPathPrefix();
            $this->assertEquals('', $val, 'The default path should be blank');
        }

        /**
         * Checks if setDefaultPathPrefix works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::setDefaultPathPrefix
         */
        public function testSetDefaultPathPrefix(Psr0 $autoLoader)
        {
            $setTo = '/www/libs/';
            $result = $autoLoader->setDefaultPathPrefix($setTo);
            $this->assertTrue($result, 'The default prefix did not saved successfully');
            return $autoLoader;

        }

        /**
         * Checks if getDefaultPathPrefix works as expected.
         *
         * @author Daniel Sherman
         * @test
         * @depends testSetDefaultPathPrefix
         * @covers ::getDefaultPathPrefix
         */
        public function testDefaultPathPrefixSaved(Psr0 $autoLoader)
        {
            $setTo = '/www/libs/';
            $val = $autoLoader->getDefaultPathPrefix();
            $this->assertEquals($setTo, $val, 'The default prefix is not what it should be!');

            $result = $autoLoader->setDefaultPathPrefix('');
            $this->assertTrue($result, 'The default prefix did not saved successfully');

            return $autoLoader;
        }

        /**
         * Checks if setDefaultPathPrefix forces the proper type constraint.
         *
         * @author Daniel Sherman
         * @test
         * @depends testDefaultPathPrefixSaved
         * @covers ::setDefaultPathPrefix
         */
        public function testSetDefaultPathPrefixTypeConstraint(Psr0 $autoLoader)
        {
            foreach (self::$types as $type => $val) {

                $result = $autoLoader->setDefaultPathPrefix($val);
                $msg = "A value of type $type was accepted";

                if ($type !== 'string') {
                    $this->assertFalse($result, $msg);
                } else {
                    $this->assertTrue($result, $msg);
                }
            }

            $result = $autoLoader->setDefaultPathPrefix('');
            $this->assertTrue($result, 'The default prefix did not saved successfully');
        }

        /**
         * Checks if getPrefixes works as expected. and the value passed into
         * addPrefix saved correctly.
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::getPrefixes
         */
        public function testGetPrefixes(Psr0 $autoLoader)
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
        public function testAddPrefix(Psr0 $autoLoader)
        {
            $prefix = 'Flair\Autoloader';
            $pathPrefix = '/www/libs/';

            $result = $autoLoader->addPrefix($prefix, $pathPrefix);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $prefixes = [$prefix => $pathPrefix];
            $storedPrefixes = $autoLoader->getPrefixes();
            $this->assertEquals($prefixes, $storedPrefixes, 'the prefix did not get saved properly!');
            return $autoLoader;
        }

        /**
         * Checks if removePrefix works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testGetPrefixes
         * @covers ::removePrefix
         */
        public function testRemovePrefix(Psr0 $autoLoader)
        {
            $prefix = 'Flair\Autoloader';
            $result = $autoLoader->removePrefix($prefix);
            $this->assertTrue($result, 'the prefix did not get removed');

            $prefixes = $autoLoader->getPrefixes();
            $this->assertEquals([], $prefixes, 'the prefix did not get removed properly!');
        }

        /**
         * Checks if addPrefix works as expected when no pathprefix is passed.
         * @author Daniel Sherman
         * @test
         * @depends testSetDefaultPathPrefix
         * @depends testAddPrefix
         * @depends testGetPrefixes
         * @depends testRemovePrefix
         * @covers ::addPrefix
         */
        public function testAddPrefixDefault(Psr0 $autoLoader)
        {
            $prefix = 'Flair\Autoloader';
            $pathPrefix = '/www/libs/HelloWorld';

            $result = $autoLoader->setDefaultPathPrefix($pathPrefix);
            $this->assertTrue($result, 'The default prefix did not save successfully');

            $result = $autoLoader->addPrefix($prefix);
            $this->assertTrue($result, 'a valid prefix could not be added!');

            $prefixes = [$prefix => $pathPrefix];
            $storedPrefixes = $autoLoader->getPrefixes();
            $this->assertEquals($prefixes, $storedPrefixes, 'the prefix did not get saved properly!');

            $result = $autoLoader->setDefaultPathPrefix('');
            $this->assertTrue($result, 'The default prefix did not save successfully');

            $result = $autoLoader->removePrefix($prefix);
            $this->assertTrue($result, 'the prefix did not get removed');

            return $autoLoader;
        }

        /**
         * Checks if add prefix forces the proper type constraints.
         *
         * @author Daniel Sherman
         * @test
         * @depends testAddPrefixDefault
         * @depends testGetPrefixes
         * @depends testRemovePrefix
         * @covers ::addPrefix
         */
        public function testAddPrefixTypeConstraint(Psr0 $autoLoader)
        {
            foreach (self::$types as $prefixType => $prefixVal) {

                foreach (self::$types as $pathPrefixType => $pathPrefixVal) {

                    $result = $autoLoader->addPrefix($prefixVal, $pathPrefixVal);
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

            $storedPrefixes = $autoLoader->getPrefixes();
            $this->assertTrue(is_array($storedPrefixes), 'An array was not returned');
            foreach ($storedPrefixes as $key => $val) {
                $result = $autoLoader->removePrefix($key);
                $this->assertTrue($result, 'the prefix did not get removed');
            }
        }

        /**
         * Checks if register works as expected, and doesn't throw an exception
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::register
         */
        public function testRegister(Psr0 $autoLoader)
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
        public function testDeregisterSuccess(Psr0 $autoLoader)
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
        public function testDeregisterFail(Psr0 $autoLoader)
        {
            $result = $autoLoader->deregister();
            $this->assertFalse($result, 'deregisterd something that was not registered');
        }

        /**
         * Checks if addToIncludePath works as expected.
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::addToIncludePath
         */
        public function testAddToIncludePath(Psr0 $autoLoader)
        {
            $newPath = '/someCrapola';
            $origonalPath = get_include_path();

            $result = $autoLoader->addToIncludePath($newPath);
            $this->assertTrue($result, 'The include path failed to update');

            $expected = $origonalPath . PATH_SEPARATOR . $newPath;
            $newpath = get_include_path();

            $this->assertEquals($expected, $newpath, 'The include is not what it should be');

            set_include_path($origonalPath);
            return $autoLoader;
        }

        /**
         * Checks if addToIncludePath handles types properly.
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @covers ::addToIncludePath
         */
        public function testAddToIncludePathTypeConstraint(Psr0 $autoLoader)
        {
            $origonalPath = get_include_path();

            foreach (self::$types as $type => $val) {

                $result = $autoLoader->addToIncludePath($val);
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
         * @depends testConstruct
         * @covers ::removeFromIncludePath
         */
        public function testRemoveFromIncludePath(Psr0 $autoLoader)
        {
            $newPath = '/www';
            $origonalPath = get_include_path();

            set_include_path($origonalPath . PATH_SEPARATOR . $newPath);

            $result = $autoLoader->removeFromIncludePath($newPath);
            $this->assertTrue($result, 'The path was not removed from the include path');

            $updatedPath = get_include_path();
            $this->assertEquals($origonalPath, $updatedPath, 'The include path is not what it should be');

            set_include_path($origonalPath);
        }

        /**
         * Checks if load works as expected using the include path
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testAddToIncludePath
         * @depends testAddPrefix
         * @depends testRemovePrefix
         * @depends testRemoveFromIncludePath
         * @covers ::load
         */
        public function testLoadIncludePath(Psr0 $autoLoader)
        {
            $origonalIncludePath = get_include_path();

            $prefix = 'Simple';
            $newPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';

            //configure the object
            $result = $autoLoader->addToIncludePath($newPath);
            $this->assertTrue($result, 'updating the includepath failed');
            $result = $autoLoader->addPrefix($prefix);
            $this->assertTrue($result, 'adding a prefix failed');

            // the actual assertions/tests
            $result = $autoLoader->load('SimpleClass');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('SimpleClass', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $autoLoader->load('SimpleNonexistentClass');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $autoLoader->load('ComplexClass');
            $this->assertFalse($result, 'The prefix was not configured');

            // reconfigure the object
            $result = $autoLoader->removePrefix($prefix);
            $this->assertTrue($result, 'removing a prefix failed');
            $result = $autoLoader->removeFromIncludePath($newPath);
            $this->assertTrue($result, 'updating includepath failed');
            set_include_path($origonalIncludePath);
        }

        /**
         * Checks if load works as expected using the default path prefix
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testSetDefaultPathPrefix
         * @depends testAddPrefix
         * @depends testRemovePrefix
         * @covers ::load
         */
        public function testLoadDefaultPathPrefix(Psr0 $autoLoader)
        {
            $prefix = 'Simple';
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

            //configure the object
            $result = $autoLoader->setDefaultPathPrefix($path);
            $this->assertTrue($result, 'setting the default prefix failed');
            $result = $autoLoader->addPrefix($prefix);
            $this->assertTrue($result, 'adding a prefix failed');

            // the actual assertions/tests
            $result = $autoLoader->load('SimpleClassTwo');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('SimpleClassTwo', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $autoLoader->load('SimpleNonexistentClassTwo');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $autoLoader->load('ComplexClassTwo');
            $this->assertFalse($result, 'The prefix was not configured');

            // reconfigure
            $result = $autoLoader->setDefaultPathPrefix($path);
            $this->assertTrue($result, 'setting the default prefix failed');
            $result = $autoLoader->removePrefix($prefix);
            $this->assertTrue($result, 'removing a prefix failed');
        }

        /**
         * Checks if load works as expected using the default path prefix
         * @author Daniel Sherman
         * @test
         * @depends testConstruct
         * @depends testAddPrefix
         * @depends testRemovePrefix
         * @covers ::load
         */
        public function testLoadPassedPathPrefix(Psr0 $autoLoader)
        {
            $prefix = 'Simple';
            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

            //configure the object
            $result = $autoLoader->addPrefix($prefix, $path);
            $this->assertTrue($result, 'adding a prefix failed');

            // the actual assertions/tests
            $result = $autoLoader->load('SimpleClassThree');
            $this->assertTrue($result, 'the class file did not get load');

            $result = class_exists('SimpleClassThree', false);
            $this->assertTrue($result, 'the class is not in scope');

            $result = $autoLoader->load('SimpleNonexistentClassThree');
            $this->assertFalse($result, 'the class/file does not exist');

            $result = $autoLoader->load('ComplexClassThree');
            $this->assertFalse($result, 'The prefix was not configured');

            // reconfigure
            $result = $autoLoader->removePrefix($prefix);
            $this->assertTrue($result, 'removing a prefix failed');
        }

    }
}
