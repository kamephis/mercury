<?php

class Auftrag_Model extends Model
{
    private $artNr;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAuftrag($artNr)
    {
        $sql = "SELECT pli.*, DATE_FORMAT(pli.PicklistExpiryDate,'%m.%d.%Y') as expDate FROM stpPicklistItems pli WHERE ItemNrInt = '{$artNr}' ORDER BY Qty ASC";
        return $this->db->select($sql);
    }

    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;
    }
}