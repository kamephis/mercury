<?php
// Aktualisieren der Pickliste
if (isset($_REQUEST['updPicklist'])) {
    $this->backend->updatePicklist($_REQUEST['picklistID'], $_REQUEST['selPicker']);
}
// Update der Item Fehler
if (isset($_REQUEST['itemFehlerUpdate'])) {
    $this->mPicklist->setItemFehler($_REQUEST['itemID'], NULL, NULL);
}
// Leeren der Picklisten, Picklistenpositionen etc.
if ($_REQUEST['resetTab']) {
    if ($this->PicklistAdmin->resetTables()) {
        echo '<div class="alert alert-success msgFooter">';
        echo "Die Mercury Tabellen wurden erfolgreich geleert.";
        echo '</div>';

    } else {
        echo '<div class="alert alert-danger msgFooter">';
        echo "Die Mercury Tabellen konnten nicht geleert werden. Bitte benachrichtigen Sie die Technik.";
        echo '</div>';
    }
}

// Löschen einer Pickliste
if ($_REQUEST['delPicklist']) {
    try {
        $this->backend->delPicklist($_REQUEST['picklistID']);
    } catch (Exception $e) {
        echo $e;
    }
    }
?>

<form method="post" id="frmOptions">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-default hidden-print pull-left" href="<?php echo URL . 'backend'; ?>">
                <span class="glyphicon glyphicon-refresh"></span>&nbsp;Anischt aktualisieren
            </a>
            &nbsp;
            <button type="button" class="btn btn-default btnPrint hidden-print">
                <span class="glyphicon glyphicon-print"></span>&nbsp;Fehlerliste drucken
            </button>

            <button type="submit" class="btn btn-warning  hidden-print pull-right" name="getPixiBestand" value="1">
                <span class="glyphicon glyphicon-refresh"></span>&nbsp;Pixi* Bestände prüfen
            </button>

            <button type="button" data-toggle="modal" data-target="#modResetTab" class="btn btn-info hidden-print"
                    style="float:right; margin-right:1em;">
                <span class="glyphicon glyphicon-trash"></span>&nbsp;
                Tabellen leeren
            </button>

            <div class="clearfix"></div>
            <br>
        </div>
    </div>

    <!-- Reset Table Modal -->

    <div id="modResetTab" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tabellen leeren</h4>
                </div>
                <div class="modal-body">
                    <p><b>ACHTUNG:</b> Alle <b>importierten</b> Pixi-Picklisten-Positionen, Stoff Palette-Picklisten und
                        alle erfassten Fehlerartikel werden gelöscht.</p>
                    <p><b>Dieser Vorgang kann nicht rückgängig gemacht werden.</b> Bitte stellen Sie auch sicher, dass
                        alle Fehlerartikel bearbeitet wurden.</p>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="resetTab" class="btn btn-success" value="Tabellen leeren">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>
</form>
<div class="countdown hidden-print">

</div>

<?php include("picklisten.inc.php"); ?>
<?php include("fehlerartikel.inc.php"); ?>
<?php include("zuschnitt.inc.php"); ?>

<script>
    $(document).ready(function () {
        $.fn.countdown = function (callback, duration, message) {
            // Wenn keine Nachricht übergeben...
            message = message || "";

            var container = $(this[0]).html('');
            //var container = $(this[0]).html(duration + message);

            var countdown = setInterval(function () {
                //container.html("Test Session: " + duration + message);

                if (--duration) {
                    // 5 Minuten zuvor warnen
                    if (duration < 1140) {
                        container.addClass('alert alert-danger');

                        $('html body').animate({"backgroundColor": "#b1040f"}, 1500);
                        container.html('<b>Mercury wird in ' + (duration / 60).toFixed(2) + ' Minuten aktualisiert.</b>');
                    }
                } else {
                    container.html('<b>Bitte warten, Mercury wird aktualisiert...</b>');
                    clearInterval(countdown);
                    callback.call(container);
                }
            }, 1000);
        };

        $(".countdown").countdown(redirect, 1440, "");

        function redirect() {
            window.location = "http://mercury.stoffpalette.com/backend";
        }

        $(".btnPrint").on("click", function () {
            window.print();
        });
    });
</script>