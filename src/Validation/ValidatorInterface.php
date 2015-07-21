<?php
namespace Flair\Validation {

    /**
     * say something
     *
     * @author Daniel Sherman
     */
    interface ValidatorInterface
    {
        public function setRunAll();

        public function isValid();

        public function setRule();

        public function deleteRule();

        public function hasRule();

        public function getRule();

        public function getRuleKeys();

        public function setReplacement();

        public function deleteReplacement();

        public function hasReplacement();

        public function getReplacement();

        public function getReplacementKeys();

        public function getMessages();

        public function getMessage();

        public function setMessage();

        public function doReplacements();
    }
}
