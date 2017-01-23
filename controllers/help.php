<?php

class Help extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Mercury : Hilfe';
        $this->view->render('help/index');
    }
}