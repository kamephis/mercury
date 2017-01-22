<?php

/**
 * User: Marlon
 * Date: 14.12.2016
 * Time: 00:16
 */
class DBase extends PDO
{
    /**
     * DBase constructor.
     */
    public function __construct()
    {
        parent::__construct('mysql:host=192.168.200.2;dbname=usrdb_stokcgbl5', 'stokcgbl5', 'X$9?2IMalDUU');
    }
}