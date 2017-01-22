<?php

/**
 * Deutsche Sprachdatei
 * Date: 10.12.2016
 * Time: 12:17
 */
class StpLang
{
    public $sLang;
    public $aText;
    private $aAvailableLanguages = array('de_DE', 'en_EN');

    /**
     * stpLang constructor.
     * @param $lang
     */
    public function __construct($lang)
    {
        $this->sLang = $lang;
        $this->loadLangFile($lang);
    }

    public function setLanguage($lang)
    {
        if (in_array($lang, $this->aAvailableLanguages)) {
            $this->sLang = $lang;
        } else {
            echo "Sprache nicht verfügbar";
        }
    }

    private function loadLangFile($lang)
    {
        $langFile = LANG_PATH . $lang . 'index.php';
        try {
            if (file_exists($langFile)) {
                require_once($langFile);
                // setting the language array
                $this->aText = $appText;
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * @return mixed
     */
    public function getSLang()
    {
        return $this->sLang;
    }
}

