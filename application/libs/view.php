<?php

/**
 * Main View
 * User: Marlon
 * Date: 11.12.2016
 * Time: 23:48
 */
class View
{
    /**
     * View constructor.
     */
    public function __construct()
    {
    }

    public function render($view, $noInclude = false)
    {
        $path = 'application/views/' . $view . '.php';

        if (isset($_SESSION['userName'])) {
            if ($noInclude == true) {
                // include ohne header / footer
                require($path);
            } else {
                // header und footer einbinden
                require_once('header.php');
                require($path);
                if (file_exists($path)) {
                    echo "datei gefunden";
                }
                require_once('footer.php');
            }
        } else {
            require_once('header.php');
            require('application/views/login/index.php');
            require_once('footer.php');
        }
    }
}