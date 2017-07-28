<!-- fehlerartikel -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="panel-title"><?php echo $this->tFehler; ?></span>
            </div>
            <div class="panel-body">
                <?php
                if (sizeof($this->backend->getFehlerhafteArtikel()) > 0) {
                    ?>

                    <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th>
                                Lagerplatz
                            </th>
                            <th>
                                Artikelbez.
                            </th>
                            <th>
                                Artikelnr.
                            </th>
                            <th>
                                EAN
                            </th>
                            <th>
                                Fehlertext
                            </th>
                            <th>
                                Max. verf.<br>Bestand
                            </th>
                            <th>
                                Pixi-<br>Pickliste
                            </th>
                            <th>
                                Pixi-<br>Bestand
                            </th>
                            <th>
                                Bearbeiter(in)
                            </th>
                            <th>
                                Geprüft
                            </th>
                            <th class="hidden-print">
                                Aktion
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                    <?php
                    $aFehlerArtikel = $this->backend->getFehlerhafteArtikel();
                    foreach ($aFehlerArtikel as $fArtikel) {
                        ?>
                        <tr>
                            <td>
                                <?php echo utf8_encode($fArtikel['BinName']); ?>
                            </td>
                            <td>
                                <?php echo utf8_encode($fArtikel['ItemName']); ?>
                            </td>
                            <td>
                                <?php echo utf8_encode($fArtikel['ItemNrSuppl']); ?>
                            </td>
                            <td class="hidden-print">
                                <?php echo $fArtikel['EanUpc']; ?>
                            </td>
                            <td class="visible-print-block">
                                    <img src="libs/Barcode_org.php?text=<?php echo $fArtikel['EanUpc']; ?>&size=60&orientation=horizontal&codetype=code128"
                                         style="width:7cm!important;">
                                <?php echo $fArtikel['EanUpc']; ?>
                            </td>
                            <td>
                                <?php echo $fArtikel['ItemFehler']; ?>
                            </td>
                            <td>
                                <center>
                                <?php echo $fArtikel['ItemFehlbestand']; ?>
                                </center>
                            </td>
                            <td>
                                <?php
                                echo $fArtikel['PLIheaderRef'];
                                ?>
                            </td>
                            <td>
                                <center>
                                <?php
                                $pixiLagerbestand = $this->Pixi->getItemStock($fArtikel['EanUpc']);
                                echo $pixiLagerbestand['PhysicalStock'];
                                ?></center>
                            </td>
                            <td>
                                <?php
                                echo utf8_encode($fArtikel['ItemFehlerUser']);
                                ?>
                            </td>

                            <td>
                                <!--<center>
                                    <form method="post" id="frmChk">
                                        <?php if ((bool)isset($fArtikel['geprueft']) == true) {
                                    $bChecked = 'checked';
                                } ?>
                                        <input type="hidden" name="itemCheckUpdate" value="1" <?php echo $fArtikel['geprueft']; ?>>
                                        <input type="hidden" name="itemID" value="<?php echo $fArtikel['ID']; ?>">
                                        <input type="hidden" value="<?php echo $_SESSION['name']; ?>" name="setUser">

                                        <input type="checkbox" name="chkFehler" id="chkFehler" <?php echo $bChecked; ?>>
                                    </form>
                                </center>-->
                            </td>
                            <td class="hidden-print">
                                <form method="post" id="frmDelete">
                                    <input type="hidden" name="itemFehlerUpdate" value="1">
                                    <input type="hidden" name="itemID" value="<?php echo $fArtikel['ID']; ?>">
                                    <button type="submit" class="btn btn-danger btn-xs hidden-print">
                                        <span class="glyphicon glyphicon-remove"></span> l&ouml;schen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                        </tbody>
                    </table>

                <?php } else {
                    echo '<div class="alert alert-info">';
                    echo 'Es wurden noch keine Fehlerhaften Artikel gemeldet.';
                    echo '</div>';
                } ?>
            </div>
        </div>
    </div>
</div><!-- ./row-->
<div class="clearfix"></div>

<script>
    $("#chkFehler").on("click", function () {
        $("#frmChk").submit();
    })
</script>