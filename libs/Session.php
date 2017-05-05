<?php

/**
 * Vereinfachung des Session handlings.
 *
 * @author: Marlon Böhland
 * @access: public
 */
class Session
{
    // Initialisieren der Session
    public static function init()
    {
        //    ob_start();
        //    session_start();
        //    echo "Session Timeout: ".session_cache_expire();
    }

    // Setzen von Session Variablen
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Auslesen von Session Variablen
    public static function get($key)
    {
        if (isset($_SESSION[$key])) return $_SESSION[$key];
    }

    // Session zerstören
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    // Überprüfen ob ein User eingeloggt ist
    public static function checkAuth()
    {
        $sUID = self::get('UID');
        if (!isset($sUID)) {
            self::destroy();
            // Weiterleitung auf die Login-Seite
            header('location: ' . URL . 'login');
        } else {
            return true;
        }
        return false;
    }
}