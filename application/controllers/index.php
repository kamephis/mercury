<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 22:16
 */
class Index extends Controller
{
    /**
     * index.php constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('index/header');
        $this->view->render('index/home');
        $this->view->render('index/footer');
    }
}