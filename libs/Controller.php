<?php

/**
 * Standardcontroller
 * @author: Marlon Böhland
 * @access: public
 */
class Controller
{
    function __construct()
    {
        $this->view = new View();
        $this->view->binColors = Session::get('binColors');
        $this->model = new Model();
    }

    /**
     * @param $name
     * @param string $modelPath
     */
    public function loadModel($name, $modelPath)
    {
        $path = $modelPath . $name . '_model.php';

        if (file_exists($path)) {
            require $path;

            $modelName = ucfirst($name) . '_Model';
            $this->model = new $modelName();
        }
    }
}