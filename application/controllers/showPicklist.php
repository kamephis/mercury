<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 22:16
 * ShowPicklist Controller
 */
class ShowPicklist extends Controller
{
    /**
     * zuschnitt constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('mercury/picklist');
    }
}