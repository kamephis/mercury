<?php
if (!isset($_REQUEST['auftragsdatum_zus'])) {
    $setDate = date("Y-m-d");
} else {
    $setDate = $_REQUEST['auftragsdatum_zus'];
}
?>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Zuschnitt-Auswertung</div>
        <div class="panel-body">
            <form name="frmFilter" method="post">
                <?php $aPicker = $this->back->getAllPicker(); ?>
                <label>Mitarbeiter
                    <select name="bearbeiter_zus" class="form-control">
                        <option value="">Alle</option>
                        <?php foreach ($aPicker as $sPicker) { ?>
                            <option value="<?php echo $sPicker['UID'] ?>"><?php echo $sPicker['vorname'] . ' ' . $sPicker['name']; ?></option>
                        <?php } ?>
                    </select>
                </label>

                <label>Auftragsdatum
                    <input type="date" id="auftragsdatum_zus" name="auftragsdatum_zus" class="form-control"
                           placeholder="T.M.JJJJ" value="<?php echo $setDate; ?>">
                </label>

                <!--
                <label>EAN
                    <input type="text" name="artEan">
                </label>
                -->
                <button type="submit" class="btn btn-default">
                    Auswertung anzeigen
                </button>
            </form>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_POST['auftragsdatum_zus']) || isset($_POST['bearbeiter_zus'])) {
                    $zuschneideAuftraege = $this->statistik->getAuftragsInfos($_POST['bearbeiter_zus'], $_POST['auftragsdatum_zus'], null); ?>

                    <table class="table table-responsive table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Bearbeiter</th>
                            <!--<th>EAN</th>-->
                            <th>Anzahl (m)</th>
                            <th>Dauer</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($zuschneideAuftraege as $zAuftrag) { ?>
                            <tr>
                                <td>
                                        <span style="font-size:0.8em;"
                                              class="glyphicon glyphicon-calendar"></span>
                                    <?php echo $zAuftrag['datum']; ?>
                                </td>
                                <td>
                                    <span title="<?php echo $zAuftrag['UserID'] ?>"><?php echo utf8_encode($zAuftrag['uname']); ?></span>
                                </td>
                                <!--<td><a
                                        href="<?php echo URL . 'artikelinfo?searchType=ean&artikelnr=' . $zAuftrag['ArtEAN']; ?>"><?php echo $zAuftrag['ArtEAN']; ?></a>
                            </td>-->
                                <td><?php echo $zAuftrag['Menge']; ?></td>
                                <td><i class="glyphicon glyphicon-time"></i> <?php echo $zAuftrag['dauer']; ?></td>
                                <td>
                                    <center>
                                        <button data-toggle="collapse" class="btnGetStatistikDetails"
                                                data-id="<?php echo $zAuftrag['UserID']; ?>"
                                                data-auftragsDatum="<?php echo $zAuftrag['datum']; ?>"
                                                data-target="#det_<?php echo $zAuftrag['UserID']; ?>" type="button"
                                                name="btnDetails_<?php echo $zAuftrag['UserID']; ?>">
                                            <i class="glyphicon glyphicon-plus-sign"></i>
                                        </button>
                                    </center>
                                </td>
                            </tr>

                            <tr id="det_<?php echo $zAuftrag['UserID']; ?>" class="collapse">
                                <td colspan="5">
                                    <table class="table table-bordered table-striped table-responsive">
                                        <tr>
                                            <?php if ($_POST['getPixiDetails']) { ?>
                                                <th>Art.</th>
                                            <?php } ?>
                                            <th>EAN</th>
                                            <th>Menge</th>
                                            <th>Dauer</th>
                                            <!--<th>Pixi</th>-->
                                        </tr>

                                        <?php
                                        $auftragDetails = $this->statistik->getAuftragInfoUngruppiert($zAuftrag['UserID'], $_POST['auftragsdatum_zus']);

                                        foreach ($auftragDetails as $detail) {
                                            echo "<tr>";
                                            if ($_POST['getPixiDetails']) {
                                                $pixi = $this->Pixi->getItemInfo($detail['ArtEAN']);

                                                echo "<td>";
                                                echo $pixi['ItemName'];
                                                echo "</td>";
                                            }

                                            echo "<td>";
                                            echo $detail['ArtEAN'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $detail['Menge'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $detail['dauer'];
                                            echo "</td>";
                                            /*
                                                                                    echo "<td>";
                                                                                    echo "<form>";
                                                                                    echo '<input type="hidden" name="ean" value="'.$detail['ArtEAN'].'">';
                                                                                    echo '<button type="submit" name="getPixiDetails" value="Pixi">';
                                                                                    echo 'Pixi';
                                                                                    echo '</button>';
                                                                                    echo "</form>";
                                                                                    echo "</td>";
                                             */

                                            echo "</tr>";
                                            ?>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>