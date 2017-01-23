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
        $this->view->render('header');
        $this->view->render('auftrag/index');
        $this->view->render('footer');
    }

    function run()
    {
        $this->model->run();
    }
}