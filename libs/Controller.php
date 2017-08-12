<?php

/**
 * Standardcontroller
 * @author: Marlon Böhland
 * @access: public
 */
class Controller
{
    public $msg = null;

    function __construct()
    {
        $this->view = new View();
        $this->view->binColors = Session::get('binColors');
        $this->model = new Model();

        // Zugriff prüfen
        if (isset($_GET['msg'])) {
            $this->_showMessages($_GET['msg']);
        }
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

    /**
     * Ausgabe von Meldungen
     * @param $msgID
     * @return bool
     */
    private function _showMessages($msgID)
    {
        switch ($msgID) {
            case '401':
                $this->view->showAlert('danger', $option = null, "Ihre Zugangsdaten sind nicht korrekt oder Sie verfögen nicht über die Berechtigung für diesen Bereich.");
                break;
            case 'logout':
                $this->view->showAlert('success', $option = null, "Sie wurden erfoglreich abgemeldet.");
                break;
        }
        return false;
    }
}