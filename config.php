<?php

// Allgemeine Einstellungen
define('URL', 'http://dev.stoffpalette.com/pixiPickprozess/');

// Pfade
define('LIBS', 'libs/');
define('IMG_PATH', 'out/img/');
define('PATH_NUSOAP', '/out/lib/php/nusoap/nusoap.php');

if (file_exists(PATH_NUSOAP)) {
    echo "nusoap eingebunden";
} else {
    echo "nusoap nicht gefunden.<br>";
    echo PATH_NUSOAP;
}

// Datenbank Zugriff
define('DB_TYPE', 'mysql');
define('DB_HOST', '192.168.200.2');
define('DB_NAME', 'usrdb_stokcgbl5');
define('DB_USER', 'stokcgbl5');
define('DB_PASS', '3307');

// Pixi Einstellungen
define('PIXI_WSDL_PATH', 'https://api.pixi.eu/soap/pixiSTF/?wsdl');
define('PIXI_USERNAME', 'pixiSTF');
define('PIXI_PASSWORD', 'eSxKQqxxh2L3kW_STF');