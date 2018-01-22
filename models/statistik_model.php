<?php

/**
 * Model: Statistik
 *
 * @author: Marlon Böhland
 * @access: public
 */
class Statistik_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPickStatistik($picker = null, $auftragsdatum = null)
    {
        $cond = "";

        if (!empty($picker)) {
            $cond .= ' AND picker = ' . $picker;
        }

        if (!empty($auftragsdatum)) {
            $cond .= " AND DATE_FORMAT(picklisten.CreateDate, '%Y-%m-%d') = '{$auftragsdatum}'";
        }

        $sql = "SELECT 
                  sum(picklisten.anzArtikel) as menge,
                  sum(TIMESTAMPDIFF(MINUTE, picklisten.pickStart, picklisten.pickEnd)) as dauer,
                  concat(usr.vorname,' ',usr.name) picker,
                  DATE_FORMAT(picklisten.createDate, '%d.%m.%Y') datum
                  FROM stpPickliste as picklisten
                  
                  LEFT JOIN iUser as usr
                  ON usr.UID = picklisten.picker
                  
                  WHERE 1=1
                  {$cond}
                  
                  GROUP BY picklisten.createDate, picklisten.picker";

        return $this->db->select($sql);
    }


    /**
     * Auslesen der Auftragsinfos
     *
     * @return  array       Rückgabe aller Zuschneideaufträge
     */
    public function getAuftragsInfos($userID, $date)
    {
        $filter = null;

        if (isset($userID) && strlen($userID) > 0) $filter .= " AND UserID ='$userID' ";
        if (isset($date) && strlen($date) > 0) $filter .= " AND auftrag.TimestampStart LIKE '{$date}%'";

        $sql = "
        SELECT 
        (auftrag.TimestampEnd - auftrag.TimestampStart) dauer,
        DATE_FORMAT(auftrag.TimeStampStart,'%d.%m.%Y') datum,
        concat(usr.vorname, ' ',usr.name) uname,
        sum(auftrag.Anzahl) Menge,
        auftrag.* 
        
        FROM stpZuschneideAuftraege as auftrag
        
        LEFT JOIN iUser as usr
        
        ON usr.UID = auftrag.UserID
        
        WHERE auftrag.Status = 1
        AND auftrag.Anzahl > 0 
        {$filter}
        GROUP BY auftrag.UserID, DATE_FORMAT(auftrag.TimeStampStart,'%d.%m.%Y')
        ORDER BY auftrag.TimeStampStart DESC";

        return $this->db->select($sql);
    }

}