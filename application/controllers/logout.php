<?php

/**
 * Logout Controller
 * User: Marlon
 * Date: 12.12.2016
 * Time: 00:12
 */
class Logout extends Controller
{
    /**
     * Logout constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('logout/index');
    }
}