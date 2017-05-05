<?php

/**
 * Funktionen für die Auftragsbearbeitung am Zuschneidetisch
 *
 * @author: Marlon Böhland
 * @access: public
 */
class Auftrag_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Neuer Zuschneideauftrag erstellen
     * @param $userID
     */
    public function newAuftrag($userID, $artEAN)
    {
        $this->db->insert('stpZuschneideAuftraege', array('UserID' => $userID, 'ArtEAN' => $artEAN));
    }

    /**
     * Artikelposition in die Auftragstabelle einfügen
     * Der Status der Position kann hier gesetzt werden.
     * @param $artID
     * @param $auftragID
     * @param $menge
     *
     * wird nicht verwendet
     */
    public function insertArticle2Auftrag($artID, $auftragID, $menge)
    {
        $this->db->insert('stpArtikel2Auftrag', array('ArtID' => $artID, 'AuftragID' => $auftragID, 'Menge' => $menge));
    }

    /**
     * Auslesen der neuesten Auftragsnummer
     * @return array
     */
    public function getAuftragsnummer()
    {
        $sql = "SELECT MAX(AuftragsID) as AuftragsNr FROM stpZuschneideAuftraege";
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

        if (isset($userID)) $filter .= "AND UserID ='$userID' ";
        if (isset($date)) $filter .= "WHERE auftrag.TimestampStart LIKE '{$date}%'";

        $sql = "
                  SELECT (TimestampEnd - TimestampStart) dauer, DATE_FORMAT(TimeStampStart,'%d.%m.%Y') datum, concat(usr.vorname, ' ',usr.name) uname, auftrag.* FROM stpZuschneideAuftraege as auftrag
                  LEFT JOIN iUser as usr
                  ON usr.UID = auftrag.UserID
                  /*GROUP BY auftrag.userID, auftrag.ArtEAN*/
                  
                  {$filter}
                  ORDER BY datum DESC
                  ";
        return $this->db->select($sql);
    }

    /**
     * Auftrag abschließen
     * Existiert eigentlich nur zur Erfassung der Endzeit des Auftrags und
     * der bearbeiteten Meteranzahl des Artikels
     *
     * @param $auftragsID int   ID in der Artikel2Auftrag Tabelle
     * @param $kommentar String Kommentar des Anwenders zum Auftrag
     * @return array
     */
    public function finishAuftrag($auftragsID, $anzahl)
    {
        $aUpdate = array('Status' => '1', 'Anzahl' => $anzahl);
        $this->db->update('stpZuschneideAuftraege', $aUpdate, 'AuftragsID = ' . $auftragsID);
    }

    /**
     * Abschließen einer Auftragsposition
     * Status = 3 Aufträge sind fertig bearbeitet, es wurde ein Etikett für den Ship-Out gedruckt
     * Diese Aufträge tauchen nicht mehr auf anderen Aufträgen auf.
     *
     * @param $artID
     */
    public function setAuftragsPositionStatus($artID, $aNr)
    {
        $aUpdate = array('ItemStatus' => '3', 'AuftragID' => $aNr);
        $this->db->update('stpPicklistItems', $aUpdate, 'ID = ' . $artID);
    }

    /**
     * Zusammenstellen eines Zuschneideauftrags
     * anhand der Artikelnummer des gescannten
     * Stoffs. Anzeige aller Positionen deren Status NICHT 3 (bearbeitet) ist.
     * @return mixed
     */
    public function getAuftrag($artEAN)
    {
        $sql = "SELECT pli.*, DATE_FORMAT(pli.PicklistExpiryDate,'%d.%m.%Y') as expDate,DATE_FORMAT(pli.PicklistCreateDate,'%d.%m.%Y') as createDate FROM stpPicklistItems pli WHERE EanUpc = '{$artEAN}' AND ItemStatus != '3' ORDER BY Qty DESC";
        return $this->db->select($sql);
    }

    /**
     * Setter: Artikelnummer
     * @param $artNr int
     */
    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;
    }
}