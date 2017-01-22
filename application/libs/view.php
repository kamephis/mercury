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
        if (isset($_SESSION['userName'])) {
            if ($noInclude == true) {
                // include ohne header / footer
                require('application/views/' . $view . '.php');
            } else {
                // header und footer einbinden
                require_once('header.php');
                require('application/views/' . $view . '.php');
                require_once('footer.php');
            }
        } else {
            echo 'Zugriff verweigert!';
        }
    }
}