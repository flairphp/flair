<?php
namespace Flair\Validation\Core {

    /**
     * The the blueprint to build alterable & callable rules against, and well as hint for them with.
     *
     * @author Daniel Sherman
     */
    interface AlterableCallableRuleInterface extends RuleInterface
    {

        /**
         * Gets the callable method/function that will be used by isValid() to validate the value
         * passed to it.
         *
         * @return null|callable Returns the callable method/function if it's set, null otherwise.
         */
        public function getCallable();

        /**
         * Sets the callable method/function that will be used by isValid() to validate the value
         * passed to it. The method/function should always return a bool value.
         *
         * @param callable $callable The callable that will be used by isValid.
         */
        public function setCallable(callable $callable);

        /**
         * Gets the optional arguments that will be passed along to the callable method/function
         * that will be used by isValid() to validate the value passed to it.
         *
         * @return array The arguments that will be used.
         */
        public function getArguments();

        /**
         * Sets the optional arguments that isValid() will pass to the callable method/function
         * it uses for validating its input.
         *
         * @param array $arguments The arguments to be used.
         */
        public function setArguments(array $arguments);
    }
}
