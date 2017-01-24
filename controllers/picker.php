<?php

class Picker extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Picken';
        //$this->run();

        $this->view->render('header');
        $this->view->render('mercury/topNav');
        $this->view->render('mercury/picker');
        $this->view->render('footer');

        require_once('models/picker_model.php');
        $this->model = new Picker_Model();
        $this->view->getMasterPicklist = $this->model->getMasterPicklist();
    }

    /*function run() {
        $this->Model->run();
    }*/
}