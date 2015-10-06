<?php
namespace Flair\Validation {

    /**
     * The blueprint to build rules against that handle setting/getting replacer 
     * objects.
     *
     * @author Daniel Sherman
     */
    interface RuleReplacerInterface
    {

        public function setReplacer($replacer);

        public function getReplacer();

        public function hasReplacer();
    }
}
