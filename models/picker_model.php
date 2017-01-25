<?php

class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMasterPicklist()
    {
        $sql = "SELECT pl.*, DATE_FORMAT(pl.createDate,'%d.%m.%Y') as createDate FROM stpPickliste pl";
        return $this->db->select($sql);
    }

    
}