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
        $this->view->render('mercury/header');
        $this->view->render('mercury/home');
        $this->view->render('mercury/footer');
    }
}