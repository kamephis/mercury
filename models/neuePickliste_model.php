<?php

/**
 * Funktionen für dem Import der Pixi Picklisten
 * Erstellen neuer (interner) Picklisten (Digitale Pickliste)
 *
 * @author: Marlon Böhland
 * @date: 29.12.2016
 */
class NeuePickliste_Model extends Model
{
    private $oProxy = null;
    private $oMySqli = null;

    /**
     * StpPixiPicklistImport constructor.
     * Erzeugen der Pixi und MySQL Verbindungen
     */
    public function __construct()
    {
        parent::__construct();

        // Pixi API-Verbindung herstellen
        //$oSoapClient = new nusoap_client(PIXI_WSDL_PATH, true);
        //$oSoapClient->setCredentials(PIXI_USERNAME, PIXI_PASSWORD);

        // pixi* API Objekt erzeugen
        //$this->setOProxy($oSoapClient->getProxy());

        // MySQL Objekt erzeugen
        $this->oMySqli = new mysqli();
    }

    /**
     * Verfügbare Picklistennummer ermitteln
     * PDO-Version
     * @return mixed
     */
    public function getNewPicklistNr()
    {
        try {
            $sql = $this->db->prepare("SELECT MAX(PLHkey) as PLN FROM stpPickliste");
            $sql->execute();

            $result = $sql->fetch(PDO::FETCH_ASSOC);
            $sql->closeCursor();

            return $result['PLN'] + 1;
        } catch (PDOException $e) {
            die("Es konnte keine Picklistennummer erzeugt werden" . "<br>Fehler: " . $e->errorInfo);
        }
    }

    /** Informationen über den Picker abfragen (vollständiger Name)
     * @param $pickerID
     * @return string
     *
     * PDO-Version
     */
    private function getPickerInfo($pickerID)
    {
        try {
            $sql = $this->db->prepare("SELECT vorname, name FROM iUser WHERE UID = :pickerID");
            $sql->execute(array('pickerID' => $pickerID));
            $result = $sql->fetch(PDO::FETCH_ASSOC);

            $sql->closeCursor();

            return $result['vorname'] . ' ' . $result['name'];
        } catch (PDOException $e) {
            die("Fehler beim abrufen der Picker Informationen.<br>" . $e->errorInfo . "<br>" . $e->getMessage());
        }
    }

    /**
     * Erstellen einer neuen Pickliste und
     * zuweisen von Artikeln zu einer Pickliste
     */
    public function newPicklist()
    {
        $aPostData = $_POST;
        $updateFlag = $aPostData['updatePicklist'];
        $PLHkey = $aPostData['plnr'];
        $createDate = date('y.m.d');
        $expDate = $aPostData['expDate'];
        $createdBy = $aPostData['creator'];
        $plComment = $aPostData['plKommentar'];
        $picker = $aPostData['picker'];
        $aPicklistItems = $_POST['newPicklist'];

        // Initialisierung - Aufbau der Multiquery
        $sqlInsertItems = null;

        $sqlNewPicklist = '';

        if ($updateFlag != 'update') {
            // Neue Pickliste erstellen
            $sqlNewPicklist .= "INSERT INTO
                                  stpPickliste(
                                   PLHkey,
                                   createDate,
                                   PLHexpiryDate,
                                   CreatedBy,
                                   plComment,
                                   picker
                                  ) VALUES (
                                   '" . $PLHkey . "',
                                   '" . $createDate . "',
                                   '" . $expDate . "',
                                   '" . $createdBy . "',
                                   '" . $plComment . "',
                                   '" . $picker . "'
                                  );";
        }

        // Artikel der neuen Pickliste zuweisen
        foreach ($aPicklistItems as $item) {
            $sqlNewPicklist .= "INSERT INTO
                                    stpArtikel2Pickliste(
                                      ArtikelID,
                                      PicklistID
                                    ) VALUES (
                                      '" . $item . "',
                                      '" . $PLHkey . "'
                                    );
                                    ";

            /**
             * Aktualisieren des Artikelstatus (entfernen von der Master Pickliste)
             * damit er aus dem zuweisebaren Pool der Artikel herausfällt.
             */
            $sqlNewPicklist .= "UPDATE stpPicklistItems SET ItemStatus = '1' WHERE ID = '{$item}';";
        }

        $this->oMySqli = new mysqli();
        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);

        // Einfügen der Datensätze in die DB
        if ($this->oMySqli->multi_query($sqlNewPicklist) === TRUE) {
            View::showAlert('success', null, "Die Pickliste <b>" . $PLHkey . "</b> wurde erfolgreich erstellt und <b>" . utf8_encode($this->getPickerInfo($picker)) . "</b> zugewiesen.");
        } else {
            View::showAlert('danger', null, "Error: " . $sqlNewPicklist . "<br>" . $this->oMySqli->error);
        }
        $this->oMySqli->close();
    }

    /** Auflistung aller Picker im System
     * @return array
     */
    public function getPicker()
    {
        $aPicker = array();
        $sql = $this->db->prepare("SELECT UID,name,vorname,dept FROM iUser WHERE dept = 'picker' OR dept = 'teamleiter' ORDER BY vorname, name ASC");
        $sql->execute();

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $aPicker[] = array('vorname' => $row['vorname'], 'name' => $row['name'], 'UID' => $row['UID']);
        }
        $sql->closeCursor();

        return $aPicker;
    }

    /**
     * @param $picklistType
     *
     * Neue AutoPickliste
     * Erstellen einer neuen Pickliste und
     * Übergabe der Picklisteninhalte als Array
     * zuweisen von Artikeln zu einer Pickliste
     *
     * INFO: nicht verwendet
     */
    public function newAutoPicklist($picklistType)
    {
        // init
        $picklist = null;

        switch ($picklistType) {
            case 'LX':
                $this->oMySqli = new mysqli();
                $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
                $this->oMySqli->set_charset('utf8');

                $sql_lx = "SELECT * FROM stpPicklistItems WHERE BinGroup = '030'";
                $picklist = $this->oMySqli->query($sql_lx);
                $this->oMySqli->close();
                break;

            case 'Paletten':
                $this->oMySqli = new mysqli();
                $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
                $this->oMySqli->set_charset('utf8');

                $sql_paletten = "SELECT * FROM stpPicklistItems WHERE BinGroup LIKE '090'";

                $picklist = $this->oMySqli->query($sql_paletten);
                $this->oMySqli->close();
                break;
        }

        $aPostData = $picklist;
        $PLHkey = $aPostData['plnr'];
        $createDate = date('y.m.d');
        $expDate = $aPostData['expDate'];
        $createdBy = $aPostData['creator'];
        $plComment = $aPostData['plKommentar'];
        $picker = $aPostData['picker'];
        $aPicklistItems = $_POST['newPicklist'];

        // Initialisierung - Aufbau der Multiquery
        $sqlInsertItems = null;

        $sqlNewPicklist = '';

        // Neue Pickliste erstellen
        $sqlNewPicklist .= "INSERT INTO
                                  stpPickliste(
                                   PLHkey,
                                   createDate,
                                   PLHexpiryDate,
                                   CreatedBy,
                                   plComment,
                                   picker
                                  ) VALUES (
                                   '" . $PLHkey . "',
                                   '" . $createDate . "',
                                   '" . $expDate . "',
                                   '" . $createdBy . "',
                                   '" . $plComment . "',
                                   '" . $picker . "'
                                  );";

        // Artikel der neuen Pickliste zuweisen
        foreach ($aPicklistItems as $item) {
            $sqlNewPicklist .= "INSERT INTO
                                    stpArtikel2Pickliste(
                                      ArtikelID,
                                      PicklistID
                                    ) VALUES (
                                      '" . $item . "',
                                      '" . $PLHkey . "'
                                    );
                                    ";

            /**
             * Aktualisieren des Artikelstatus (entfernen von der Master Pickliste)
             * damit er aus dem zuweisebaren Pool der Artikel herausfällt.
             */
            $sqlNewPicklist .= "UPDATE stpPicklistItems SET ItemStatus = '1' WHERE ID = '{$item}';";
        }

        $this->oMySqli = new mysqli();
        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);

        // Einfügen der Datensätze in die DB
        if ($this->oMySqli->multi_query($sqlNewPicklist) === TRUE) {
            View::showAlert('success', null, "Die Pickliste <b>" . $PLHkey . "</b> wurde erfolgreich erstellt und <b>" . $this->getPickerInfo($picker) . "</b> zugewiesen.");
        } else {
            View::showAlert('danger', null, "Error: " . $sqlNewPicklist . "<br>" . $this->oMySqli->error);
        }
        $this->oMySqli->close();
    }

    /**
     * Pixi Proxy setzen
     * @param null $oProxy
     */
    public function setOProxy($oProxy)
    {
        $this->oProxy = $oProxy;
    }
}