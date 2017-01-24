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

        $this->model = new Picklist_Model();
        $this->view->PicklistItems = $this->model->getPicklistItems(null);

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