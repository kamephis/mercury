<?php

class Database extends PDO
{

    //public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    public function __construct()
    {
        parent::__construct('mysql:host=192.168.200.2;port=3307;dbname=usrdb_stokcgbl5', 'stokcgbl5', 'X$9?2IMalDUU');

    }
}