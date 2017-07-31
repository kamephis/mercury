<?php
// Picken
if (isset($_REQUEST['itemPicked'])) {
    $this->Picklist->setItemStatus($_REQUEST['EanUpc'], 'Teamleiter');
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">Artikel mit Fehlern</div>
    <div class="panel-body">
                <?php
                foreach ($this->artikelFehler as $fehlerItem) {
                    ?>
                    <table class="table table-responsive table-striped table-condensed table-bordered">
                        <tr>
                            <td colspan="2"><h4><strong><?php echo utf8_encode($fehlerItem['ItemName']); ?></strong>
                                </h4></td>
                        </tr>

                        <tr>
                            <td colspan="2"><h4>
                                    <strong><code>Lagerplatz: <?php echo $fehlerItem['BinName']; ?></code></strong></h4>
                            </td>
                        </tr>

                        <tr>
                            <td>Art.Nr:</td>
                            <td><?php echo $fehlerItem['ItemNrSuppl']; ?></td>
                        </tr>

                        <tr>
                            <td>EAN</td>
                            <td><?php echo $fehlerItem['EanUpc']; ?></td>
                        </tr>

                        <tr>
                            <td>Pickliste</td>
                            <td><?php echo $fehlerItem['PLIheaderRef']; ?><br></td>
                        </tr>

                        <tr>
                            <td>Best.Menge</td>
                            <td><?php echo $fehlerItem['Qty']; ?></td>
                        </tr>

                        <tr>
                            <td>Fehler</td>
                            <td><?php echo $fehlerItem['ItemFehler']; ?></td>
                        </tr>

                        <tr>
                            <td>Größte verf. Menge</td>
                            <td><?php echo $fehlerItem['ItemFehlbestand']; ?></td>
                        </tr>

                        <td colspan="2">
                            <form method="post" action="<?php echo $_SERVER['php_self']; ?>">
                                <input type="hidden" name="itemPicked" value="1">
                                <input type="hidden" name="EanUpc" value="<?php echo $fehlerItem['EanUpc']; ?>">
                                <input class="btn btn-lg btn-success btn-block" type="submit" id="btnPickItem"
                                       name="btnPickItem" value="Artikel Picken">
                            </form>
                        </td>
                    </table>
                    <br>
                <?php } ?>
    </div>
</div>