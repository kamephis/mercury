<?php
/**
 * Class Picklist_Model
 * User: Marlon Böhland
 * Update: 28.07.2017
 */
class Picklist_Model extends Model
{
    private $aPicklist;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Auslesen der Picklistenpositionen
     * @param $picklistNr
     * @param $pos
     * @return array
     */
    public function getPicklistItems($picklistNr, $pos)
    {
        $sql = "SELECT pitem.*, plist.PLHkey
                FROM stpPicklistItems pitem, stpArtikel2Pickliste a2p, stpPickliste plist
                WHERE
                pitem.ID = a2p.ArtikelID AND
                a2p.PicklistID = plist.PLHkey AND 
                plist.PLHkey = '{$picklistNr}' AND
                pitem.ItemStatus = 1 AND 
                LENGTH(pitem.ItemFehlerUser) = 0
                
                GROUP BY pitem.EanUpc
                ORDER BY pitem.BinSortNum
                ";

        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * Alle Picklisteneinträge anzeigen
     * @param $picklistNr
     * @return array
     *
     * nicht verwendet
     */
    public function getAllPicklistItems($picklistNr)
    {
        $sql = "SELECT count(pitem.EanUpc) anz
                FROM stpPicklistItems pitem, stpArtikel2Pickliste a2p, stpPickliste plist

                WHERE
                pitem.ID = a2p.ArtikelID AND
                a2p.PicklistID = plist.PLHkey AND 
                plist.PLHkey = '{$picklistNr}' AND
                pitem.ItemStatus = 1
                GROUP BY pitem.EanUpc";

        $result = $this->db->select($sql);
        return $result[0]['anz'];
    }

    /**
     * Anzahl der Picklistenpositionen die nach der Gruppierung
     * für die Berechnung der Seitennavigation verwendet werden.
     * @param $PLHkey
     * @return mixed
     */
    public function getPicklistItemCount($PLHkey)
    {
        $sql = "SELECT count(*) as anzahl FROM (SELECT pitem.*, plist.PLHkey
                FROM stpPicklistItems pitem, stpArtikel2Pickliste a2p, stpPickliste plist
                WHERE
                pitem.ID = a2p.ArtikelID AND
                a2p.PicklistID = plist.PLHkey AND 
                plist.PLHkey = '{$PLHkey}' AND
                pitem.ItemStatus != 2
                GROUP BY pitem.EanUpc
                ) as cnt";
        $result = $this->db->select($sql);
        return $result[0]['anzahl'];
    }

    /**
     * Anzahl der Picklistenpositionen die tatsächlich gepickt werden müssen
     * (immer aktuell, welche noch zu picken sind)
     * @param $PLHkey
     * @return mixed
     */
    public function getRealPicklistItemCount($PLHkey)
    {
        $sql = "SELECT count(pitem.ID) as anz FROM stpArtikel2Pickliste a2p 
                RIGHT JOIN stpPicklistItems pitem
                ON a2p.ArtikelID = pitem.ID
                
                WHERE a2p.PicklistID = '{$PLHkey}'
                AND pitem.ItemStatus = 1";

        $result = $this->db->select($sql);
        return $result[0]['anz'];
    }

    /**
     * Groesse der Pickliste ausgeben
     * @param $PLHkey
     * @return mixed
     */
    public function getGroessePicklist($PLHkey)
    {
        $sql = "SELECT count(*) as anz FROM stpArtikel2Pickliste a2p 
                RIGHT JOIN stpPicklistItems pitem
                ON a2p.ArtikelID = pitem.ID
                
                WHERE a2p.PicklistID = '{$PLHkey}'
                AND pitem.ItemStatus != 0";
        $result = $this->db->select($sql);
        return $result[0]['anz'];
    }
    /**
     * @param $articleID
     */
    public function setItemStatusArt($articleID)
    {
        $aUpdate = array('ItemStatus' => '2');
        $this->db->update('stpPicklistItems', $aUpdate, 'ID = ' . $articleID);
    }

    /**
     * Setzen des ItemStatus auf bei allen Artikeln mit dieser EAN auf 2 (gepickt)
     * Zurücksetzen des Item Fehlers (da korrigiert)
     * @param $articleEan
     * @param $locationID
     */
    public function setItemStatus($articleEan, $locationID)
    {
        $aUpdate = array('ItemStatus' => '2', 'CurrentItemLocation' => $locationID, 'ItemFehler' => '', 'ItemFehlbestand' => '', 'ItemFehlerUser' => '');
        $this->db->update('stpPicklistItems', $aUpdate, 'EanUpc = ' . $articleEan);
    }

    /**
     * Setzen des ItemFehler / ItemFehlmenge auf den gewählten Wert aus dem Form-Array
     * @param $articleID
     */
    public function setItemFehler($articleID, $aFehler, $intItemFehlbestand, $checked = null, $pruefer = null)
    {
        // charset fix
        if ($aFehler != Null) {
            $aFehler = utf8_decode($aFehler);
        }
        $aUpdate = array('ItemFehler' => $aFehler, 'ItemFehlbestand' => $intItemFehlbestand, 'ItemFehlerUser' => $_SESSION['vorname'] . " " . $_SESSION['name'], "geprueft" => $checked, "pruefer" => $pruefer);
        $this->db->update('stpPicklistItems', $aUpdate, 'ID = ' . $articleID);
    }

    /**
     * @param $plistNr
     * @param $status
     */
    public function setPicklistStatus($plistNr, $status)
    {
        $aUpdate = array('status' => $status);
        $this->db->update('stpPickliste', $aUpdate, 'PLHKEY = ' . $plistNr);
    }

    /**
     * @param $articleEAN
     * @param $PLHkey
     * @return array
     */
    public function getItemPickAmount($articleEAN, $PLHkey)
    {
        $sql = "SELECT Qty,(SELECT sum(Qty) FROM stpArtikel2Pickliste a2p 
                RIGHT JOIN stpPicklistItems pitem
                ON a2p.ArtikelID = pitem.ID
                
                WHERE a2p.PicklistID = '{$PLHkey}'
                AND pitem.EanUpc = '{$articleEAN}') as pSum
                
                FROM stpArtikel2Pickliste a2p 
                RIGHT JOIN stpPicklistItems pitem
                ON a2p.ArtikelID = pitem.ID
                
                WHERE a2p.PicklistID = '{$PLHkey}'
                AND pitem.EanUpc = '{$articleEAN}'";
        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * Abfrage der Bestellungen / Artikel
     * @param $articleEAN
     * @return array
     */
    public function getOrders($articleEAN)
    {
        $sql = "SELECT OrderNrExternal, Qty, PLIheaderRef FROM stpPicklistItems WHERE EanUpc = '{$articleEAN}'";
        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * Anzeigen des/der Artikelfehler/s
     * @param $artID
     * @return array
     */
    public function getItemFehler($artID)
    {
        $sql = "SELECT ItemFehler,ItemFehlbestand, ItemFehlerKommentar FROM stpPicklistItems WHERE ItemFehler <> '' AND ID = '{$artID}'";
        $result = $this->db->select($sql);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getAPicklist()
    {
        return $this->aPicklist;
    }

    /**
     * @param mixed $aPicklist
     */
    public function setAPicklist($aPicklist)
    {
        $this->aPicklist = $aPicklist;
    }
}