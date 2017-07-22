<?php
// Fehler löschen
if (isset($_REQUEST['resetFehler'])) {
    $this->ArtikelFehlerMobile->removeArtikelFromFehlerliste($_REQUEST['resetFehler']);
}

// Picken
if (isset($_REQUEST['pickItem'])) {
    $this->ArtikelFehlerMobile->pickItem($_REQUEST['resetFehler']);
}

?>
<div class="panel panel-primary">
    <div class="panel-heading">Artikel mit Fehlern</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-condensed table-bordered">
                    <?php
                    foreach ($this->artikelFehler as $fehlerItem) {
                        ?>
                        <tr>
                            <td>
                                <b><?php echo utf8_encode($fehlerItem['ItemName']); ?></b><br>
                                Art.Nr: <?php echo $fehlerItem['ItemNrSuppl']; ?><br>
                                EAN: <?php echo $fehlerItem['EanUpc']; ?><br>
                                Pickliste: <?php echo $fehlerItem['PLIheaderRef']; ?><br>
                                Lagerplatz: <?php echo $fehlerItem['BinName']; ?><br>
                                Best.Menge: <?php echo $fehlerItem['Qty']; ?><br>
                                Fehler: <?php echo $fehlerItem['ItemFehler']; ?><br>
                                Größte verf. Menge: <?php echo $fehlerItem['ItemFehlbestand']; ?>
                            </td>
                        <tr>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['php_self']; ?>">
                                    <input type="hidden" name="resetFehler" value="<?php echo $fehlerItem['ID']; ?>">
                                    <input class="btn btn-lg btn-default btn-block" type="submit" id="btnResetFehler"
                                           name="btnResetFehler" value="Artikel korrigiert">
                                </form>
                                <br>
                                <form method="post" action="<?php echo $_SERVER['php_self']; ?>">
                                    <input type="hidden" name="pickItem" value="<?php echo $fehlerItem['ID']; ?>">
                                    <input class="btn btn-lg btn-success btn-block" type="submit" id="btnPickItem"
                                           name="btnResetFehler" value="Artikel Picken">
                                </form>
                            </td>
                        </tr>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').append('<div style="background:black;" id="loadingDiv">' +
        '<div class="loader" style="background:red; color:white; width:250px; height:250px;"><b>Daten werden geladen...</b></div>' +
        '</div>');
    $(window).on('load', function () {
        setTimeout(removeLoader, 0);
    });
    function removeLoader() {
        $("#loadingDiv").fadeOut(350, function () {
            $("#loadingDiv").remove();
        });
    }
</script>