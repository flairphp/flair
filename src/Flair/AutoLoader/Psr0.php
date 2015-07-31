<?php
namespace Flair\AutoLoader {

    /**
     * Used to automatically load files that are
     * compliant with the PSR-0 standard.
     *
     * The class uses the concept of class prefix Identifiers to determine if a
     * class should be loaded. Additionally each prefix can have a path prefix
     * that will be prepended to the filename before trying to include it.
     * @author Daniel Sherman
     * @todo simplify unit tests
     */
    class Psr0
    {

        /**
         * The path prefix that will be prepended to a filename if one wasn't registered
         * with the prefix.
         *
         * @var string
         */
        protected $defaultPathPrefix = '';

        /**
         * an associative array of namespace/class prefixes and their path prefixes.
         * The key is the class prefix, & the value is the path prefix.
         *
         * @var Array
         */
        protected $prefixes = [];

        /**
         * Gets the current value of $defaultPathPrefix
         *
         * @uses defaultPathPrefix
         * @return string
         */
        public function getDefaultPathPrefix()
        {
            return $this->defaultPathPrefix;
        }

        /**
         * sets $defaultPathPrefix
         *
         * @uses defaultPathPrefix
         * @param string $path What the new default should be.
         * @return boolean true it it works, false if $path was invalid.
         */
        public function setDefaultPathPrefix($path = '')
        {
            if (is_string($path)) {
                $this->defaultPathPrefix = $path;
                return true;
            }

            return false;
        }

        /**
         * gets the current value of $pefixes
         *
         * @uses prefixes
         * @return array
         */
        public function getPrefixes()
        {
            return $this->prefixes;
        }

        /**
         * Adds a new prefix to, or resets an existing prefix in the internal array.
         * If $pathPrefix is not passed, $defaultPathPrefix will be used instead.
         *
         * @param string $prefix The class name prefix used to identify classes than
         * should be loaded.
         * @param string $pathPrefix The Optional path prefix that will be prepended to
         * the class, before attemting to load it.
         * @uses defaultPathPrefix
         * @uses prefixes
         * @return boolean true it it works, false if $prefix or $pathPrefix was invalid.
         */
        public function addPrefix($prefix, $pathPrefix = null)
        {

            if (!is_string($prefix)) {
                // $prefix isn't valid so return
                return false;
            }

            if (is_string($pathPrefix) || is_null($pathPrefix)) {
                if (!is_string($pathPrefix)) {
                    // use the default
                    $pathPrefix = $this->defaultPathPrefix;
                }
            } else {
                return false;
            }

            $this->prefixes[$prefix] = $pathPrefix;
            return true;
        }

        /**
         * Removes an existing prefix from the internal array.
         *
         * @param string $prefix The class name prefix to remove.
         * @return boolean true it it works, false otherwise.
         * @uses prefixes
         */
        public function removePrefix($prefix)
        {
            if (isset($this->prefixes[$prefix])) {
                unset($this->prefixes[$prefix]);
                return true;
            }

            return false;
        }

        /**
         * Registers the class with php as an autoloader.
         *
         * @param bool $prepend Should the loader be prepended to the list.
         * @throws \LogicException If spl_autoload_register fails.
         */
        public function register($prepend = false)
        {
            if (!is_bool($prepend)) {
                // somone didn't give a valid value so we will use the defualt
                $prepend = false;
            }

            spl_autoload_register([$this, 'load'], true, $prepend);
        }

        /**
         * Deregisters the class with php as an autoloader if it's not needed anymore.
         *
         * @return boolean true it it works, false otherwise.
         */
        public function deregister()
        {
            return spl_autoload_unregister([$this, 'load']);
        }

        /**
         * Provides a way of adding a path to the include_path.
         *
         * @param string $path A new path to add to the include_path.
         * @return boolean true it it works, false otherwise.
         */
        public function addToIncludePath($path)
        {
            if (is_string($path)) {
                $result = set_include_path(get_include_path() . PATH_SEPARATOR . $path);

                if ($result !== false) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Provides a way of removing a path from the include_path.
         *
         * @param string $path A path to remove from the include_path.
         * @return boolean true it it works, false otherwise.
         */
        public function removeFromIncludePath($path)
        {
            $paths = get_include_path();
            $paths = explode(PATH_SEPARATOR, $paths);

            $key = array_search($path, $paths);
            if ($key !== false) {
                unset($paths[$key]);

                $paths = implode(PATH_SEPARATOR, $paths);
                $result = set_include_path($paths);
                if ($result !== false) {
                    return true;
                }
            }

            return false;
        }

        /**
         * This is the method called by spl_autoload to actually load a lass.
         *
         * @param string $class The name of the class that needs to be included.
         * @return boolean Was the class file loaded sucessfully.
         * @uses prefixes
         */
        public function load($class)
        {
            // make sure we got a string since this is a public method
            if (!is_string($class)) {
                return false;
            }

            foreach ($this->prefixes as $prefix => $pathPrefix) {

                if (stripos($class, $prefix) === 0) {

                    //we found a class to load
                    $file = str_replace(['_', '\\'], DIRECTORY_SEPARATOR, $class) . '.php';
                    $file = $pathPrefix . $file;

                    $resolvedFile = stream_resolve_include_path($file);
                    if ($resolvedFile !== false) {

                        // the file was found so see if it can be read
                        if (is_readable($resolvedFile)) {
                            require $resolvedFile;
                            return true;
                        }
                    }
                }
            }

            return false;
        }
    }
}
