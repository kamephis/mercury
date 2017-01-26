<?php

class Login extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Login';
        $this->view->render('header');

        /*if (isset($_POST['user'])) {
            $this->view->render('login/password');
        }*/
        if (isset($_POST['password'])) {
            //$this->view->render('login/index');
            $this->view->render('auftrag/scanArt');
            $this->run();
        }
        $this->view->render('login/index');
        $this->view->render('footer');
    }

    function run()
    {
        $this->model->run();
    }
}