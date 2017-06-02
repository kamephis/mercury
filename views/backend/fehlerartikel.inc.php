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
                    <div class="row">
                        <div class="col-xs-1">
                            <b>Lagerplatz</b>
                        </div>
                        <div class="col-xs-2 col-sm-2">
                            <b>Artikelbez.</b>
                        </div>
                        <div class="col-xs-1">
                            <b>Artikelnr.</b>
                        </div>
                        <div class="col-xs-3 col-sm-1 hidden-print">
                            <b>EAN</b>
                        </div>
                        <div class="col-xs-3 col-sm-3 visible-print">
                            <b>EAN</b>
                        </div>
                        <div class="col-xs-1 col-sm-1">
                            <b>Artikelfehler</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Max.verf. <br class="visible-print">Bestand</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Pixi-Pickliste</b>
                        </div>

                        <div class="col-xs-1">
                            <b>Pixi <br class="visible-print">Bestand</b>
                        </div>

                        <!--<div class="col-xs-1">
                            <b>Picker</b>
                        </div>-->
                        <div class="col-xs-1 hidden-print">
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
                            <div class="col-xs-1 col-sm-1">
                                <?php echo utf8_encode($fArtikel['BinName']); ?>
                            </div>

                            <div class="col-xs-2 col-sm-2">
                                <?php echo utf8_encode($fArtikel['ItemName']); ?>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <?php echo utf8_encode($fArtikel['ItemNrSuppl']); ?>
                            </div>

                            <div class="col-xs-4 col-sm-1 hidden-print">
                                <?php echo $fArtikel['EanUpc']; ?>
                            </div>

                            <div class="col-xs-3 col-sm-3 visible-print">
                                <div class="visible-print-block" style="width:100%;">
                                    <img src="libs/Barcode_org.php?text=<?php echo $fArtikel['EanUpc']; ?>&size=60&orientation=horizontal&codetype=code128"
                                         style="width:7cm!important;">
                                </div>
                                <?php echo $fArtikel['EanUpc']; ?>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <?php echo $fArtikel['ItemFehler']; ?>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <?php echo $fArtikel['ItemFehlbestand']; ?>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <?php
                                echo $fArtikel['PLIheaderRef'];
                                ?>
                            </div>

                            <div class="col-xs-1 col-sm-1">
                                <?php
                                $pixiLagerbestand = $this->Pixi->getItemStock($fArtikel['EanUpc']);
                                echo $pixiLagerbestand['PhysicalStock'];
                                ?>
                            </div>

                            <!--<div class="col-sm-1">
                                <?php /*echo $fArtikel['vorname'];?> <?php echo $fArtikel['name'];*/
                            ?>
                            </div>-->
                            <div class="col-sm-1 hidden-print">
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