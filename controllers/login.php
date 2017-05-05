<?php

/**
 * Login Controller
 * @author: Marlon Böhland
 * @date:   01.12.2016
 * @access: public
 */
class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Mercury Login';
        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
        $this->view->message = "";

        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case 'e401':
                    $this->view->message = "Zugangsdaten falsch";
                    break;
            }
        }
    }

    function run()
    {
        $this->model->run();
    }
}