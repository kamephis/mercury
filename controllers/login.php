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
        Session::init();
    }

    function index()
    {
        $this->view->title = 'Mercury Login';
        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
        $this->view->message = "";

        if (!Session::checkAuth()) {
            //Error::getError('401');
            if (isset($_GET['msg'])) {
                switch ($_GET['msg']) {
                    case '401':
                        $this->view->showAlert('danger', $option = null, "Ihre Zugangsdaten sind nicht korrekt.");
                        break;
                    case 'logout':
                        $this->view->showAlert('success', $option = null, "Sie wurden erfoglreich abgemeldet.");
                        break;
                }
            }
        }
    }

    function run()
    {
        // Login
        $this->model->run();
    }
}