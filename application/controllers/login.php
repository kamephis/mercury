<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 22:16
 */
class Login extends Controller
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('login/index');
    }

    public function test($arg = false)
    {
        echo $arg . " Methode Test in Login aufgerufen";
    }
}