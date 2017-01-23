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
    }

    public function index()
    {
        //$this->view->render('login/index');
    }

    public function run()
    {
        $this->loadModel('login');
    }
}