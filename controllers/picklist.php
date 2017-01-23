<?php

class Picklist extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Picken';

        $this->view->render('header');
        $this->view->render('mercury/topNav');
        $this->view->render('mercury/picklist');
        $this->view->render('footer');
    }

    function run()
    {
        $this->model->run();
    }
}