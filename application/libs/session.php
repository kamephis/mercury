<?php

/**
 * User: Marlon
 * Date: 22.01.2017
 * Time: 23:39
 */
class Session
{
    public static function init()
    {
        @session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function destroy()
    {
        //unset($_SESSION);
        session_destroy();
    }
}