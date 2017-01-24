<?php

class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMasterPicklist()
    {
        $sql = "SELECT * FROM stpPickliste";
        return $this->db->select($sql);
    }

    public function getPicklistItems($picklistID)
    {
        $sql = "SELECT pitem.*
                FROM stpPicklistItems pitem
                RIGHT JOIN stpArtikel2Pickliste a2p
                ON (pitem.id = a2p.ArtikelID)
                WHERE a2p.PicklistID = '{$picklistID}'";

        return $this->db->select($sql);
    }

}