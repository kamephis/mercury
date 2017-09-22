<?php

class SetItemStatus_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_moveArticleToEscalateList($_POST['articleID']);
    }

    /**
     * Setzt den ItemStatus auf einen bestimmten Wert
     * 0 = importiert
     * 1 = einer Pickliste zugewiesen
     * 2 = gepickt
     * 3 = zugeschnitten
     * 4 = Fehler
     * 5 = eskaliert -> KuS
     *
     * @param $articleID
     * @param $itemStatus
     */
    private function _setItemStatus($articleID, $itemStatus)
    {
        $aUpdate = array('ItemStatus' => $itemStatus);
        $this->db->update('stpPicklistItems', $aUpdate, 'ID = ' . $articleID);
    }

    /**
     * Einfügen der eskalierten Positionen die noch nicht
     * in der Liste vorhanden sind
     *
     * @param $articleID
     */
    private function _moveArticleToEscalateList($articleID)
    {
        $this->_setItemStatus($articleID, '5');

        $sql = "INSERT INTO stpEscalateList
                SELECT '' as EID, pl.*
                FROM stpPicklistItems pl
                WHERE pl.ItemStatus = '5'
                AND pl.ID = :articleID
                ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':articleID', $articleID);
        $stmt->execute();
    }
}
