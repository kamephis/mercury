<?php

/**
 * User: Marlon
 * Date: 10.12.2016
 * Time: 12:28
 *
 * Laden aller erforderlichen Klassen und Komponenten
 * Initialisieren der Anwendung
 */
class Bootstrap
{

    /**
     * bootstrap constructor.
     */
    public function __construct()
    {
        $this->initComponents();
    }

    public function initComponents()
    {
        // NuSoap Bibliothek einbinden
        require_once('out/lib/php/nusoap/nusoap.php');

        // Pfade
        define('IMG_PATH', 'out/img/');
        define('APPLICATION_PATH', 'application/');
        define('MODEL_PATH', APPLICATION_PATH . 'models/');
        define('VIEW_PATH', APPLICATION_PATH . 'views/');
        define('CONTROLLER_PATH', APPLICATION_PATH . 'controllers/');
        define('LANG_PATH', APPLICATION_PATH . 'lang/');

        // URL auslesen
        $url = isset($_REQUEST['p']) ? $_REQUEST['p'] : null;
        $url = rtrim($_REQUEST['p'], '/');
        $url = explode('/', $_REQUEST['p']);

        // Wenn der controller nicht existiert, wird zur Login-Seite weitergeleitet
        // Alternativ wird eine Fehlermeldung ausgegeben TODO:
        if (empty($url[0])) {
            require_once(CONTROLLER_PATH . 'login.php');

            // Login Controller erzeugen
            $controller = new Login();
            return false;
        }

        // Controller einbinden
        $file = CONTROLLER_PATH . $url[0] . '.php';
        if (file_exists($file)) {
            require($file);
        } else {
            // TODO: Fancyfy ;)
            //throw new Exception("Die Datei ".$file." existiert nicht.");
            require_once(CONTROLLER_PATH . 'error.php');
            // initiate the error controller
            $error = new Error();
            return false;
        }

        // Controller erzeugen
        $controller = new $url[0];
        // Model einbinden
        $controller->loadModel($url[0]);

        // Methode des Controllers aufrufen und Parameter übergeben (optional)
        if (isset($url[2])) {
            $controller->{$url[1]}($url[2]);
        } else {
            // Methode des Controllers aufrufen
            if (isset($url[1])) {
                $controller->{$url[1]}();
            }
        }
        return false;
    }
}