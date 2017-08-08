<?php

/**
 * Abfragen der Picklisteninformationen aus der Intranet Datenbank
 * Datenbasis für die Auflistung der Picklisten für den Benutzer dem
 * sie zugewiesen sind.
 *
 * @autor: Marlon Böhland
 * @access: public
 */
class Backend_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ausgabe aller Zuschneideauftraege
     * @param $userID
     * @return array
     */
    public function getZuschneideauftaege($userID)
    {
        $sql = "SELECT * FROM stpZuschneideAuftraege WHERE UserID = '{$userID}' GROUP BY ArtEAN";
        return $this->db->select($sql);
    }

    /**
     * @return array
     */
    public function getFehlerhafteArtikel()
    {
        $sql_gruppiert = "SELECT items.*, items.EanUpc, SUM(items.Qty) as BestMenge FROM stpPicklistItems items
            WHERE
            (items.ItemFehler != '' OR
            items.ItemFehlbestand != '' )
            GROUP BY items.EanUpc
            ORDER BY items.BinName";

        $sql = "SELECT items.*, items.EanUpc, items.Qty as BestMenge FROM stpPicklistItems items
            WHERE
            (items.ItemFehler != '' OR
            items.ItemFehlbestand != '' )
            ORDER BY items.BinSortNum";
        return $this->db->select($sql);

    }

    /**
     * Auslesen der bearbeiteten Aufträge
     * @return array
     */
    public function getAuftragsuebersicht()
    {
        return $this->db->select($sql);
    }

    /**
     * Anzeige der Picklistenpositionen
     * @param $picklistNr
     * @param $pos
     * @return array
     */
    public function getPicklistItems($picklistNr)
    {
        /*
        $sql = "SELECT items.*, items.EanUpc, SUM(items.Qty) as BestMenge FROM stpPicklistItems items
            WHERE
            (items.ItemFehler != '' OR
            items.ItemFehlbestand != '' )
            GROUP BY items.EanUpc
            ORDER BY items.BinName";
        return $this->db->select($sql);
*/
        $sql = "SELECT pitem.*, plist.PLHkey,
                date_format(TimestampUpdateStatus, '%d.%m.%Y') AS 'UpdateDate', date_format(TimestampUpdateStatus, '%H.%i') AS 'UpdateTime',
                SUM(pitem.Qty) as BestMenge  
                FROM stpPicklistItems pitem, stpArtikel2Pickliste a2p, stpPickliste plist
                WHERE
                pitem.ID = a2p.ArtikelID AND
                a2p.PicklistID = plist.PLHkey AND 
                plist.PLHkey = '{$picklistNr}' AND
                pitem.ItemStatus != '0' 
                
                GROUP BY pitem.EanUpc
                ORDER BY pitem.BinSortNum";
        return $this->db->select($sql);

    }

    /**
     * Rückgabe der % gepickt / Pickliste
     * @param $picklistNr
     * @return float|int
     */
    public function getPicklistStatusProzent($picklistNr)
    {
        $sql1 = "SELECT *
FROM stpPicklistItems pitem
RIGHT JOIN stpArtikel2Pickliste a2p
ON pitem.id = a2p.ArtikelID
                
LEFT JOIN stpPickliste plist
ON a2p.PicklistID = plist.PLHkey
                
WHERE plist.PLHkey = {$picklistNr}
AND a2p.PicklistID = {$picklistNr}
/*AND pitem.ItemStatus != 0*/
/*GROUP BY pitem.EanUpc*/
ORDER BY pitem.BinSortNum";

        $status_eins = $this->db->select($sql1);

        $sql2 = "SELECT *
FROM stpPicklistItems pitem
RIGHT JOIN stpArtikel2Pickliste a2p
ON pitem.id = a2p.ArtikelID
                
LEFT JOIN stpPickliste plist
ON a2p.PicklistID = plist.PLHkey
                
WHERE plist.PLHkey = {$picklistNr}
AND a2p.PicklistID = {$picklistNr}
AND (pitem.ItemStatus = 2 OR pitem.ItemStatus = 3 OR pitem.ItemStatus = 4)
/*GROUP BY pitem.EanUpc*/
ORDER BY pitem.BinSortNum";

        $status_zwei = $this->db->select($sql2);
        $gesamt = sizeof($status_eins);
        $gepickt = sizeof($status_zwei);
        $prozent = (100 / $gesamt) * $gepickt;
        return round($prozent);
    }

    /**
     * Anzeige der aktiven Picklisten
     * @return array
     */

    public function getActivePicklists()
    {
        $sql = "SELECT picklist.*, user.name, user.vorname, date_format(picklist.createDate, '%d.%m.%Y') as PicklistCreateDate FROM stpPickliste picklist
                LEFT JOIN iUser user
                ON picklist.picker = user.UID
                /*WHERE picklist.Status = 0*/
                ";
        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * Auslesen aller verfügbaren Picker
     * @return array
     */
    public function getAllPicker()
    {
        $sql = "SELECT UID, name, vorname FROM iUser WHERE dept = 'picker' ORDER BY vorname ASC";
        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * Aktualisieren der Pickliste
     * @param $picklistID
     * @param $pickerID
     */
    public function updatePicklist($picklistID, $pickerID)
    {
        $aUpdate = array('picker' => $pickerID);
        $this->db->update('stpPickliste', $aUpdate, 'PLHkey = ' . $picklistID);
    }

    /**
     * Löschen einer Pickliste und Zurücksetzen der Artikel
     * auf den Status 0 (zuweisbar)
     * @param $picklistID
     * @return array
     */
    public function delPicklist($picklistID)
    {
        $sql_1 = "UPDATE stpPicklistItems pli
                  SET ItemStatus = 0

                  WHERE pli.ID IN (
	              SELECT ArtikelID FROM stpArtikel2Pickliste WHERE PicklistID = '{$picklistID}')";

        $sql_2 = "DELETE FROM stpArtikel2Pickliste WHERE PicklistID = '{$picklistID}'";
        $sql_3 = "DELETE FROM stpPickliste WHERE PLHkey = '{$picklistID}'";

        $this->db->select($sql_1);
        $this->db->select($sql_2);
        $this->db->select($sql_3);
    }
}