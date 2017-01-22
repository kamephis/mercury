<?php

/**
 * Main Controller
 * User: Marlon
 * Date: 11.12.2016
 * Time: 23:40
 */
class Controller
{
    /**
     * Controller constructor.
     */
    // TODO: Übergabe der request Daten an den Controller
    public function __construct()
    {
        $this->view = new View();
        $this->lang = new StpLang('de_DE');
    }

    public function loadModel($name)
    {
        $path = 'application/models' . $name . '_model-php';

        if (file_exists($path)) {
            require 'application/models/' . $name . '_model.php';
            $modelName = $name . '_Model';
            $this->model = new $modelName;
        }
    }
}