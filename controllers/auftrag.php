<?php

class Auftrag extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Auftragsbearbeitung';

        $this->model = new Auftrag_Model();

        $this->view->render('header');
        $this->view->render('navbar_top');
        $this->view->render('auftrag/index');
        $this->view->render('footer');
    }

    /*function run()
    {
        $this->model->run();
    }*/
}