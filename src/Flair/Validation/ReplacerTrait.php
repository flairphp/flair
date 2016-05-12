<?php
namespace Flair\Validation {

    /**
     * Provides The functionality needed to implement a Replacer.
     *
     * @author Daniel Sherman
     */
    trait ReplacerTrait
    {
        /**
         * The prefix to put before a key when doing a replacement.
         *
         * @var string
         */
        protected $prefix = '';

        /**
         * The suffix to put after a key when doing a replacement.
         *
         * @var string
         */
        protected $suffix = '';

        /**
         * The replacement key/value pairs.
         *
         * @var array
         */
        protected $replacements = array();

        /**
         * Sets the value of the prefix used when doing replacements.
         *
         * @param string $prefix The value to assign to the prefix.
         * @uses prefix
         * @throws InvalidArgumentException If $prefix isn't a string.
         */
        public function setPrefix($prefix)
        {
            if (is_string($prefix)) {
                $this->prefix = $prefix;
                return;
            }

            throw new InvalidArgumentException('$prefix is not a string!', 2);
        }

        /**
         * Returns the value of the prefix used when doing replacements.
         *
         * @uses prefix
         * @return string the prefix
         */
        public function getPrefix()
        {
            return $this->prefix;
        }

        /**
         * Sets the value of the suffix used when doing replacements.
         *
         * @param string $suffix The value to assign to the suffix.
         * @uses suffix
         * @throws InvalidArgumentException If $suffix isn't a string.
         */
        public function setSuffix($suffix)
        {
            if (is_string($suffix)) {
                $this->suffix = $suffix;
                return;
            }

            throw new InvalidArgumentException('$suffix is not a string!', 3);
        }

        /**
         * Returns the value of the suffix used when doing replacements.
         *
         * @uses suffix
         * @return string the suffix
         */
        public function getSuffix()
        {
            return $this->suffix;
        }

        /**
         * Returns all the keys currently registered.
         *
         * @return array the replacement keys
         * @uses replacements
         */
        public function getKeys()
        {
            return array_keys($this->replacements);
        }

        /**
         * Checks to see if a replacement key exists.
         *
         * @param string $key The replacement key to look for.
         * @uses replacements
         * @return boolean
         */
        public function hasReplacement($key)
        {
            return array_key_exists($key, $this->replacements);
        }

        /**
         * Get the replacement value for a given key.
         *
         * @param string $key The replacement key to look for.
         * @uses replacements
         * @throws OutOfBoundsException If $key doesn't exist.
         * @return mixed The value associated with the key
         */
        public function getReplacement($key)
        {
            if (array_key_exists($key, $this->replacements)) {
                return $this->replacements[$key];
            }

            throw new OutOfBoundsException('$key does not exist!', 4);
        }

        /**
         * adds a new replacement key & value.
         *
         * @param string $key The replacement key .
         * @param string $key The replacement value.
         * @uses replacements
         * @throws InvalidArgumentException If $key isn't a string.
         * @throws LogicException If key already exists.
         * @throws LogicException If $value isn't a scalars, or object
         * with a __toString() Method.
         */
        public function addReplacement($key, $value)
        {
            if (!is_string($key)) {
                throw new InvalidArgumentException('$key is not a string!', 5);
            }

            if (array_key_exists($key, $this->replacements)) {
                throw new LogicException('$key already exists!', 6);
            }

            if (!is_scalar($value) && !method_exists($value, '__toString')) {
                throw new LogicException('$value is not a valid type!', 7);
            }

            $this->replacements[$key] = $value;
        }

        /**
         * updates an existing replacement key & value.
         *
         * @param string $key The replacement key .
         * @param string $key The replacement value.
         * @throws InvalidArgumentException If $key isn't a string.
         * @throws LogicException If $value isn't a scalars, or object
         * with a __toString() Method.
         */
        public function updateReplacement($key, $value)
        {
            if (!is_string($key)) {
                throw new InvalidArgumentException('$key is not a string!', 9);
            }

            if (!is_scalar($value) && !method_exists($value, '__toString')) {
                throw new LogicException('$value is not a valid type!', 10);
            }

            $this->replacements[$key] = $value;
        }

        /**
         * adds multiple replacement key & value pairs.
         *
         * @param array $replacements The replacement to add.
         * @uses addReplacement
         * @throws InvalidArgumentException If an array key isn't a string.
         * @throws LogicException If a key already exists.
         * @throws LogicException If a value isn't a scalars, or object
         * with a __toString() Method.
         */
        public function addReplacements(array $replacements)
        {
            foreach ($replacements as $key => $value) {
                $this->addReplacement($key, $value);
            }
        }

        /**
         * Deletes a replacement if the key exists.
         *
         * @param string $key The replacement key to look for.
         * @uses replacements
         */
        public function deleteReplacement($key)
        {
            unset($this->replacements[$key]);
        }

        /**
         * Does the replacements on the input string.
         *
         * @param string $message The string to perform replacements on.
         * @uses replacements
         * @uses prefix
         * @uses suffix
         * @throws InvalidArgumentException If $message isn't a string.
         * @return string $message with the replacements performed on it
         */
        public function doReplacements($message)
        {
            if (!is_string($message)) {
                throw new InvalidArgumentException('$message is not a string!', 8);
            }

            $rtn = $message;

            foreach ($this->replacements as $key => $val) {
                if (is_scalar($val)) {
                    $replace = $val;
                } else {
                    $replace = $val->__toString();
                }

                $search = $this->prefix . $key . $this->suffix;

                $rtn = str_replace($search, $replace, $rtn);
            }

            return $rtn;
        }
    }
}
