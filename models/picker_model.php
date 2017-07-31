<?php

/**
 * Abfragen der Picklisteninformationen aus der Intranet Datenbank
 * Datenbasis für die Auflistung der Picklisten für den Benutzer dem
 * sie zugewiesen sind.
 *
 * @autor: Marlon Böhland
 * @access: public
 */
class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Alle Artikelpositionen der importierten Pixi Picklisten abfragen
     * @param $picker
     * @return array
     */
    public function getMasterPicklist($picker)
    {
        $sql = "SELECT pl.*, DATE_FORMAT(pl.createDate,'%d.%m.%Y') as createDate, DATE_FORMAT(pl.PLHExpiryDate,'%d.%m.%Y') as expDate, PLcomment FROM stpPickliste pl WHERE pl.picker = '{$picker}' AND pl.status != '1'";
        return $this->db->select($sql);
    }

    /**
     * Anzahl der erzeugten Picklisten abrufen
     * @param $PLHkey
     * @return mixed
     */
    public function getPicklistItemCount($PLHkey)
    {
        $sql = "SELECT count(*) as anzahl FROM (SELECT count(*) FROM stpArtikel2Pickliste a2p 
                RIGHT JOIN stpPicklistItems pitem
                ON a2p.ArtikelID = pitem.ID
                
                WHERE a2p.PicklistID = '{$PLHkey}'
                AND pitem.ItemStatus != 2
                AND LENGTH(pitem.ItemFehlerUser) = 0
                GROUP BY EanUpc
                ) as cnt";
        $result = $this->db->select($sql);
        return $result[0]['anzahl'];
    }

    public function getFehlerhafteArtikel()
    {
        $sql = "SELECT * FROM stpPicklistItems WHERE ItemFehler <> ''";
        $result = $this->db->select($sql);
        return $result;
    }
}