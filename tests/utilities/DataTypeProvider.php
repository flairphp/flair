<?php
namespace Flair\PhpUnit {

    class DataTypeProvider
    {
        /**
         * An array of data types that can be used in a test when type
         * hinting can be used
         *
         * @var array
         */
        protected $types = [];

        /**
         * Does what you think.
         */
        public function __construct()
        {
            $this->types = [
                'boolean' => true,
                'integer' => 1,
                'float' => 1.15,
                'string' => 'A string',
                'array' => [],
                'object' => new \stdClass(),
                'resource' => fopen(__FILE__, "r"),
                'null' => null,
                'callable' => function () {return true;},
            ];
        }

        /**
         * Returns an array of data types  excluding those passed in
         *
         * @param array $exclude The data types to be excluded from returned array
         * @uses types
         * @return array
         */
        public function excludeTypes(array $exclude = [])
        {
            $result = $this->types;

            foreach ($exclude as $key) {
                unset($result[$key]);
            }

            return $result;
        }

        /**
         * Returns an array of data types
         *
         * @param array $include The data types to be included in the result
         * @uses types
         * @return array
         */
        public function includeTypes(array $include = [])
        {
            $result = [];

            foreach ($include as $key) {
                if (isset($this->types[$key])) {
                    $result[$key] = $this->types[$key];
                }
            }

            return $result;
        }

        /**
         * turns an array into an array of arrays as follows.
         * ['key1' => 1, 'key2' => 2] would become [['key1',1],['key12',2]]
         *
         * This makes it easer to export return data from a data provider.
         *
         * @param array $in T
         * @return array
         */
        public function arrayOfArrays(array $in = [])
        {
            $out = [];
            foreach ($in as $key => $value) {
                $out[] = [$key, $value];
            }
            return $out;
        }

    }
}
