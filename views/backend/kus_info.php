<!-- Kundenservice Info -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
<span class="hidden-print">
                <button type="button" class="btn btn-xs btn-primary pull-right" id="btnToggleFehlerArea">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
</span>
                <span class="panel-title"><?php echo $this->tFehler; ?></span>
            </div>
            <div class="panel-body" id="pnlFehler">
                <?php
                if (sizeof($this->backend->getFehlerhafteArtikel()) > 0) {
                    ?>

                    <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th>
                                <center>#</center>
                            </th>
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
                                Max. verf.<br>Menge
                            </th>

                            <th>
                                Best.<br class="visible-print">Menge<br>Gesamt
                            </th>
                            <th class="alert-warning">
                                <strong>
                                    Pixi-<br>Bestand
                                </strong>
                            </th>
                            <th class="alert-warning">
                                <strong>
                                    Pixi-<br>Pickliste
                                </strong>
                            </th>

                            <th>
                                <span class="hidden-print">Bearbeiter(in)</span>
                                <span class="visible-print">Bearb.</span>
                            </th>
                            <th>
                                <span class="hidden-print">Geprüft</span>
                                <span class="visible-print">Gep.</span>
                            </th>
                            <th class="hidden-print">
                                Aktion
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $cntRow = 0;
                        $aFehlerArtikel = $this->backend->getFehlerhafteArtikel();
                        foreach ($aFehlerArtikel as $fArtikel) {
                            $cntRow++;
                            ?>
                            <tr id="rowError_<?php echo $fArtikel['ID']; ?>">
                                <td>
                                    <center><?php echo $cntRow; ?></center>
                                </td>
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
                                    <center>
                                        <?php
                                        echo $fArtikel['BestMenge'];
                                        ?>
                                    </center>
                                </td>
                                <td class="alert-warning">
                                <span class="text-pixi">
                                <center>
                                    <?php
                                    // aktivieren falls onDemand Abfrage gewünscht
                                    //if ($_REQUEST['getPixiBestand']) {
                                    if ($this->Pixi->getItemStock($fArtikel['EanUpc'])) {
                                        $pBestand = $this->Pixi->getItemStock($fArtikel['EanUpc']);
                                        echo $pBestand['PhysicalStock'];
                                    } else {
                                        echo 'k. A.';
                                    }
                                    //} else {
                                    //    echo '---';
                                    //}
                                    ?>

                                    <?php
                                    ?></center></span>
                                </td>
                                <td class="alert-warning">
                                <span class="text-pixi">
                                <?php
                                echo $fArtikel['PLIheaderRef'];
                                ?>
                                    </span>
                                </td>


                                <td>
                                    <?php
                                    echo utf8_encode($fArtikel['ItemFehlerUser']);
                                    ?>
                                </td>

                                <td>
                                    <center>
                                        <form method="post" id="frmChk" name="frmChk">
                                            <?php if ($fArtikel['geprueft'] == '1') {
                                                $bChecked = 'checked';
                                            } else {
                                                $bChecked = '';
                                            }
                                            ?>
                                            <input type="hidden" name="itemCheckUpdate" value="1">
                                            <input type="hidden" name="itemID" value="<?php echo $fArtikel['ID']; ?>">
                                            <input type="hidden" value="<?php echo $_SESSION['name']; ?>"
                                                   name="setUser">

                                            <input type="checkbox" class="chkFehler"
                                                   name="chkFehler_<?php echo $fArtikel['ID']; ?>"
                                                   id="chkFehler_<?php echo $fArtikel['ID']; ?>" <?php echo $bChecked; ?>
                                                   value="<?php echo $fArtikel['EanUpc']; ?>">
                                        </form>
                                    </center>
                                </td>
                                <td class="hidden-print">
                                    <form method="post" id="frmDelete">
                                        <input type="hidden" name="itemFehlerUpdate" value="1">
                                        <input type="hidden" name="itemID" value="<?php echo $fArtikel['ID']; ?>">
                                        <!--
                                    <button type="button"
                                        class="btn btn-warning btn-xs hidden-print btn-block btnEscalate"
                                        id="btnEscalate_<?php echo $fArtikel['ID']; ?>"
                                        data-escalateID="<?php echo $fArtikel['ID']; ?>">
                                        <i class="glyphicon glyphicon-info-sign"></i> eskaliert
                                    </button>
-->
                                        <button type="button"
                                                class="btn btn-danger btn-xs hidden-print btn-block btnDelError"
                                                id="btnError_<?php echo $fArtikel['ID']; ?>"
                                                data-id="<?php echo $fArtikel['ID']; ?>">
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