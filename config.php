<?php
// Allgemeine Einstellungen

// Pfade
define('LIBS', 'libs/');
define('IMG_PATH', 'out/img/');
define('IMG_ART_PATH', 'http://www.stoff4you.de/out/pictures/generated/product/1/250_200_75/');
define('PATH_NUSOAP', 'libs/nusoap.php');
define('MERCURY_VERSION', 'v1.0.7.5');

// Auslesen der Subdomain (Parameter für Weiterleitung)
$hostUrl = explode('.', $_SERVER['HTTP_HOST']);

$subdomain = $hostUrl[0];
define('SUBDOMAIN', $subdomain);

define('URL', 'http://' . $subdomain . '.stoffpalette.com/');
switch (URL) {
    case 'pick':
        $_SESSION['redirectUrl'] = 'scanLocation';
        break;
    case 'mercury':
        $_SESSION['redirectUrl'] = 'backend';
        break;
    case 'zuschnitt':
        $_SESSION['redirectUrl'] = 'scanArt';
        break;
}

// Datenbank Zugriff

// Intern
define('DB_TYPE', 'mysql');
define('DB_HOST', '192.168.200.2');
define('DB_NAME', 'usrdb_stokcgbl5');
define('DB_USER', 'stokcgbl5');
define('DB_PASSWD', 'X$9?2IMalDUU');
define('DB_PORT', '3307');

// OXID
define('DB_HOST_OXID', '192.168.200.2');
define('DB_NAME_OXID', 'usrdb_stokcgbl1');
define('DB_USER_OXID', 'stokcgbl1');
define('DB_PASSWD_OXID', 'q17qy5uu');
define('DB_PORT_OXID', '3307');


// Pixi Einstellungen
define('PIXI_WSDL_PATH', 'https://api.pixi.eu/soap/pixiSTF/?wsdl');
define('PIXI_USERNAME', 'pixiSTF');
define('PIXI_PASSWORD', 'eSxKQqxxh2L3kW_STF');
require_once(PATH_NUSOAP);

// Application Type registrieren
Session::set('appType', $subdomain);

/**
 * Rechteverwaltung
 *
 * Zuweisung der Navigationseinträge
 * zu ihren Binärwerten.
 */
$aNavItems = array(
    'start' => '1',
    'logout' => '2',
    'hilfe' => '4',
    'picklisten' => '8',
    'auftrag' => '16',
    'artikelinfo' => '32',
    'picklistenbearbeitung' => '64'
);
//Session::set('sNavItems',$aNavItems);

/**
 * Zuweisung der Benutzerrechte
 * Die Addition der jeweiligen Werte aus
 * $aNavItems ergibt die Berechtigungsstufe
 *
 * nicht in Verwendung (nur zur Übersicht)
 * Rechte sind in der DB gespeichert.
 */
$aRoles = array(
    'user' => '3',
    'picker' => '15',
    'zuschnitt' => '23',
    'tl' => '127',
    'gf' => '127',
    'admin' => '127'
);
//Session::set('sRoles',$aRoles);

/**
 * Pick by Color
 * In diesem Array werden die Farbwerte für Pick-By-Color hinterlegt.
 * Die letzten Beiden Stellen des Lagerplatzes bestimmt die Farbe
 * welche in der Pick-Anzeige als Hintergrund des Lagerplatzes angezeigt
 * wird.
 *
 * Ist einem Lagerplatz noch keine Farbe zugewiesen, wird der Hintergrund
 * schwarz gefärbt.
 *
 * Wird das Array um neue Farben ergänzt, wird die Anzeige automatisch
 * beim nächsten Aufruf dieses Lagerplatzes in der neuen Farbe dargestellt.
 */
$binColor = array(
    'COLOR_01' => '#781c81', // rgb(120,28,129),    CMYK (65,100,12,2)
    'COLOR_02' => '#3f4ea1', // rgb(63,78,161),     CMYK (87,80,0,0)
    'COLOR_03' => '#4683c1', // rgb(70,131,193),    CMYK (74,42,1,0)
    'COLOR_04' => '#57a3ad', // rgb(109,179,136),   CMYK (60,10,59,0)
    'COLOR_05' => '#b1be4e', // rgb(177,190,78),    CMYK (35,12,87,0)
    'COLOR_06' => '#dfa53a', // rgb(223,165,58),    CMYK (13,36,91,0)
    'COLOR_07' => '#e7742f', // rgb(231,116,47),    CMYK (5,67,93,0)
    'COLOR_08' => '#d92120', // rgb(217,33,32),     CMYK (9,98,100,1)
    'COLOR_09' => '#777777', // rgb(119,119,119),   CMYK (55,46,46,11)
);
Session::set('binColors', $binColor);