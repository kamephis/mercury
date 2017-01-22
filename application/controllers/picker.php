<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 22:16
 * Picker Controller
 */
class Picker extends Controller
{
    /**
     * zuschnitt constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('mercury/topNav');
        $this->view->render('mercury/home');

    }
}