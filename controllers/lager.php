<?php

/**
 * Lager Controller
 *
 * @author: Marlon Böhland
 * @date:   22.09.2017
 * @access: public
 */
class lager extends Controller
{
    function __construct()
    {
        parent::__construct();
        Session::init();
    }

    function index()
    {
        if (Session::checkAuth()) {
            require_once('models/navigation_model.php');
            $this->view->nav = new Navigation_Model();

            require_once('libs/Pixi.php');
            $this->view->Pixi = new Pixi();

            //require_once('models/backend_model.php');
            //$this->view->back = new Backend_Model();

            $this->view->title = 'Mercury Lager';
            $this->view->render('header');
            $this->view->render('navigation');
            $this->view->render('lager/stock');
            $this->view->render('footer');
        }
    }

    function run()
    {
        $this->model->run();
    }
}