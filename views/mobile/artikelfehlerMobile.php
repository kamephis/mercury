<?php
// Picken
if (isset($_REQUEST['itemPicked'])) {
    $this->Picklist->setItemStatus($_REQUEST['EanUpc'], '');
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
                                    <input type="hidden" name="itemPicked" value="1">
                                    <input type="hidden" name="EanUpc" value="<?php echo $fehlerItem['EanUpc']; ?>">
                                    <input class="btn btn-lg btn-success btn-block" type="submit" id="btnPickItem"
                                           name="btnPickItem" value="Artikel Picken">
                                </form>
                            </td>
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