<?php

/**
 * Funktionen für dem Import der Pixi Picklisten
 * Erstellen neuer (interner) Picklisten (Digitale Pickliste)
 *
 * @author: Marlon Böhland
 * @date: 29.12.2016
 */
class ImportPixiPickliste_Model extends Model
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
        $this->oMySqli = new mysqli();
    }

    /**
     * Alle Picklisten aus dem Pixi Pool abrufen (zur Anzeige in der Picklistenerstellung)
     * @return mixed
     */
    public function getAllPixiPicklists2()
    {
        $aAllPicklists = $this->oProxy->pixiShippingGetPicklistHeaders(array('LocID' => '001'));
        $aAllPicklists = $aAllPicklists['pixiShippingGetPicklistHeadersResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aAllPicklists;
    }

    /**
     * Alle Picklisten aus dem Pixi Auftrags-Pool abrufen (zur Anzeige in der Pixklistenerstellung)
     * Neue Version mit Error-Handling
     * @return mixed
     */
    public function getAllPixiPicklists()
    {
        $aAllPicklists = $this->oProxy->pixiShippingGetPicklistHeaders(array('LocID' => '001'));

        if (isset($aAllPicklists['pixiShippingGetPicklistHeadersResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'])) {
            $aAllPicklists = $this->oProxy->pixiShippingGetPicklistHeaders(array('LocID' => '001'));
            $aAllPicklists = $aAllPicklists['pixiShippingGetPicklistHeadersResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

            return $aAllPicklists;
        }
        return false;
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

            // Leeren der Tabelle (falls erforderlich)
            //$sqlInsertItems = "TRUNCATE TABLE stpPicklistItems;";

            // Struktur des Arrays prüfen
            if (is_array($aPicklistDetails[0])) {
                foreach ($aPicklistDetails as $items) {

                    // Zusatzinfos abfragen
                    //$aPicklistOrderItem = $this->oProxy->pixiGetOrderline(array('PLIorderlineRef' => $items['PLIorderlineRef']));
                    //$aPicklistOrderItem = $aPicklistOrderItem['pixiShippingGetPicklistDetailsResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];


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
                                   ItemOrderDate,
                                   Qty,
                                   PicklistComment,
                                   ItemNrSuppl,
                                   OrderNrExternal,
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
                                   '" . (isset($items['PicLinkSmall']) ? $items['PicLinkSmall'] : '') . "',
                                   '" . (isset($items['PicLinkLarge']) ? $items['PicLinkLarge'] : '') . "',
                                   '" . $items['PLIheaderRef'] . "',
                                   '" . $items['BinSortNum'] . "',
                                   '" . $items['ItemName'] . "',
                                   '" . $items['BinName'] . "',
                                   '" . $items['BinKey'] . "',
                                   '" . $items['PicklistExpiryDate'] . "',
                                   '" . $items['PicklistCreateDate'] . "',
                                   '',
                                   '" . $items['Qty'] . "',
                                   '" . $items['PicklistComment'] . "',
                                   '" . $items['ItemNrSuppl'] . "',
                                   '" . $items['OrderNrExternal'] . "',
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
                                   OrderNrExternal,
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
                                   '" . $aPicklistDetails['OrderNrExternal'] . "',
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
                echo '<div class="alert alert-success msgFooter">';
                echo "Alle Eintraege wurden erfolgreich importiert.";
                echo '</div>';
            } else {
                echo "Error: " . $sqlInsertItems . "<br>" . $this->oMySqli->error;
            }
            $this->oMySqli->close();
        } else {
            echo '<div class="alert alert-warning msgFooter">';
            echo "Diese Pickliste wurde bereits importiert.";
            echo '</div>';
        }
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
     * Pixi Proxy setzen
     * @param null $oProxy
     */
    public function setOProxy($oProxy)
    {
        $this->oProxy = $oProxy;
    }
}