<?php

/**
 * Mercury Cronjobs
 * User: Marlon
 * Date: 27.03.2017
 * Time: 09:34
 */
class MercuryCronjob
{

    private $oMySqli = null;

    /**
     * MercuryCronjob constructor.
     * @param null $oMySqli
     */
    public function __construct()
    {
        // Datenbank Zugriff (Intern DB)
        define('DB_TYPE', 'mysql');
        define('DB_HOST', '192.168.200.2');
        define('DB_NAME', 'usrdb_stokcgbl5');
        define('DB_USER', 'stokcgbl5');
        define('DB_PASSWD', 'X$9?2IMalDUU');
        define('DB_PORT', '3307');

        $this->oMySqli = new mysqli();
    }

    /**
     * Dieser Cronjob leer jeden Morgen vor Schichtbeginn die alten Aufträge aus der
     * Datenbank
     */
    public function resetPixiAuftraege()
    {
        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
        $this->oMySqli->set_charset('utf8');

        $sqlResetPixiAuftraege = "TRUNCATE TABLE `stpArtikel2Pickliste`; TRUNCATE TABLE `stpPickliste`; TRUNCATE TABLE `stpPicklistItems`;TRUNCATE TABLE `stpArtikel2Auftrag`;";
        $this->oMySqli->multi_query($sqlResetPixiAuftraege) or die("Alte Aufträge konnten nicht gelöscht werden. Bitte informieren Sie die Technik.");
    }
}

$merc = new MercuryCronjob();

if (isset($_REQUEST['job'])) {
    switch ($_REQUEST['job']) {
        case 'resetPixiAuftraege':
            $merc->resetPixiAuftraege();
            breaK;
    }
} else {
    echo "Es wurde kein Cronjob ausgewählt.";
}
