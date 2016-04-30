<?php
namespace Flair\Validation {
    /**
     * The Default replace implementation. The replacer can be thought of as an
     * advanced substr_replace.
     *
     * @author Daniel Sherman
     */
    class Replacer implements ReplacerInterface
    {

        /**
         * Add the needed methods.
         */
        use ReplacerTrait;

        /**
         * The constructor does what you would expect it to.
         *
         * @param array $replacements The replacement key/value pairs.
         * @param string $prefix The prefix to put before a key when doing a replacement.
         * @param string $suffix The suffix to put after a key when doing a replacement.
         * @uses addReplacements
         * @uses setPrefix
         * @uses setSuffix
         * @throws InvalidArgumentException If a $replacements key isn't a string.
         * @throws LogicException If a $replacements value isn't a scalars, or object
         * with a __toString() Method.
         * @throws InvalidArgumentException If $prefix isn't a string.
         * @throws InvalidArgumentException If $suffix isn't a string.
         */
        public function __construct($replacements = [], $prefix = '_', $suffix = '_')
        {
            $this->addReplacements($replacements);
            $this->setPrefix($prefix);
            $this->setSuffix($suffix);
        }
    }
}
