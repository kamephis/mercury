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

        $this->view->render('mercury/topNav');
        $this->view->render('mercury/picker');
    }

    function run()
    {
        $this->model->run();
    }
}