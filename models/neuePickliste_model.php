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
        $oSoapClient = new nusoap_client(PIXI_WSDL_PATH, true);
        $oSoapClient->setCredentials(PIXI_USERNAME, PIXI_PASSWORD);

        // pixi* API Objekt erzeugen
        $this->setOProxy($oSoapClient->getProxy());

        // MySQL Objekt erzeugen
        // TODO: mysqli durch PDO ersetzen
        $this->oMySqli = new mysqli();
    }

    /**
     * Leert alle Tabellen welche mit den Picklisten zu tun haben.
     */
    public function resetTables()
    {
        $sql = "TRUNCATE TABLE `stpArtikel2Pickliste`; TRUNCATE TABLE `stpPickliste`; TRUNCATE TABLE `stpPicklistItems`;TRUNCATE TABLE `stpArtikel2Auftrag`;";
        if ($this->db->query($sql)) return true;

        return false;
    }

    /**
     * Verfügbare Picklistennummer ermitteln
     * PDO-Version
     * @return mixed
     */
    public function getNewPicklistNr()
    {
        $sql = $this->db->prepare("SELECT MAX(PLHkey) as PLN FROM stpPickliste");
        $sql->execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        $sql->closeCursor();

        return $result['PLN'] + 1;
    }

    /**
     * Alle Picklisten aus dem Pixi Pool abrufen (zur Anzeige in der Picklistenerstellung)
     * @return mixed
     */
    public function getAllPixiPicklists()
    {
        $aAllPicklists = $this->oProxy->pixiShippingGetPicklistHeaders(array('LocID' => '001'));
        $aAllPicklists = $aAllPicklists['pixiShippingGetPicklistHeadersResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aAllPicklists;
    }

    /**
     * Artikel einer Pixi Pickliste abrufen
     * @param $picklistNr
     * @return mixed
     */
    public function getPicklistDetails($picklistNr)
    {
        $aPicklistDetails = $this->oProxy->pixiShippingGetPicklistDetails(array('PicklistKey' => $picklistNr));
        $aPicklistDetails = $aPicklistDetails['pixiShippingGetPicklistDetailsResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aPicklistDetails;
    }


    /**
     * Informationen über den Picker abfragen
     * @param $pickerID
     * @return string
     */
    private function getPickerInfo($pickerID)
    {
        $sqlPickerInfo = "SELECT vorname, name FROM iUser WHERE UID = '{$pickerID}'";
        $this->oMySqli = new mysqli();
        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
        $query = $this->oMySqli->query($sqlPickerInfo);
        $result = $query->fetch_assoc();

        return $result['vorname'] . ' ' . $result['name'];
    }

    /**
     * Pickliste aus Pixi in die interne Datenbank importieren
     * aktiv!
     * @param $picklist
     */
    public function importPicklist($picklist)
    {
        $sqlCheckPl = "SELECT PLIheaderRef FROM stpPicklistItems WHERE PLIheaderRef = '{$picklist}'";
        $this->oMySqli = new mysqli();

        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
        $this->oMySqli->set_charset('utf8');

        $result = $this->oMySqli->query($sqlCheckPl);
        $rows = $result->num_rows;
        $this->oMySqli->close();

        // Prüfen ob die Pickliste bereits existiert
        if ($rows == 0) {
            $this->oMySqli = new mysqli();
            $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);

            $aPicklistDetails = $this->getPicklistDetails($picklist);


            // Pickliste Zeile für Zeile in die stpPicklistItems Tabelle schreiben.

            // Initialisierung
            $sqlInsertItems = null;


            // Struktur des Arrays prüfen
            if (is_array($aPicklistDetails[0])) {
                foreach ($aPicklistDetails as $items) {
                    $sqlInsertItems .= "INSERT INTO 
                                  stpPicklistItems(
                                   BinItemRef,
                                   PicLinkSmall,
                                   PicLinkLarge,
                                   PLIheaderRef,
                                   BinSortNum,
                                   ItemName,
                                   BinName,
                                   BinKey,
                                   PicklistExpiryDate,
                                   PicklistCreateDate,
                                   Qty,
                                   PicklistComment,
                                   ItemNrSuppl,
                                   EanUpc,
                                   ItemNrInt,
                                   BinRef,
                                   BinGroup,
                                   PLIorderlineRef,
                                   Location,
                                   OtherItemsCount,
                                   PLHfromBox,
                                   PLHtoBox,
                                   PLIorderlineRef1
                                  ) VALUES (
                                   '" . $items['BinItemRef'] . "',
                                   '" . $items['PicLinkSmall'] . "',
                                   '" . (isset($items['PicLinkLarge']) ? $items['PicLinkLarge'] : '') . "',
                                   '" . $items['PLIheaderRef'] . "',
                                   '" . $items['BinSortNum'] . "',
                                   '" . $items['ItemName'] . "',
                                   '" . $items['BinName'] . "',
                                   '" . $items['BinKey'] . "',
                                   '" . $items['PicklistExpiryDate'] . "',
                                   '" . $items['PicklistCreateDate'] . "',
                                   '" . $items['Qty'] . "',
                                   '" . $items['PicklistComment'] . "',
                                   '" . $items['ItemNrSuppl'] . "',
                                   '" . $items['EanUpc'] . "',
                                   '" . $items['ItemNrInt'] . "',
                                   '" . $items['BinRef'] . "',
                                   '" . $items['BinGroup'] . "',
                                   '" . $items['PLIorderlineRef'] . "',
                                   '" . $items['Location'] . "',
                                   '" . $items['OtherItemsCount'] . "',
                                   '" . $items['PLHfromBox'] . "',
                                   '" . $items['PLHtoBox'] . "',
                                   '" . $items['PLIorderlineRef1'] . "'
                                    );";
                }
            } else {
                $sqlInsertItems .= "INSERT INTO 
                                  stpPicklistItems(
                                   BinItemRef,
                                   PicLinkSmall,
                                   PicLinkLarge,
                                   PLIheaderRef,
                                   BinSortNum,
                                   ItemName,
                                   BinName,
                                   BinKey,
                                   PicklistExpiryDate,
                                   PicklistCreateDate,
                                   Qty,
                                   PicklistComment,
                                   ItemNrSuppl,
                                   EanUpc,
                                   ItemNrInt,
                                   BinRef,
                                   BinGroup,
                                   PLIorderlineRef,
                                   Location,
                                   OtherItemsCount,
                                   PLHfromBox,
                                   PLHtoBox,
                                   PLIorderlineRef1
                                  ) VALUES (
                                   '" . $aPicklistDetails['BinItemRef'] . "',
                                   '" . $aPicklistDetails['PicLinkSmall'] . "',
                                   '" . (isset($aPicklistDetails['PicLinkLarge']) ? $aPicklistDetails['PicLinkLarge'] : '') . "',
                                   '" . $aPicklistDetails['PLIheaderRef'] . "',
                                   '" . $aPicklistDetails['BinSortNum'] . "',
                                   '" . $aPicklistDetails['ItemName'] . "',
                                   '" . $aPicklistDetails['BinName'] . "',
                                   '" . $aPicklistDetails['BinKey'] . "',
                                   '" . $aPicklistDetails['PicklistExpiryDate'] . "',
                                   '" . $aPicklistDetails['PicklistCreateDate'] . "',
                                   '" . $aPicklistDetails['Qty'] . "',
                                   '" . $aPicklistDetails['PicklistComment'] . "',
                                   '" . $aPicklistDetails['ItemNrSuppl'] . "',
                                   '" . $aPicklistDetails['EanUpc'] . "',
                                   '" . $aPicklistDetails['ItemNrInt'] . "',
                                   '" . $aPicklistDetails['BinRef'] . "',
                                   '" . $aPicklistDetails['BinGroup'] . "',
                                   '" . $aPicklistDetails['PLIorderlineRef'] . "',
                                   '" . $aPicklistDetails['Location'] . "',
                                   '" . $aPicklistDetails['OtherItemsCount'] . "',
                                   '" . $aPicklistDetails['PLHfromBox'] . "',
                                   '" . $aPicklistDetails['PLHtoBox'] . "',
                                   '" . $aPicklistDetails['PLIorderlineRef1'] . "'
                                    );";
            }

            // Einfügen der Datensätze in die DB
            if ($this->oMySqli->multi_query($sqlInsertItems) === TRUE) {
                Controller::showMessages('pixiImpSuccess');
            } else {
                View::showAlert('danger', null, "Error: " . $sqlInsertItems . "<br>" . $this->oMySqli->error);
            }
            $this->oMySqli->close();
        } else {
            Controller::showMessages('pixiImpCheck');
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
            View::showAlert('success', null, "Die Pickliste <b>" . $PLHkey . "</b> wurde erfolgreich erstellt und <b>" . $this->getPickerInfo($picker) . "</b> zugewiesen.");
        } else {
            View::showAlert('danger', null, "Error: " . $sqlNewPicklist . "<br>" . $this->oMySqli->error);
        }
        $this->oMySqli->close();
    }

    /**
     * Auflistung aller Picker im System
     * @return bool|mysqli_result
     */
    public function getPicker()
    {
        $aPicker = array();
        $sqlPicker = "SELECT UID,name,vorname,dept FROM iUser WHERE dept = 'picker' OR dept = 'teamleiter' ORDER BY vorname, name ASC";
        $this->oMySqli = new mysqli();
        $this->oMySqli->real_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME, DB_PORT);
        $this->oMySqli->set_charset('utf8');
        $result = $this->oMySqli->query($sqlPicker);

        while ($row = mysqli_fetch_assoc($result)) {
            $aPicker[] = array('vorname' => $row['vorname'], 'name' => $row['name'], 'UID' => $row['UID']);
        }
        $this->oMySqli->close();

        return $aPicker;
    }

    /**
     * @param $picklistType
     *
     * Neue AutoPickliste
     * Erstellen einer neuen Pickliste und
     * Übergabe der Picklisteninhalte als Array
     * zuweisen von Artikeln zu einer Pickliste
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