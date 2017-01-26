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

        $this->view->auftrag = new Auftrag_Model();
        $this->view->Pixi = new Pixi();
        $this->view->render('header');
        $this->view->render('navbar_top');
        if (isset($_SESSION['username'])) {
            $this->view->render('auftrag/index');
        } else {
            echo "user nicht gesetzt";
        }
        $this->view->render('footer');
    }

    /*function run()
    {
        $this->model->run();
    }*/
}