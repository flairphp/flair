<?php
namespace Flair\Validation\Core {

    /**
     * A bare bones rule, that can be used or extended, that leverages the power of callables.
     *
     * @author Daniel Sherman
     */
    class CallableRule implements RuleInterface
    {
        /**
         * Add the needed methods.
         */
        use CallableRuleTrait;

        /**
         * The constructor does what you would expect it to.
         *
         * @author Daniel Sherman
         * @param callable $callable The callable that will be used by isValid().
         * @param array $arguments The arguments that will be passed to $callable by isValid().
         * @param string $message The error message.
         * @param bool $halt The value to assign to the halt flag.
         * @uses setCallable
         * @uses setArguments
         * @uses setMessage
         * @uses setHalt
         * @throws InvalidArgumentException If $message isn't a string or $halt isn't a bool.
         */
        public function __construct(callable $callable, array $arguments = [], $message = '', $halt = false)
        {
            $this->setCallable($callable);
            $this->setArguments($arguments);
            $this->setMessage($message);
            $this->setHalt($halt);
        }
    }
}
