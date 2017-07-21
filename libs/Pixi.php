<?php

/**
 * Gemeinsam nutzbare Pixi Funktionen
 * Zugriff auf Pixidaten via PIXI NuSoap API
 *
 * @author: Marlon Böhland
 * @access: public
 * @date: 14.10.2016
 */
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

    function getItemStock($artEAN)
    {
        $itemStock = $this->oProxy->pixiGetItemStock(array('EAN' => $artEAN));
        if (isset($itemStock['pixiGetItemStockResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'])) {
            $itemStock = $itemStock['pixiGetItemStockResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
            return $itemStock;
        } else {
            return false;
        }
    }
    function getOrderHeader($orderNr)
    {
        $aOrderHeader = $this->oProxy->pixiGetOrderHeader(array('OrderNrExternal' => $orderNr));
        $aOrderHeader = $aOrderHeader['pixiGetOrderHeaderResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

        return $aOrderHeader;
    }

    function getOrderLine($orderLineKey)
    {
        $aOrderline = $this->oProxy->pixiGetOrderline(array('OrderlineKey' => $orderLineKey));
        if (isset($aOrderline['pixiGetOrderlineResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'])) {
            $aOrderline = $aOrderline['pixiGetOrderlineResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
            return $aOrderline;
        } else {
            return false;
        }

    }
    function getPicklistDetails($picklistID)
    {
        $stock = $this->oProxy->pixiShippingGetPicklistDetails(array('PicklistKey' => $picklistID, 'FilterBinGroup' => '060 Standard', 'FilterLocation' => '001'));
        $stock = $stock['pixiShippingGetPicklistDetailsResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
        return $stock;
    }

    function getItemInfo($ean, $ItemNrSuppl)
    {
        $stock = $this->oProxy->pixiGetItemInfo(array('EANUPC' => $ean, 'ItemNrSuppl' => $ItemNrSuppl));

        if (isset($stock['pixiGetItemInfoResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'])) {
            $stock = $stock['pixiGetItemInfoResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];
            $itemInfo = $this->oProxy->pixiGetItemStockBins(array('EAN' => $ean, 'ItemNrSuppl' => $ItemNrSuppl));
            $itemInfo = $itemInfo['pixiGetItemStockBinsResult']['SqlRowSet']['diffgram']['SqlRowSet1']['row'];

            $aItemInfo = array('ItemInfo' => $itemInfo);

            return array_merge($stock, $aItemInfo);
        } else {
            return "Keine Einträge gefunden.";
        }

    }
}