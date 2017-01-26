<?php

class Hilfe extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Mercury Hilfe';
        $this->view->render('header');
        $this->view->render('navbar_top');
        $this->view->render('help/index');
        $this->view->render('footer');
    }

    /*function run() {
        $this->Model->run();
    }*/
}