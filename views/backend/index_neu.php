<?php
// Aktualisieren der Pickliste
if (isset($_REQUEST['updPicklist'])) {
    $this->backend->updatePicklist($_REQUEST['picklistID'], $_REQUEST['selPicker']);
}
// Update der Item Fehler
if (isset($_REQUEST['itemFehlerUpdate'])) {
    $this->mPicklist->setItemFehler($_REQUEST['itemID'], '', '', '');
}
// Leeren der Picklisten, Picklistenpositionen etc.
if ($_REQUEST['resetTables']) {
    if ($this->PicklistAdmin->resetTables()) {
        echo '<div class="alert alert-success msgFooter">';
        echo "Tabellen wurden geleert.";
        echo '</div>';

    } else {
        echo '<div class="alert alert-danger msgFooter">';
        echo "Tabellen konnten nicht geleert werden.";
        echo '</div>';
    }
}
?>

<!-- Nav Panel -->
<div class="row">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <form method="post">
                <a class="btn btn-default hidden-print pull-left" href="<?php echo URL . 'backend'; ?>">
                    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Anischt Aktualisieren
                </a>

                <button type="submit" class="btn btn-warning  hidden-print pull-right" name="getPixiBestand" value="1">
                    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Pixi* Bestände prüfen
                </button>

                <button type="submit" name="resetTables" value="1" class="btn btn-info hidden-print"
                        style="float:right; margin-right:1em;">
                    <span class="glyphicon glyphicon-trash"></span>&nbsp;
                    Tabellen leeren
                </button>
            </form>
        </div>
    </div>
</div><!-- ./ NavPanel -->

<!-- Picklisten -->

<div class="row">
    <form name="frmEditPicklist">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="hidden-print">Aktive Picklisten</span>
                    <span class="visible-print">Pickliste</span>
                </div>
                <div class="panel-body">
                    <div class="hidden-print">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-1"><b>Status</b></div>
                            <div class="col-sm-1"><b>Datum</b></div>
                            <div class="col-sm-1"><b>Pickliste</b></div>
                            <div class="col-sm-1"><b>Gesamt</b></div>
                            <div class="col-sm-1"><b>Offen</b></div>
                            <div class="col-sm-2"><b>Kommentar</b></div>
                            <div class="col-sm-2"><b>Picker</b></div>
                            <div class="col-sm-2"><b>Aktion</b></div>
                        </div>
                        <!-- ./ header -->
                    </div>
                </div>
            </div>
        </div>
    </form>

</div><!-- ./ row picklisten -->

<div class="clearfix"></div>

<!-- Fehlerartikel -->
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="panel panel-primary">

        </div>
    </div>
</div><!-- ./ row Fehlerartikel -->

<div class="clearfix"></div>

<!-- Zuschnitt -->
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="panel panel-primary">

        </div>
    </div>
</div><!-- ./ row Zuschnitt -->


