<?php

class Pixi
{
    private $oProxy;

    public function __construct()
    {
        require_once('nusoap.php');
        $oSoapClient = new nusoap_client(PIXI_WSDL_PATH, true);
        $oSoapClient->soap_defencoding = 'UTF-8';
        $oSoapClient->decode_utf8 = false;
        $oSoapClient->setCredentials(PIXI_USERNAME, PIXI_PASSWORD);

        // pixi* API Objekt erzeugen
        $this->oProxy = $oSoapClient->getProxy();
    }

    public function getAllPicklists()
    {
        $aPicklists = $this->oProxy->pixiShippingGetPicklistHeaders(array('LocID' => '001'));
        $aPicklists = $aPicklists['pixiShippingGetPicklistHeadersResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aPicklists;
    }

    function getItemStock($artNr)
    {
        $itemStock = $this->oProxy->pixiGetItemStock(array('ItemNrInt' => $artNr));
        $itemStock = $itemStock['pixiGetItemStockResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $itemStock;
    }

    function getOrderHeader($orderNr)
    {
        $aOrderHeader = $this->oProxy->pixiGetOrderHeader(array('OrderNr' => $orderNr));
        $aOrderHeader = $aOrderHeader['pixiGetOrderHeaderResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aOrderHeader;
    }

    function getPicklistDetails($picklistID)
    {
        $stock = $this->oProxy->pixiShippingGetPicklistDetails(array('PicklistKey' => $picklistID, 'FilterBinGroup' => '060 Standard', 'FilterLocation' => '001'));
        $stock = $stock['pixiShippingGetPicklistDetailsResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
        return $stock;
    }
}