<?php
// Übergabe via Barcode
$auftrag = $this->auftrag->getAuftrag('10603480');
//$pixiBestand = $this->auftrag->getPixiBestand($auftrag[0]['EanUpc']);
$bestand = $this->auftrag->getPixiBestand($auftrag[0]['ItemNrInt']);

//var_dump($this->Pixi->getAllPicklists());
?>

<!-- Top Bar -->
<div class="row text-mobile-large">
            <div class="col-sm-2"><img
                    src="<?php echo $auftrag[0]['PicLinkLarge']; ?>"
                    width="100%"
                    class="img img-responsive img-square img-thumbnail">
            </div>

    <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-4"><b>Artikel:</b></div>
                    <div class="col-sm-8"><?php echo $auftrag[0]['ItemName']; ?></div>

                    <div class="col-sm-4"><b>Art.Nr:</b></div>
                    <div class="col-sm-8"><?php echo $auftrag[0]['ItemNrInt']; ?></div>

                    <!-- <div class="col-sm-4"><b>Anz.Art:</b></div>
                    <div class="col-sm-8"><?php echo $auftrag[0]['anzItems']; ?></div>-->
                </div>
            </div>

    <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-4"><b>EAN</b></div>
                        <div class="col-sm-8"><?php echo $auftrag[0]['EanUpc']; ?></div>

                        <div class="col-sm-4"><b>Lager</b></div>
                        <div class="col-sm-8"><?php echo $auftrag[0]['BinName']; ?></div>

                        <div class="col-sm-4"><b>Bestand</b></div>
                        <div class="col-sm-8"><?php echo $bestand; ?></div>
                    </div>
                </div>
    <div class="col-sm-2">
        <p><b>Auftrag 16895</b></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
                    <button type="submit" class="btn btn-lg btn-default btn-block" style="margin-bottom:5px;">
                        <span class="glyphicon glyphicon-remove"></span> Abbrechen
                    </button>
                </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
            <button type="submit" class="btn btn-info btn-lg btn-block">
                <span class="glyphicon glyphicon-ok"></span> Abschließen
                    </button>
                </form>
            </div>
</div>
<!-- ./ Top Bar -->
<br><br>
<!-- Auftragspositionen / Header -->
<div class="row text-mobile-large">
    <div class="col-sm-1 text-left"><b>#</b></div>
    <div class="col-sm-7 text-left"><b>Info</b></div>
    <div class="col-sm-1"><b>Anzahl</b></div>
    <div class="col-sm-3 text-left"><b></b></div>
</div>

<!-- Auftragspositionen -->

<?php
$rows = 0;
foreach ($auftrag as $item) {
    $rows++;
    ?>
<div class="row row-table default-state">
    <div class="col-sm-1"><?php echo $rows; ?></div>

    <div class="col-sm-7">
        Pickliste: <?php echo $item['PLIheaderRef']; ?> | Expires: <?php echo $item['expDate']; ?> <br>
        Pickliste erstellt am: <?php echo $item['createDate']; ?>

    </div>

    <div class="col-sm-1"><?php echo $item['Qty']; ?> m</div>

    <div class="col-sm-3">
        <button type="submit" class="btn btn-danger btn-lg-square pull-right" style="margin-left:10px;">
            <span class="glyphicon glyphicon-remove text-glyphicon-lg"></span>
            </button>

        <button type="submit" class="btn btn-success btn-lg-square pull-right">
            <span class="glyphicon glyphicon-ok text-glyphicon-lg"></span>
            </button>
    </div>
</div>

<?php } ?>




<!-- ./ Auftragspositionen -->


<!-- modal test -->

<div id="modFehler" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fehlbestand melden</h4>
            </div>
            <div class="modal-body">
                <p>Bitte wählen Sie die passende Option:</p>
                <div class="row">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ?>" class="form-horizontal">
                        <div class="well-sm">
                            <div class="checkbox">
                                <label><input type="checkbox" value="">Fehlmenge</label>
                            </div>

                            <div class="checkbox">
                                <label><input type="checkbox" value="">Artikel defekt</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">Schließen
                </button>
                <button type="button" class="btn btn-success btn-block btn-lg" data-dismiss="modal">Bestätigen
                </button>
            </div>
        </div>

    </div>
</div>
<!-- ./ modal test -_>


   <!-- modal test -->

<div id="modPicked" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pick bestätigen</h4>
            </div>
            <div class="modal-body">
                <h1 class="text-center"><b>3 m</b></h1>
                <h2 class="text-center"><b>gepickt?</b></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">NEIN</button>
                <button type="button" class="btn btn-success btn-block btn-lg" data-dismiss="modal">JA</button>
            </div>
        </div>

    </div>
</div>
<!-- ./ modal test -_>

