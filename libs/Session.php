<?php
class Session
{
    // Initialisieren der Session
    public static function init()
    {
        @session_start();
    }

    // Setzen von Session Variablen
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Auslesen von Session Variablen
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    // Session zerstören
    public static function destroy()
    {
        session_destroy();
    }
}