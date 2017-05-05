<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Stoff-Zuschnitt
            </div>

            <div class="panel-body">

                <div class="well hidden-print">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>
                                Bearbeiter
                                <?php $aPicker = $this->backend->getAllPicker(); ?>
                                <select name="bearbeiter" class="form-control">
                                    <option value="">Alle</option>
                                    <?php foreach ($aPicker as $sPicker) { ?>
                                        <option value="65"><?php echo utf8_encode($sPicker['vorname'] . ' ' . $sPicker['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </label>

                            <label>Auftragsdatum
                                <input type="date" id="auftragsdatum" name="auftragsdatum" class="form-control"
                                       placeholder="T.M.JJJJ">
                            </label>

                            <button type="submit" class="btn btn-default">
                                Zuschneideaufträge Anzeigen
                            </button>
                        </div>
                    </div>
                </div>
                <?php if (isset($_REQUEST['auftragsdatum']) || isset($_REQUEST['bearbeiter'])) {
                    $zuschneideAuftraege = $this->mAuftrag->getAuftragsInfos($_REQUEST['bearbeiter'], $_REQUEST['auftragsdatum']); ?>
                    <br>
                    <div class="row hidden-print">
                        <div class="col-xs-3 col-sm-1"><b>Datum</b></div>
                        <div class="col-xs-5 col-sm-2"><b>Bearbeiter</b></div>
                        <div class="col-xs-5 col-sm-2"><b>EAN</b></div>
                        <div class="col-xs-2 col-sm-1"><b>Anzahl (m)</b></div>
                        <div class="col-xs-2 col-sm-1"><b>Dauer (Min.)</b></div>
                        <div class="col-xs-2 col-sm-1">
                            <!--
                                                    <button type="button" data-toggle="collapse" data-target="#pnlZuschnittInfo_" class="btn btn-default btn-sm">
                                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Positionen Ein-/Ausblenden
                                                    </button>
                                                    -->
                        </div>
                    </div>

                    <?php
                    foreach ($zuschneideAuftraege as $zAuftrag) {
                        ?>
                        <div class="row tableTr">
                            <div class="col-xs-3 col-sm-1"><?php echo $zAuftrag['datum']; ?></div>
                            <div class="col-xs-5 col-sm-2"><?php echo $zAuftrag['uname']; ?></div>
                            <div class="col-xs-5 col-sm-2"><a
                                        href="<?php echo URL . 'artikelinfo?searchType=ean&artikelnr=' . $zAuftrag['ArtEAN']; ?>"><?php echo $zAuftrag['ArtEAN']; ?></a>
                            </div>
                            <div class="col-xs-2 col-sm-1"><?php echo $zAuftrag['Anzahl']; ?></div>

                            <div class="col-xs-2 col-sm-1"><?php echo number_format(($zAuftrag['dauer'] / 60), 2, ',', ' '); ?></div>
                        </div>


                        <div class="row" id="pnlZuschnittInfo_<?php echo $zAuftrag['ID']; ?>">

                        </div>
                    <?php }
                } else {
                    /*
                        if(sizeof($this->mAuftrag->getAuftragsInfos('',date('Y-m-d'))) > 0){
                        $zuschneideAuftraege = $this->mAuftrag->getAuftragsInfos('',date('Y-m-d'));
                    } else {
                        echo '<div class="alert alert-info">Heute wurden noch keine Stoffe zugeschnitten</div>';
                    }*/

                } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#auftragsdatum1").datepicker({
            dateFormat: "dd.mm.yy"
        });
        $("#format").on("change", function () {
            $("#auftragsdatum1").datepicker("option", "dateFormat", $(this).val());
        });
    });
</script>
