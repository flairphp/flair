<?php
class TestCallable
{
    /**
     * a method that always returns true
     */
    public function alwaysTrue()
    {
        return true;
    }

    /**
     * a static method that always returns true
     */
    public static function staticAlwaysTrue()
    {
        return true;
    }

    /**
     * a method that always returns the second parameter it was given
     */
    public function returnsGivenType($one, $two)
    {
        return $two;
    }

}
