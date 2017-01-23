<?php

/**
 * User: Marlon
 * Date: 22.01.2017
 * Time: 22:29
 */
class Login_Model extends Model
{
    private $_dbHost, $_dbUser, $_dbPasswd, $_dbName, $_dbPort;
    /**
     * Login_Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Zugangsdaten DB Intern
        $this->_dbHost = '192.168.200.2';
        $this->_dbName = 'usrdb_stokcgbl5';
        $this->_dbUser = 'stokcgbl5';
        $this->_dbPasswd = 'X$9?2IMalDUU';
        $this->_dbPort = '3307';
    }

    public function authUser()
    {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $targetApp = $_REQUEST['targetApp'];

        /**
         * pruefen ob der Benutzer berechtigt ist
         * Voraussetzung fuer den Zugriff auf das Backend ist mind. ein Eintrag in der Tabelle iRight2iUser
         */
        $dbServer = 'mysql:dbname=' . $this->_dbName . ';host=' . $this->_dbHost . '; port=' . $this->_dbPort . '';
        $dbUser = $this->_dbUser;
        $dbPassword = $this->_dbPasswd;

        // DB Connection
        $pdo = new PDO($dbServer, $dbUser, $dbPassword);

        $sql = $pdo->prepare("SELECT iUser.UID, iUser.Username, iUser.name, iUser.vorname, iUser.Passwd, iUser.RegDate, iUser.kuerzel FROM iUser WHERE Username = '{$username}'");
        $sql->execute();
        $totalRows = $sql->rowCount();
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        // Zuweisung der Rows
        $userID = $result['UID'];
        $vorname = $result['vorname'];
        $name = $result['name'];

        // Pruefen ob der Benutzername existiert
        if ($totalRows > 0 || ($username == $result['Username'])) {
            // Entschlüsselung des Kennworts. Wenn erfolgreich: Registrieren der Session Variablen
            if ($result['Passwd'] == $this->decryptPassword($password, $result['RegDate'])) {

                // Registrieren der Session Variablen fuer den User

                @session_start();
                $_SESSION['userName'] = $username;
                $_SESSION['userID'] = $userID;
                $_SESSION['vorname'] = $vorname;
                $_SESSION['name'] = $name;

                /**
                 * Array mit den Benutzerrechten erzeugen und in die Session speichern
                 */
                $queryRights = $pdo->prepare("SELECT UID, RID FROM iRight2iUser WHERE UID = {$_SESSION['userID']}");
                $queryRights->execute();
                $arrayRights = array();

                while ($rowRights = $queryRights->fetch(PDO::FETCH_ASSOC)) {
                    $arrayRights[] = $rowRights['RID'];
                }
                $_SESSION['rights'] = $arrayRights;

                $_SESSION['targetApp'] = $targetApp;
                echo $_SESSION['targetApp'];

                // Weiterleitung zur Startseite der Anwendung
                // TODO: Pfade auslagern
                if (isset($_SESSION['targetApp'])) {
                    switch ($_SESSION['targetApp']) {
                        case 'ab':
                            header('location: /zuschnitt');
                            //header("Location: http://dev.stoffpalette.com/pixiPickprozess/zuschnitt");
                            break;

                        case 'pick':
                            header("Location: /picker");
                            break;
                    }
                }
            } else {
                header("Location: http://dev.stoffpalette.com/pixiPickprozess/?e=401");
            }
        } else {
            header("Location: http://dev.stoffpalette.com/pixiPickprozess/?e=401");
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
     * @param $username
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