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
    public function loadModel($name, $modelPath = 'application/models/')
    {
        $path = $modelPath . $name . '_model.php';

        if (file_exists($path)) {
            require $path;

            $modelName = $name . '_model';
            $this->model = new $modelName();
        }
    }
}