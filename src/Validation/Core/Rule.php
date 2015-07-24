<?php
namespace Flair\Validation\Core {

    /**
     * A bare bones rule, that can be used or extended.
     *
     * @author Daniel Sherman
     * @todo finish unit tests
     */
    class Rule implements RuleInterface
    {
        use RuleTrait;

        /**
         * The constructor does what you would expect it to.
         *
         * @author Daniel Sherman
         * @param callable $callable The callable that will be used by isValid().
         * @param string $message The error message.
         * @param bool $halt The value to assign to the halt flag.
         * @param array $arguments The arguments that will be passed to $callable by isValid().
         * @uses setCallable
         * @uses setMessage
         * @uses setHalt
         * @uses setArguments
         * @throws Exception If $message or $halt are an incorrect type.
         */
        public function __construct(callable $callable, $message = '', $halt = false, array $arguments = [])
        {
            $this->setCallable($callable);
            $this->setMessage($message);
            $this->setHalt($halt);
            $this->setArguments($arguments);
        }

    }
}
