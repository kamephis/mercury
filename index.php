<?php

$app_url = explode('.', $_SERVER['HTTP_HOST']);
$app = $app_url[0];

// Individuelles setzen der Session-Timeouts

/*
switch ($app) {
    case 'pick':
        break;
    case 'zuschnitt':
        break;
    case 'mercury':
        session_cache_limiter('public');
        $cache_limiter = session_cache_limiter();

        session_cache_expire(86400); // 24h
        $cache_expire = session_cache_expire();
        break;
}*/
if (count($_SESSION)) {
    echo "Ihre Sitzung wurde beendet. Bitte melden Sie sich erneut an.";
    session_destroy();
} else {
    ob_start();
    session_start();
}


//echo "Die Cacheverwaltung ist jetzt auf $cache_limiter gesetzt<br />";
//echo "Die Session wird für $cache_expire Minuten im Cache gespeichert";
//error_reporting();

// Konfiguration
require 'config.php';


// Klassen Auto-Loader
function __autoload($class)
{
    require 'libs/' . $class . ".php";
}
$bootstrap = new Bootstrap();

//Pfade (individuell)
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

// Anwendung starten
$bootstrap->init();