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

        if (isset($_POST['artNr'])) {
            $this->view->render('navbar_top');
            $this->view->render('auftrag/index');
        } else {
            $this->view->render('auftrag/scanArt');
        }
        $this->view->render('footer');
    }

    /*function run()
    {
        $this->model->run();
    }*/
}