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
        $this->model = new Picker_Model();
        $this->view->masterPicklist = $this->model->getMasterPicklist();
        //$this->run();

        $this->view->render('header');
        $this->view->render('mercury/topNav');
        $this->view->render('mercury/picker');
        $this->view->render('footer');

    }

    /*function run() {
        $this->Model->run();
    }*/
}