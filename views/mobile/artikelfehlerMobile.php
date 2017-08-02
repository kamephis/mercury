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
                        <tr>
                        <td colspan="2">
                            <button class="btn btn-lg btn-success btn-block pickItem" type="button"
                                    id="btnPickItem_<?php echo $fehlerItem['ID']; ?>"
                                    data-id="<?php echo $fehlerItem['ID']; ?>"
                                    name="btnPickItem_<?php echo $fehlerItem['ID']; ?>">Artikel Picken
                            </button>
                        </td>
                        </tr>
                    </table>
                    <br>
                <?php } ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".pickItem").on("click", function () {

            var artID = $(this).data("id");
            var itemStatus = '2';
            $.ajax({
                type: "POST",
                url: "index.php?url=setItemStatusFehler",
                data: {"articleID": artID, "ItemStatus": itemStatus},
                dataType: "json",
                success: function (data) {
                    if (data.success === true) {
                        setTimeout(function () {
                            location.reload();
                        }, 0);
                    }
                }
            });
            location.reload();
        });
    })
</script>