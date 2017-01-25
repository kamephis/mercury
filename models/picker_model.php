<?php

class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMasterPicklist()
    {
        $sql = "SELECT pl.*, DATE_FORMAT(pl.createDate,'%d.%m.%Y') as createDate, DATE_FORMAT(pl.PLHExpiryDate,'%d.%m.%Y') as expDate FROM stpPickliste pl";
        return $this->db->select($sql);
    }

    
}