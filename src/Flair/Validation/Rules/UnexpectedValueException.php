<?php
namespace Flair\Validation\Rules {

    /**
     * If a class is part of the Flair\Validation\Rules namespace, and it needs to throw a
     * UnexpectedValueException it should use this class to throw it.
     *
     * @author Daniel Sherman
     */
    class UnexpectedValueException extends \Flair\Validation\UnexpectedValueException implements ExceptionInterface
    {}
}
