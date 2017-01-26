<?php

class Auftrag_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Zusammenstellen eines Zuschneideauftrags
     * anhand der Artikelnummer des gescannten
     * Stoffs.
     * @param $artNr
     * @return mixed
     */
    public function getAuftrag($artNr)
    {
        $sql = "SELECT pli.*, DATE_FORMAT(pli.PicklistExpiryDate,'%d.%m.%Y') as expDate,DATE_FORMAT(pli.PicklistCreateDate,'%d.%m.%Y') as createDate FROM stpPicklistItems pli WHERE ItemNrInt = '{$artNr}' ORDER BY Qty DESC";
        return $this->db->select($sql);
    }

    /**
     * Setzen des Status einer (intenrnen) Pickliste
     * @param $auftragNr
     * @param $status
     */
    public function setAuftragStatus($auftragNr, $status)
    {
        $sql = "UPDATE stpZuschneideAuftraege SET Status = '{$status}'";
    }

    /**
     * Aktualisieren des Status einer Auftragsposition
     * Boolean (in DB)
     * Standard: Null
     * Gepickt: 1
     * @param $id
     * @param $status
     */
    public function setItemStatus($id, $status)
    {
        $sql = "UPDATE stpPicklistItems SET ItemStatus = '{$status}' WHERE ID = '{$id}'";
    }

    // Setzen der Artikelnummer
    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;
    }
}