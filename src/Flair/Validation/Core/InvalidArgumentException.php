<?php
namespace Flair\Validation\Core {

    /**
     * If a class is part of the Flair\Validation namespace, and it needs to throw a
     * InvalidArgumentExceptionthen it should use this class to throw it.
     *
     * @author Daniel Sherman
     */
    class InvalidArgumentException extends \Flair\Exception\InvalidArgumentException implements ExceptionInterface
    {}
}
