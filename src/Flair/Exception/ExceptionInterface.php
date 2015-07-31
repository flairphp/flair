<?php
namespace Flair\Exception {

    /**
     * The blueprint to build basic Exception against, and hint with for all Flair generated
     * Exceptions.
     *
     * @author Daniel Sherman
     */
    interface ExceptionInterface
    {

        /**
         * Returns a unique id that makes every exception uniquely identifiable.
         *
         * @author Daniel Sherman
         * @return string
         */
        public function getId();

        /**
         * Returns the context array that was passed in during object instantiation.
         *
         * @author Daniel Sherman
         * @return array
         */
        public function getContext();

        /**
         * Returns the context array that was passed in during object instantiation as a string.
         *
         * @author Daniel Sherman
         * @return string
         */
        public function getContextAsString();

    }
}
