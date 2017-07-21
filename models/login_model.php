<?php
/**
 * Steuerung des Benutzerlogins, Prüfung der Zugangsdaten
 * Weiterleitung der Benutzer auf die jeweiligen Bereiche der Software
 *
 * @author: Marlon Böhland
 * @date:   01.12.2016
 * @access: public
 */
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
        $redirectURL = null;

        // Kombinierter String mit Benutzername und Kennwort (Benutzername-Kennwort)
        $userPassword = $_POST['userPasswd'];

        /**        if (isset($userPassword) && strlen($userPassword) > 0 || $_COOKIE['Autologin']) {
            * // Prüfen ob ein Cookie existiert
            * if (isset($_COOKIE['Autologin']) && isset($_COOKIE['User'])) {
                * if (hash('sha256', $_COOKIE['Autologin'])) {
         * // Zugangsdaten sind korrekt
         * // pruefen ob der Benutzer berechtigt ist
         * // Voraussetzung fuer den Zugriff auf das Backend ist ein passendes access_level
                    * $sql = $this->db->prepare("SELECT iUser.UID, iUser.Username, iUser.name, iUser.vorname, iUser.Passwd, iUser.RegDate, iUser.kuerzel, iUser.access_level FROM iUser WHERE Username = '{$username}'");
                    * $sql->execute();
                    * $totalRows = $sql->rowCount();
                    * $result = $sql->fetch(PDO::FETCH_ASSOC);
 *
* // Pruefen ob der Benutzername existiert
                    * if ($totalRows > 0 || ($username == $result['Username'])) {
                        * // Registrierung der Session Werte
                        * Session::set('UID', $result['UID']);
                        * Session::set('vorname', $result['vorname']);
                        * Session::set('name', $result['name']);
 *
* // Rechte in die Session schreiben.
                        * Session::set('access_level', $result['access_level']);
 *
* header('location: ' . URL . $redirectURL);
 *
* } else {
                        * header('location: ' . URL . 'login?msg=e401');
                    * }
                * }
            * }
        * }**/

            // Zerteilen der Benutzerinformatioenn in Benutzername und Kennwort
            $cred        = strtolower($userPassword);
        $userAccount = explode('-', $cred);

        // Benuztername und Kennwort getrennt
            $username = $userAccount[0];
            $password = $userAccount[1];

        /**
         * Setzen der Weiterleitungs-URL (Schritt 2)
         * Je nach Art der Anwendung
         * Via URL-Parameter (Subdomain)
         */
        if (Session::get('redirectUrl')) {
            $redirectURL = Session::get('redirectUrl');
        } else {
            $redirectURL = 'login'; // TODO: evtl. Anzeige einer Meldung
        }

        /**
         * pruefen ob der Benutzer berechtigt ist
         * Voraussetzung fuer den Zugriff auf das Backend ist ein passendes access_level
         */
        $sql = $this->db->prepare("SELECT iUser.UID, iUser.Username, iUser.name, iUser.vorname, iUser.Passwd, iUser.RegDate, iUser.kuerzel, iUser.access_level FROM iUser WHERE Username = '{$username}'");
        $sql->execute();
        $totalRows = $sql->rowCount();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // Pruefen ob der Benutzername existiert
        if ($totalRows > 0 || ($username == $result['Username'])) {
            // Entschlüsselung des Kennworts. Wenn erfolgreich: Registrieren der Session Variablen
            if ($result['Passwd'] == $this->decryptPassword($password, $result['RegDate'])) {

                // Registrierung der Session Werte
                Session::set('UID', $result['UID']);
                Session::set('vorname', $result['vorname']);
                Session::set('name', $result['name']);

                /**
                if (isset($_POST['AutoLogin'])) {
                    // Cookie für 8h setzen
                    // Zugangsdaten verschlüsseln
                    $cryptAuth = hash('sha256', $result['UID'] . '-' . $result['Passwd']);
                    setcookie('Autologin', $cryptAuth, time() + 3600 * 8);
                    setcookie('User', $username, time() + 3600 * 8);

                    //setcookie('Passwd',$result['Passwd'],time()+3600*8);
                }**/

                // Rechte in die Session schreiben.
                Session::set('access_level', $result['access_level']);

                header('location: ' . URL . $redirectURL);
            } else {
                header('location: ' . URL . 'login?msg=e401');
            }
        } else {
            header('location: ' . URL . 'login?msg=e401');
        }
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

    /**
     * Setter: Redirect URL
     * @param $url
     */
    public function setRedirectUrl($url)
    {
        $this->redirectURL = $url;
        Session::set('redirectUrl', $url);
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