<?php

class Index extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Mercury';
        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
    }
}