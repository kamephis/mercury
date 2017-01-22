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
        $this->view->render('mercury/index');
    }

    public function showPicklist()
    {
        $this->view->render('');
        $this->view->render('mercury/picklist');
    }
}