<!-- fehlerartikel -->

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $this->tFehler; ?></div>
            <div class="panel-body">
                <?php
                if (sizeof($this->backend->getFehlerhafteArtikel()) > 0) {
                    ?>
                    <div class="row hidden-print">
                        <div class="col-xs-1">
                            <b>Lagerplatz</b>
                        </div>
                        <div class="col-xs-2">
                            <b>Artikelbezeichnung</b>
                        </div>
                        <div class="col-xs-1">
                            <b>Artikelnr.</b>
                        </div>
                        <div class="col-xs-1">
                            <b>EAN</b>
                        </div>
                        <div class="col-xs-2">
                            <b>Artikelfehler</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Max.verf. Bestand</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Pixi-Bestand</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Pixi-Pickliste</b>
                        </div>

                        <!--<div class="col-xs-1">
                            <b>Picker</b>
                        </div>-->
                        <div class="col-xs-1">
                            <b>Aktion</b>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <br>
                    <?php
                    $aFehlerArtikel = $this->backend->getFehlerhafteArtikel();

                    foreach ($aFehlerArtikel as $fArtikel) {
                        ?>

                        <div class="row tableTr">
                            <div class="col-sm-1">
                                <?php echo utf8_encode($fArtikel['BinName']); ?>
                            </div>
                            <div class="col-sm-2">
                                <?php echo utf8_encode($fArtikel['ItemName']); ?>
                            </div>
                            <div class="col-sm-1">
                                <?php echo utf8_encode($fArtikel['ItemNrSuppl']); ?>
                            </div>
                            <div class="col-sm-1">
                                <?php echo $fArtikel['EanUpc']; ?>
                                <div class="visible-print-block">
                                    <img
                                            src="libs/Barcode_org.php?text=<?php echo $fArtikel['EanUpc']; ?>&size=60&orientation=horizontal&codetype=code128">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <?php echo $fArtikel['ItemFehler']; ?>
                            </div>
                            <div class="col-sm-1">
                                <?php echo $fArtikel['ItemFehlbestand']; ?>
                            </div>
                            <div class="col-sm-1">
                                <?php
                                $pixiLagerbestand = $this->Pixi->getItemStock($fArtikel['EanUpc']);
                                echo $pixiLagerbestand['PhysicalStock'];
                                ?>
                            </div>

                            <div class="col-sm-1">
                                <?php
                                echo $fArtikel['PLIheaderRef'];
                                ?>
                            </div>

                            <!--<div class="col-sm-1">
                                <?php /*echo $fArtikel['vorname'];?> <?php echo $fArtikel['name'];*/
                            ?>
                            </div>-->
                            <div class="col-sm-1">
                                <form method="post">
                                    <input type="hidden" name="itemFehlerUpdate" value="1">
                                    <input type="hidden" name="itemID" value="<?php echo $fArtikel['ID']; ?>">

                                    <button type="submit" class="btn btn-danger btn-xs hidden-print">
                                        <span class="glyphicon glyphicon-remove"></span> l&ouml;schen
                                    </button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
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