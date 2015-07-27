<?php
namespace Flair\Validation\Core {

    /**
     * If a class is part of the Flair\Validation\Core namespace, and it needs to throw a
     * LogicException it should use this class to throw it.
     *
     * @author Daniel Sherman
     */
    class LogicException extends \Flair\Exception\LogicException
    {}
}
