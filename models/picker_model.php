<?php

class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        echo "model geladen";
    }

    public function getMasterPicklist()
    {
        $sql = "SELECT * FROM stpPickliste";
        return $this->db->select($sql);
    }


}