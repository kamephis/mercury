<?php

class Picklist_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPicklistItems($picklistNr)
    {
        $sql = "SELECT pitem.*
                FROM stpPicklistItems pitem
                RIGHT JOIN stpArtikel2Pickliste a2p
                ON (pitem.id = a2p.ArtikelID)
                
                WHERE pitem.PLHkey = '{$picklistNr}'
                LIMIT 1
                ";

        return $this->db->select($sql);
    }
    /*WHERE a2p.PicklistID = '{$picklistID}'*/
}