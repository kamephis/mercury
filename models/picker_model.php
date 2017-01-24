<?php

class Picker_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        echo "<br><br><br><br><br><br><br>picker model";
        $this->myName = "Marlon";
    }

    public function getMasterPicklist()
    {
        $sql = "SELECT * FROM stpPickliste";
        return $this->db->select($sql);
    }


}