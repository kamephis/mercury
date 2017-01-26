<?php

class Login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        // Session starten
        Session::init();

        $artNr = null;
        $username = null;
        $password = null;
        $targetApp = null;

        // Zerteilen der Benutzerinformatioenn in Benutzername und Kennwort
        if ($_POST['userPasswd'] && strlen($_POST['userPasswd']) > 0) {
            $userAccount = explode('|', $_POST['userPasswd']);
            $username = $userAccount[0];
            $password = $userAccount[1];
        }

        /**
         * pruefen ob der Benutzer berechtigt ist
         * Voraussetzung fuer den Zugriff auf das Backend ist mind. ein Eintrag in der Tabelle iRight2iUser
         */
        $sql = $this->db->prepare("SELECT iUser.UID, iUser.Username, iUser.name, iUser.vorname, iUser.Passwd, iUser.RegDate, iUser.kuerzel FROM iUser WHERE Username = '{$username}'");
        $sql->execute();
        $totalRows = $sql->rowCount();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // Zuweisung der Rows
        Session::set('UID', $result['UID']);
        Session::set('vorname', $result['vorname']);
        Session::set('name', $result['name']);

        // Pruefen ob der Benutzername existiert
        if ($totalRows > 0 || ($username == $result['Username'])) {
            // Entschlüsselung des Kennworts. Wenn erfolgreich: Registrieren der Session Variablen
            if ($result['Passwd'] == $this->decryptPassword($password, $result['RegDate'])) {
                /**
                 * Array mit den Benutzerrechten erzeugen und in die Session speichern
                 */
                $queryRights = $this->db->prepare("SELECT UID, RID FROM iRight2iUser WHERE UID = {$_SESSION['userID']}");
                $queryRights->execute();
                $arrayRights = array();

                while ($rowRights = $queryRights->fetch(PDO::FETCH_ASSOC)) {
                    $arrayRights[] = $rowRights['RID'];
                }
                Session::set('rights', $arrayRights);

                header('location: ' . URL . 'auftrag');
            }
        } else {
            header('location: ' . URL . 'error');
        }
    }

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        $myDate = new MyDateTime();

        // Aktueller Timestamp wird beim Aufruf der Funktion eingelesen und
        // dann als Salt-Value in der Session Variablen regDate gespeichert.
        // Auf diese wird dann in der registerNewUser zugegriffen.

        $timeStamp = $myDate->getTimestamp();
        $sid = session_id();

        if (isset($sid)) {
            $_SESSION['regDate'] = $timeStamp;
        } else {
            echo "Es ist keine Session aktiv!";
        }

        return hash('sha256', $password . $timeStamp);
    }

    /**
     * @param $password
     * @param $regDate
     * @return string
     */
    public function decryptPassword($password, $regDate)
    {
        // Pruefung des eingegebenen Kennworts auf dessen Richtigkeit
        $decrypt = hash('sha256', $password . $regDate);
        return $decrypt;
    }
}

/**
 * Class MyDateTime
 */
class MyDateTime extends DateTime
{
    public function setTimestamp($timestamp)
    {
        $date = getdate(( int )$timestamp);
        $this->setDate($date['year'], $date['mon'], $date['mday']);
        $this->setTime($date['hours'], $date['minutes'], $date['seconds']);
    }

    public function getTimestamp()
    {
        return $this->format('U');
    }
}