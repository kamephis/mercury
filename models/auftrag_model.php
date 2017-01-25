<?php

class Auftrag_Model extends Model
{
    //private $oProxy;

    public function __construct()
    {
        parent::__construct();
        /* require_once(PATH_NUSOAP);
         $oSoapClient = new nusoap_client(PIXI_WSDL_PATH, true);
         $oSoapClient->soap_defencoding = 'UTF-8';
         $oSoapClient->decode_utf8 = false;
         $oSoapClient->setCredentials(PIXI_USERNAME, PIXI_PASSWORD);
 
         // pixi* API Objekt erzeugen
         $this->oProxy = $oSoapClient->getProxy();*/
    }

    public function getAuftrag($artNr)
    {
        $sql = "SELECT pli.*, COUNT(*) as anzItems, DATE_FORMAT(pli.PicklistExpiryDate,'%d.%m.%Y') as expDate,DATE_FORMAT(pli.PicklistCreateDate,'%d.%m.%Y') as createDate FROM stpPicklistItems pli WHERE ItemNrInt = '{$artNr}' ORDER BY Qty ASC";
        return $this->db->select($sql);
    }

    public function getPixiBestand($ean)
    {
        $itemStock = $this->oProxy->pixiGetItemStock(array('EAN' => $ean));
        $itemStock = $itemStock['pixiGetItemStockResults']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
        return $itemStock;
    }

    // Setter
    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;
    }
}