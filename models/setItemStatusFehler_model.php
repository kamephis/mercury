<?php

class SetItemStatusFehler_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_setItemStatusFehler($_POST['articleID'], $_POST['ItemStatus']);
    }

    /**
     * @param $articleID
     * @param $itemStatus
     */
    public function _setItemStatusFehler($articleID, $itemStatus)
    {
        $aUpdate = array('ItemStatus' => $itemStatus, 'ItemFehler' => '', 'ItemFehlbestand' => '', 'ItemFehlerKommentar' => '', 'ItemFehlerUser' => '');
        $this->db->update('stpPicklistItems', $aUpdate, 'ID = ' . $articleID);
    }
}
