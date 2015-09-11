<?php
namespace Flair\Validation\Core {

    /**
     * Provides all the functionality needed to implement a {@link AlterableCallableRule} and meet the
     * requirements of the {@link AlterableCallableRuleInterface} Interface. The only thing a developer
     * needs  to do to create a rule, is create a constructor that sets the internal attributes.
     *
     * @author Daniel Sherman
     */
    trait AlterableCallableRuleTrait
    {

        /**
         * Add the needed methods to meet the requirements of the RuleInterface interface, and to
         * be a CallableRule Rule.
         */
        use CallableRuleTrait {
            getCallable as public;
            setCallable as public; 
            getArguments as public;
            setArguments as public;
        }
    }
}
