<?php
// Konfiguration
require 'config.php';
require 'util/Auth.php';

// Lander der benötigten Klassen
function __autoload($class)
{
    require LIBS . $class . ".php";
}

$bootstrap = new Bootstrap();

//Pfade
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();
$bootstrap->init();