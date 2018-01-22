<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Zuschnitt-Auswertung</div>
        <div class="panel-body">
                <form name="frmFilter">
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
                               placeholder="T.M.JJJJ">
                    </label>

                    <button type="submit" class="btn btn-default">
                        Auswertung anzeigen
                    </button>
                </form>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php /* if (isset($_REQUEST['auftragsdatum_zus']) || isset($_REQUEST['bearbeiter_zus'])) {*/
                $zuschneideAuftraege = $this->statistik->getAuftragsInfos($_REQUEST['bearbeiter_zus'], $_REQUEST['auftragsdatum_zus']); ?>

                <table class="table table-responsive table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Bearbeiter</th>
                        <th>EAN</th>
                        <th>Anzahl (m)</th>
                        <th>Dauer (h)</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($zuschneideAuftraege as $zAuftrag) { ?>
                        <tr>
                            <td>
                                        <span style="font-size:0.8em;"
                                              class="glyphicon glyphicon-calendar"></span>
                                <?php echo $zAuftrag['datum']; ?></td>
                            <td><?php echo utf8_encode($zAuftrag['uname']); ?></td>
                            <td><a
                                        href="<?php echo URL . 'artikelinfo?searchType=ean&artikelnr=' . $zAuftrag['ArtEAN']; ?>"><?php echo $zAuftrag['ArtEAN']; ?></a>
                            </td>
                            <td><?php echo $zAuftrag['Menge']; ?></td>
                            <td><?php echo number_format(($zAuftrag['dauer'] / 60), 2, ',', ' '); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php /* }*/ ?>
            </div>
        </div>
    </div>
</div>