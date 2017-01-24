<?php
ob_start();
error_reporting(E_ALL);

// Konfiguration
require 'config.php';
require 'util/Auth.php';

// Klassen Auto-Loader
function __autoload($class)
{
    require LIBS . $class . ".php";
}

$bootstrap = new Bootstrap();

//Pfade (individuell)
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

// Anwendung starten
$bootstrap->init();