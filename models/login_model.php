<?php

/**
 * Login Model
 * User: Marlon
 * Date: 22.07.2017
 * Time: 23:50
 */
class Login_Model extends Model
{

    private $_sUsername = null;
    private $_sPassword = null;
    private $_sTargetApp = null;
    private $_sRedirectURL = null;

    /**
     * login2 constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    // Login
    public function run()
    {
        $this->checkAuth($_POST['userPasswd']);
    }

    private function checkAuth($sUserAccount)
    {
        $sUserAccount = explode('-', $sUserAccount);
        $sUserName = strtolower($sUserAccount[0]); // Unterstützung der Anwender, falls Groß/Kleinschreibung verwendet wird
        $password = $sUserAccount[1];

        /**
         * pruefen ob der Benutzer berechtigt ist
         * Voraussetzung fuer den Zugriff auf das Backend ist ein passendes access_level
         */
        $sql = $this->db->prepare("SELECT iUser.UID, iUser.Username, iUser.name, iUser.vorname, iUser.Passwd, iUser.RegDate, iUser.kuerzel, iUser.access_level FROM iUser WHERE Username = :sUserName");

        // Pruefen ob der Benutzername existiert
        $sql->execute(array('sUserName' => $sUserName));
        $totalRows = $sql->rowCount();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // Entschlüsselung des Kennworts. Wenn erfolgreich: Registrieren der Session Variablen
        if ($result['Passwd'] == $this->decryptPassword($password, $result['RegDate']) && $totalRows > 0) {

            Session::init();
                // Registrierung der Session Werte
                Session::set('UID', $result['UID']);
                Session::set('vorname', $result['vorname']);
                Session::set('name', $result['name']);

                // Rechte in die Session schreiben.
                Session::set('access_level', $result['access_level']);

            // Prüfung erfolgreich -> Weiterleitung an die jeweilige Zielseite
            $this->redirect2TargetLocation();
            echo "<script>location.replace('" . $this->getSRedirectURL() . "');</script>";
            } else {
            // Zugriff verweigert
            echo "<script>location.replace('" . $this->getSRedirectURL() . "/error');</script>";
            }
    }

    private function redirect2TargetLocation()
    {
        // Auslesen der Subdomain (Parameter für Weiterleitung)
        $hostUrl = explode('.', $_SERVER['HTTP_HOST']);
        $sSubdomain = $hostUrl[0];

        $sUrl = "http://" . $sSubdomain . ".stoffpalette.com/";

        switch ($sSubdomain) {
            case 'pick':
                $this->setSRedirectURL($sUrl . 'scanLocation');
                break;
            case 'mercury':
                $this->setSRedirectURL($sUrl . 'backend');
                break;
            case 'zuschnitt':
                $this->setSRedirectURL($sUrl . 'scanArt');
                break;
        }
        $_SESSION['redirectUrl'] = $this->getSRedirectURL();
    }

    /**
     * Erzeugen eines verschlüsselten Kennworts
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        $myDate = new MyDateTime();
        /**
         * Aktueller Timestamp wird beim Aufruf der Funktion eingelesen und
         * dann als Salt-Value in der Session Variablen regDate gespeichert.
         */
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
     * Entschlüsseln des übergebenen Kennworts zur Prüfung
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

    /******************************************************
     * Setter / Getter
     *****************************************************/

    /**
     * @return null
     */
    public function getSUsername()
    {
        return $this->_sUsername;
    }

    /**
     * @param null $sUsername
     */
    public function setSUsername($sUsername)
    {
        $this->_sUsername = $sUsername;
    }

    /**
     * @return null
     */
    public function getSPassword()
    {
        return $this->_sPassword;
    }

    /**
     * @param null $sPassword
     */
    public function setSPassword($sPassword)
    {
        $this->_sPassword = $sPassword;
    }

    /**
     * @return null
     */
    public function getSTargetApp()
    {
        return $this->_sTargetApp;
    }

    /**
     * @param null $sTargetApp
     */
    public function setSTargetApp($sTargetApp)
    {
        $this->_sTargetApp = $sTargetApp;
    }

    /**
     * @return null
     */
    public function getSRedirectURL()
    {
        return $this->_sRedirectURL;
    }

    /**
     * @param null $sRedirectURL
     */
    public function setSRedirectURL($sRedirectURL)
    {
        $this->_sRedirectURL = $sRedirectURL;
    }
}

/**
 * Class MyDateTime
 *
 * Datumsfunktionen
 * User: Marlon Böhland
 * Date:
 */
class MyDateTime extends DateTime
{
    public function setTimestamp($timestamp)
    {
        $date = getdate(( int )$timestamp);
        $this->setDate($date['year'], $date['mon'], $date['mday']);
        $this->setTime($date['hours'], $date['minutes'], $date['seconds']);
    }

    /**
     * Getter: Timestamp
     * @return string
     */
    public function getTimestamp()
    {
        return $this->format('U');
    }
}