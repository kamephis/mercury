<?php

class SetItemStatus_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_setItemStatus($_POST['articleID'], $_POST['ItemStatus']);
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
        $sql = "INSERT INTO stpEscalateList
                SELECT '', pl.*
                FROM stpPicklistItems pl
                WHERE ItemStatus = '5'
                AND ID = :articleID";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':articleID', $articleID);
        $stmt->execute();
    }
}
