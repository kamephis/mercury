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

    public function getPickStatistik($picker = null, $auftragsdatum_von = null, $auftragsdatum_bis = null)
    {
        $cond = "";

        if (!empty($picker)) {
            $cond .= " AND stasi.UID = " . $picker;
        }

        if (!empty($auftragsdatum_von) && !empty($auftragsdatum_bis)) {
            $cond .= " AND stasi.TimestampStart BETWEEN '{$auftragsdatum_von} 00:00:00' AND DATE_ADD('{$auftragsdatum_bis} 00:00:00', INTERVAL 1 DAY)";

        }

        $sql = "
        SELECT 
                  sum(stasi.NumItems) as menge,
                  SEC_TO_TIME(sum(TIMESTAMPDIFF(SECOND, stasi.TimestampStart, stasi.TimestampEnd))) as dauer,
                  concat(usr.vorname,' ',usr.name) bearbeiter,
                  DATE_FORMAT(stasi.TimestampStart, '%d.%m.%Y') datum

                  FROM stpZeiterfassung as stasi

                  LEFT JOIN iUser as usr
                  ON usr.UID = stasi.UID
                  WHERE 1=1
                  {$cond}
                  GROUP BY stasi.UID
        ";
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
        SEC_TO_TIME(sum(TIMESTAMPDIFF(SECOND,auftrag.TimestampStart, auftrag.TimestampEnd))) dauer,
        DATE_FORMAT(auftrag.TimeStampStart,'%d.%m.%Y') datum,
        concat(usr.vorname, ' ',usr.name) uname,
        auftrag.UserID,
        auftrag.ArtEAN,
        sum(auftrag.Anzahl) Menge
      
        FROM stpZuschneideAuftraege as auftrag
        
        LEFT JOIN iUser as usr
        
        ON usr.UID = auftrag.UserID
        
        WHERE auftrag.Status = 1
        AND auftrag.Anzahl > 0 
        AND concat(usr.vorname,' ',usr.name) != 'Zu Schneider' /* Test user */
        /*AND DATE_FORMAT(auftrag.TimeStampStart,'%d.%m.%Y') = '22.01.2018'*/
        {$filter}
        GROUP BY auftrag.UserID
        HAVING dauer > 0
        ORDER BY auftrag.TimeStampStart DESC
        ";

        return $this->db->select($sql);
    }

    /**
     * Ungruppierte Ausgabe der Zuschnitt-Auftraege
     * @return array
     */
    public function getAuftragInfoUngruppiert($userID, $date)
    {
        $filter = null;
        if (isset($userID) && strlen($userID) > 0) $filter .= " AND usr.UID ='$userID' ";
        if (isset($date) && strlen($date) > 0) $filter .= " AND auftrag.TimestampStart LIKE '{$date}%'";

        $sql = "
           SELECT 
        SEC_TO_TIME(TIMESTAMPDIFF(SECOND, auftrag.TimestampStart, auftrag.TimestampEnd)) as dauer,
        auftrag.TimeStampStart,
        auftrag.TimeStampEnd,
        DATE_FORMAT(auftrag.TimeStampStart,'%d.%m.%Y') datum,
        concat(usr.vorname, ' ',usr.name) uname,
        auftrag.UserID,
        auftrag.Anzahl Menge,
        auftrag.ArtEAN
      
        FROM stpZuschneideAuftraege as auftrag

        /*CROSS JOIN(
        	SELECT
        	UserID,
			SEC_TO_TIME(sum(TIMESTAMPDIFF(SECOND,TimestampStart, TimestampEnd))) dauer
			FROM stpZuschneideAuftraege

			WHERE Status = 1
        	AND Anzahl > 0 
        ) a2*/
        
        LEFT JOIN iUser as usr
        ON usr.UID = auftrag.UserID
        
        WHERE auftrag.Status = 1
        AND auftrag.Anzahl > 0 
        AND concat(usr.vorname,' ',usr.name) != 'Zu Schneider' /* Test user */
        {$filter}
                
        /*HAVING dauer > 0*/
        ORDER BY auftrag.TimeStampStart DESC
        ";
        echo "<textarea>";
        echo $sql;
        echo "</textarea>";
        return $this->db->select($sql);
    }

    /**
     * Get Item Name
     * @param $ean
     * @return mixed
     */
    public function getItemName($ean)
    {
        $sql = "SELECT ItemName FROM stpPicklistItems WHERE EanUpC = '{$ean}' LIMIT 1";
        $result = $this->db->select($sql);
        return $result[0]['ItemName'];
    }

}