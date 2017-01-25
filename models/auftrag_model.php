<?php

class Auftrag_Model extends Model
{
    //private $oProxy;

    public function __construct()
    {
        parent::__construct();

    }

    public function getAuftrag($artNr)
    {
        $sql = "SELECT pli.*, DATE_FORMAT(pli.PicklistExpiryDate,'%d.%m.%Y') as expDate,DATE_FORMAT(pli.PicklistCreateDate,'%d.%m.%Y') as createDate FROM stpPicklistItems pli WHERE ItemNrInt = '{$artNr}' ORDER BY Qty DESC";
        return $this->db->select($sql);
    }

    // Setter
    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;
    }
}