<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 22:16
 * Help Controller
 */
class Help extends Controller
{
    /**
     * help constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        require('application/models/help_model.php');
        $model = new HelpModel();

        $this->view->render('help/index');

    }
}