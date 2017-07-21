<?php
// Anzahl der Picklistenpositionen aus dem Controller
$anzPositionen = $this->AnzItems;

// Zwischenspeichern der Picklistennummer
$plist = $_REQUEST['picklistNr'];
$_SESSION['plist'] = $plist;

/**
 * Übergabe der Picklistennummer an die getPickListItems zum
 * Abrufen der zugewiesenen Artikel
 * Falls keine Position übergeben wurde auf den Anfang zurückspringen
 */

// Falls eine andere Pickliste aufgerufen wird, dann wird die gleiche POS in dieser Liste verwendet.
if ($_REQUEST['referer']) {
    unset($_SESSION['pos']);
    $_SESSION['pos'] = 0;
}

if (isset($_REQUEST['pos'])) {
    $_SESSION['pos'] = $_REQUEST['pos'];

    if ($_SESSION['pos'] == $anzPositionen || $_SESSION['pos'] > $anzPositionen) {
        $_SESSION['pos'] = 0;
    }
} else {
    if (!isset($_SESSION['pos'])) {
        $_SESSION['pos'] = 0;
    }
}
if ($_SESSION['pos'] < 0) {
    $_SESSION['pos'] = 0;
}

// Picklisten Array
if (!isset($this->Picklist->getApicklist()[$_SESSION['pos']])) {
    $this->Picklist->setAPicklist($this->Picklist->getPicklistItems($_SESSION['plist'], $_SESSION['pos']));
} else {
    echo "Picklist gesetzt";
}
//$picklist = $this->Picklist->getPicklistItems($_SESSION['plist'], $_SESSION['pos']);

// Picklistennavigation
if ($_REQUEST['nav'] == 'n') {
    //next($picklist);
    //$picklist = $this->Picklist->getPicklistItems($_SESSION['plist'], $_SESSION['pos']);
}

if ($_REQUEST['nav'] == 'p') {
    //prev($picklist);
    //$picklist = $this->Picklist->getPicklistItems($_SESSION['plist'], $_SESSION['pos']);
}

// Stoff gepickt - via EAN
if ($_REQUEST['itemPicked']) {
    $this->Picklist->setItemStatus($_REQUEST['itemPicked'], $_SESSION['locationID']);
    // Aktualisieren -> nächste Position - refresh
    header('location: ' . URL . 'picklist?picklistNr=' . $_SESSION['plist'] . '&pos=' . $_SESSION['pos']);

    $this->Picklist->getAPicklist();
    //$picklist = $this->Picklist->getPicklistItems($_SESSION['plist'], $_SESSION['pos']);

}

// Fehler erfasst
if ($_REQUEST['setFehler']) {

    $aFehler = $_REQUEST['fehler'];
    $intFehlbestand = $_REQUEST['ItemFehlbestand'];

    Session::set('fehler', $aFehler);
    Session::set('sItemFehlbestand', $intFehlbestand);

    $fehlerText = '';

// Auslesen des jeweiligen Fehlers aus dem Fehler Array
    if (sizeof($aFehler) == 1) {
        $fehlerText = $aFehler[0];
    }
    if (sizeof($aFehler) == 2) {
        $fehlerText = $aFehler[0] . ', ' . $aFehler[1];
    }
    if (sizeof($aFehler) == 3) {
        $fehlerText = $aFehler[0] . ', ' . $aFehler[1] . ', ' . $aFehler[2];
    }

    $this->Picklist->setItemFehler($_REQUEST['itemID'], utf8_encode($fehlerText), $intFehlbestand);
    // Mit der nächsten Position fortfahren
    header('location: ' . URL . 'picklist?picklistNr=' . $_SESSION['plist'] . '&pos=' . ($_SESSION['pos'] + 1));
}

if ($this->Picklist->getPicklistItemCount($_SESSION['plist']) > 0) {
    //foreach ($picklist as $item) {

    $item = $this->Picklist->getAPicklist()[$_SESSION['pos']];

        // Lagerbestände
        if ($_REQUEST['updPixiBestand'] == 1) {
            $lagerbestand = $this->Pixi->getItemStock($item['EanUpc']);
            $_SESSION['itemLagerbestand'] = $lagerbestand;
        }

        // Pixi Bug Ausgleich
        $img = str_replace("//", "/", $item['PicLinkLarge']);
        $imgUrl = str_replace(":/www", "://www", $img);

        $pickimage = $imgUrl;
    //echo $pickimage;
    //$pickimage = URL . '/out/img/placeholder.jpg';

    //strlen($imgUrl) > 0 ? $pickimage = $imgUrl : $pickimage = URL . '/out/img/placeholder.jpg';
    file_exists($imgUrl) ? $pickimage = $imgUrl : $pickimage = URL . '/out/img/placeholder.jpg';
        ?>

        <div class="well-sm">

            <div class="row">
                <div class="col-xs-9">

                    <div class="row">
                        <div class="col-xs-12 col-md-12 small">
                            <b>Lagerplatz</b>
                        </div>
                        <div class="col-sm-12">
                            <h2 class="pick binColor"
                                style="background: <?php echo $this->binColors['COLOR_' . substr($item['BinName'], -2)]; ?>;"><?php echo $item['BinName']; ?></h2>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-12 col-md-12 small">
                            <b>Artikel</b>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="pick"><?php echo utf8_encode($item['ItemName']); ?></h3>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-12 col-md-12 small">
                            <b>EAN/GTIN</b>
                        </div>
                        <div class="col-sm-12">
                            <h2 class="pick hidden-xs"><?php echo $item['EanUpc']; ?></h2>
                            <h3 class="pick visible-xs"><?php echo $item['EanUpc']; ?></h3>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-12 col-md-12 small">
                            <b>SHOP</b>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <?php echo substr($item['OrderNrExternal'], 0, 3); ?>
                        </div>
                        <div class="clearfix"></div>
                        <small>&nbsp;</small>
                        <div class="col-xs-12 col-md-12 small">
                            <div class="row">
                                <div class="col-xs-6 text-small"><b>Menge</b></div>
                                <div class="col-xs-6 text-small"><b>Lagerbestand</b></div>
                                <div class="col-xs-6">
                                    <h2 class="pick">
                                        <?php
                                        $aPickCnt = $this->Picklist->getItemPickAmount($item['EanUpc'], $_SESSION['plist']);
                                        echo $aPickCnt[0]['pSum'];

                                        if ($aPickCnt[0]['pSum'] > $item['Qty']) {
                                            echo ' <small>(';
                                            $outputString = '';
                                            foreach ($aPickCnt as $itemCnt) {
                                                $outputString .= $itemCnt['Qty'] . ',';
                                            }
                                            echo rtrim($outputString, ',');
                                            echo ')</small>';
                                        }
                                        ?>
                                    </h2></div>
                                <div class="col-xs-6">
                                    <?php
                                    if ($_REQUEST['updPixiBestand']) {
                                        $lagerbestand = $_SESSION['itemLagerbestand'];

                                        echo '<h2 class="pick">';
                                        echo $lagerbestand['PhysicalStock'];
                                        echo '</h2>';
                                    } else { ?>
                                        <form method="post" action="<?php echo URL; ?>picklist">
                                            <input type="hidden" name="updPixiBestand" value="1">
                                            <input type="hidden" name="pos" value="<?php echo $_SESSION['pos']; ?>">
                                            <input type="hidden" name="plist" value="<?php echo $_SESSION['plist']; ?>">
                                            <input type="hidden" name="picklistNr"
                                                   value="<?php echo $_REQUEST['picklistNr']; ?>">
                                            <button type="submit" class="btn btn-warning btn-xs">prüfen</button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $pickimage; ?>"
                                 width="100%" class="img img-responsive img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="fixNav">
                    <div class="row">
                        <div class="navbar navbar-right">
                            <div class="col-xs-12 fixB1">
                                <button type="submit" class="btn btn-danger btn-block btn-lg-touch pull-right"
                                        data-toggle="modal" data-target="#modFehler">
                                    <?php
                                    if (sizeof($this->Picklist->getItemFehler($item['ID'])) > 0) {
                                        echo '<h4><span class="glyphicon glyphicon-info-sign"></span></h4>';
                                    } else {
                                        echo '<span class="glyphicon glyphicon-remove text-glyphicon-lg"></span>';
                                    }
                                    ?>
                                </button>
                            </div>
                            <div class="clearfix"></div>
                            <small>&nbsp;</small>

                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-success btn-block btn-lg-touch pull-right"

                                        data-toggle="modal" data-target="#modPicked">
                                    <span class="glyphicon glyphicon-ok text-glyphicon-lg"></span>
                                </button>
                            </div>
                            <div class="clearfix"></div>

                            <small>&nbsp;</small>
                            <div class="col-xs-12">
                                <form method="post" action="<?php echo URL; ?>picklist">
                                    <input type="hidden" name="nav" value="n">
                                    <input type="hidden" name="pos" value="<?php echo $_SESSION['pos'] + 1; ?>">
                                    <input type="hidden" name="picklistNr"
                                           value="<?php echo $_SESSION['plist']; ?>">
                                    <button type="submit" class="btn btn-default btn-block btn-lg-touch pull-right">
                                        <span class="glyphicon glyphicon-arrow-right text-glyphicon-lg"></span>
                                    </button>
                                </form>
                            </div>
                            <div class="clearfix"></div>

                            <small>&nbsp;</small>
                            <div class="col-xs-12">
                                <form method="post" action="<?php echo URL; ?>picklist">
                                    <input type="hidden" name="nav" value="p">
                                    <input type="hidden" name="pos" value="<?php echo $_SESSION['pos'] - 1; ?>">
                                    <input type="hidden" name="picklistNr"
                                           value="<?php echo $_SESSION['plist']; ?>">

                                    <button type="submit" class="btn btn-default btn-block btn-lg-touch pull-right">
                                        <?php
                                        if ($_SESSION['pos'] == 0) {
                                            ?>
                                            <span class="glyphicon glyphicon-step-backward text-glyphicon-lg"></span>
                                        <?php } else { ?>
                                            <span class="glyphicon glyphicon-arrow-left text-glyphicon-lg"></span>
                                        <?php } ?>
                                    </button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ row -->

            <div id="modFehler" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <form method="post" id="frmFehler" action="<?php echo URL; ?>picklist" class="form-horizontal">
                        <input type="hidden" name="setFehler" value="1">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Fehler melden</h4>
                            </div>
                            <div class="modal-body">
                                <p>Bitte wählen Sie die passende Option:</p>
                                <div class="row">
                                    <div class="col-xs-12">

                                        <div class="col-xs-8">
                                            <label>Größte verf. Menge
                                                <input type="tel" class="form-control" name="ItemFehlbestand"
                                                       id="ItemFehlbestand"
                                                       value="<?php echo $item['ItemFehlbestand']; ?>"
                                                >
                                            </label>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="col-xs-12">
                                            <label>Kommentar

                                                <select multiple name="fehler[]" class="form-control">
                                                    <option value="Fehlbestand" id="optFehlbestand"
                                                        <?php
                                                        if (preg_match('/Fehlbestand/', $item['ItemFehler'])) {
                                                            echo "selected";
                                                        }
                                                        ?>
                                                    >Fehlbestand
                                                    </option>
                                                    <option value="Farbabweichung" id="optFarbabweichung"
                                                        <?php

                                                        if (preg_match('/Farbabweichung/', $item['ItemFehler'])) {
                                                            echo "selected";
                                                        }
                                                        ?>
                                                    >Farbabweichung
                                                    </option>
                                                    <option value="Stoff beschädigt" id="optStoffBeschaedigt"
                                                        <?php
                                                        if (preg_match('/Stoff beschädigt/', $item['ItemFehler'])) {
                                                            echo "selected";
                                                        }
                                                        ?>
                                                    >Stoff beschädigt
                                                    </option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">
                                    Schließen
                                </button>
                                <small>&nbsp;</small>
                                <input type="hidden" name="itemID" value="<?php echo $item['ID']; ?>">
                                <input type="hidden" name="picklistNr" value="<?php echo $_SESSION['plist']; ?>">
                                <button type="submit" class="btn btn-success btn-block btn-lg" id="btnFehler">
                                    Bestätigen
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div id="modPicked" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Pick bestätigen</h4>
                        </div>
                        <div class="modal-body">
                            <h1 class="text-center"><b><?php echo $aPickCnt[0]['pSum']; ?> ME</b></h1>
                            <h2 class="text-center"><b>gepickt?</b></h2>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">NEIN
                            </button>
                            <small>&nbsp;</small>
                            <form method="get" action="<?php echo URL; ?>picklist">
                                <input type="hidden" name="itemPicked" value="<?php echo $item['EanUpc']; ?>">
                                <input type="hidden" name="picklistNr" value="<?php echo $_SESSION['plist']; ?>">
                                <input type="submit" class="btn btn-success btn-block btn-lg" value="JA">
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./ modal test -_>

       <!-- ./ Pickliste -->


        </div>
    <?php /*}*/
} else {
    echo '<div class="alert alert-success">';
    echo '<center><span style="font-size:7em; display:block; margin-bottom:0.3em;" class="icon icon-happy"></span></center>';
    echo '<center><h3><b>Juhuu!</b> Geschafft, diese Pickliste enthält nun keine offenen Positionen mehr.</h3></center>';
    echo '<a href="' . URL . 'picker" class="btn btn-default btn-block" style="padding:1em; font-size:1.2em;">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Zurück zur Übersicht
              </a>';
    echo '</div>';
    echo '<div class="clearfix"></div>';
    echo '</div>';

    // Pickliste als abgeschlossen markieren
    // Nur abschließen, wenn tatsächlich keine offenen Positionen mehr vorhanden sind.
    if ($this->Picklist->getPicklistItemCount($_SESSION['plist']) == 0) {
        $this->Picklist->setPicklistStatus($_SESSION['plist'], '1');
    }
}
?>
<script>
    $(document).ready(function () {
        $("#ItemFehlbestand").on('input', function () {
            $('#optFehlbestand').attr('selected', true);
            console.log("selected...");
        });
    });


    '<div class="loader" style="background:red; color:white; width:250px; height:250px;"><b>Daten werden geladen...</b></div>' +

    $(window).on('load', function () {
        setTimeout(removeLoader, 0);
    });

    function removeLoader() {
        $("#loadingDiv").fadeOut(300, function () {
            $("#loadingDiv").remove();
        });
    }
</script>