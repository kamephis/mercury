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
    function __construct()
    {
        $this->view = new View();
    }

    /**
     *
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name, $modelPath = 'models/')
    {

        $path = 'application/models' . $name . '_model-php';

        if (file_exists($path)) {
            require 'application/models/' . $name . '_model.php';

            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }
    }
}