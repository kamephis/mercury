<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-primary">
            <div class="panel-heading">
    <span class="hidden-print">
        Aktive Picklisten
    </span>
                <span class="visible-print">
            Pickliste
        </span>
            </div>
            <div class="panel-body">
                <div class="hidden-print">
                    <?php if (sizeof($this->backend->getActivePicklists()) > 0) { ?>
                        <div class="row">
                            <div class="col-sm-1"><b>Status</b></div>
                            <div class="col-sm-1"><b>Datum</b></div>
                            <div class="col-sm-1"><b>Pickliste</b></div>
                            <div class="col-sm-1"><b>Gesamt</b></div>
                            <div class="col-sm-1"><b>Offen</b></div>
                            <div class="col-sm-2"><b>Kommentar</b></div>
                            <div class="col-sm-2"><b>Picker</b></div>
                            <div class="col-sm-3"><b>Aktion</b></div>
                        </div>

                        <br>
                        <?php
                        $aActivePicklists = $this->backend->getActivePicklists();
                        foreach ($aActivePicklists as $picklist) {

                            ?>


                            <form name="selNewPicker" method="post">
                                <div class="row">

                                    <?php
                                    $plStatus = $this->backend->getPicklistStatusProzent($picklist['PLHkey']);
                                    ?>
                                    <div class="col-sm-1 hidden-print">
                                        <div class="progress">
                                            <?php
                                            $barClass = 0;

                                            switch ($plStatus) {
                                                case $plStatus < 33;
                                                    $barClass = 'progress-bar-danger';
                                                    break;

                                                case $plStatus > 33 && $plStatus < 100;
                                                    $barClass = 'progress-bar-warning';
                                                    break;

                                                case $plStatus = 100;
                                                    $barClass = 'progress-bar-success';
                                                    break;
                                            }
                                            ?>

                                            <div class="progress-bar <?php echo $barClass; ?>" role="progressbar"
                                                 aria-valuenow="<?php echo $plStatus; ?>"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width:<?php echo $plStatus; ?>%">
                                                <?php echo $plStatus; ?>%
                                                <?php if ($plStatus == 100) echo '&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>'; ?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <?php
                                        $datum = date("d.m.Y", strToTime($picklist['createDate']));
                                        echo $datum;
                                        ?>
                                    </div>

                                    <div class="col-sm-1"><?php echo $picklist['PLHkey']; ?></div>

                                    <div class="col-sm-1"><?php echo $this->mPicklist->getGroessePicklist($picklist['PLHkey']); ?></div>

                                    <div class="col-sm-1"><?php echo $this->mPicklist->getRealPicklistItemCount($picklist['PLHkey']); ?></div>

                                    <div class="col-sm-2"><?php echo $picklist['PLcomment']; ?></div>

                                    <div class="col-sm-2">

                                        <select name="selPicker"
                                                class="form-control" <?php if ($picklist['status'] == '1') {
                                            echo "DISABLED";
                                        } ?>>
                                            <?php
                                            $aPicker = $this->backend->getAllPicker();
                                            foreach ($aPicker as $picker) {
                                                ?>
                                                <option
                                                    <?php
                                                    if ($picker['UID'] == $picklist['picker']) echo 'SELECTED';
                                                    ?>
                                                        value="<?php echo $picker['UID']; ?>"><?php echo utf8_encode($picker['vorname']) . ' ' . utf8_encode($picker['name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="col-sm-3 hidden-print">

                                        <input type="hidden" name="updPicklist" value="1">
                                        <input type="hidden" name="pickerID" value="<?php echo $picklist['picker']; ?>">
                                        <input type="hidden" name="picklistID"
                                               value="<?php echo $picklist['PLHkey']; ?>">

                                        <button type="button" data-toggle="collapse"
                                                data-target="#pnlPicklistArticles_<?php echo $picklist['PLHkey']; ?>"
                                                class="btn btn-default btn-sm btnToggleItems">
                                            <span class="glyphicon glyphicon-eye-open btnToggleIco"></span>&nbsp;Positionen
                                            Ein-/Ausblenden
                                        </button>

                                        <?php if ($picklist['status'] == 0) { ?>
                                            <button type="submit" class="btn btn-primary btn-sm" name="updPicklist"
                                                    value="1">
                                                <span class="glyphicon glyphicon-floppy-save"></span>&nbsp;Speichern
                                            </button>
                                        <?php } ?>

                                        <?php
                                        $statusCheck = 0;
                                        if ($this->backend->getPicklistItems($picklist['PLHkey'])) {
                                            $aPicklistItemsStatusCheck = $this->backend->getPicklistItems($picklist['PLHkey']);

                                            foreach ($aPicklistItemsStatusCheck as $statusItem) {
                                                if ($statusItem['ItemStatus'] > 1) {
                                                    $statusCheck++;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if ($statusCheck == 0) { ?>
                                            <button type="submit" class="btn btn-danger btn-sm" name="delPicklist"
                                                    value="1" data-toggle="modal" data-target="#modDelPickItem">
                                                <span class="glyphicon glyphicon-trash"></span>&nbsp;Löschen
                                            </button>
                                        <?php } ?>
                                    </div>
                                    <br>
                                </div>
                            </form>

                            <!-- Modal Bestätigung -->
                            <!--
                            <div id="modDelPickItem" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header alert-danger">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Picklistenposition löschen</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="resetTab" class="btn btn-success" value="Position löschen">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

-->
                            <div class="row collapse visble-print"
                                 id="pnlPicklistArticles_<?php echo $picklist['PLHkey']; ?>" style="margin-bottom:4em;">
                                <br>
                                <div class="well well-sm hidden-print">
                                    <button type="button" class="btn btn-default btn-sm btnPrint"
                                            id="btn_<?php echo $picklist['PLHkey']; ?>" data-toggle="collapse"
                                            data-target="#pnlPicklistArticles_<?php echo $picklist['PLHkey']; ?>">
                                        <span class="glyphicon glyphicon-print"></span>&nbsp;Drucken
                                    </button>
                                </div>

                                <table class="table table-striped table-bordered table-condensed table-responsive">
                                    <thead>
                                    <tr>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>Art.Nr</th>
                                        <th>EAN</th>
                                        <th>
                                            <center>Menge</center>
                                        </th>
                                        <th>Bezeichnung</th>
                                        <th>Gepickt auf</th>
                                        <th>Aktualisiert am</th>
                                        <th>Lagerplatz</th>
                                        <th>Pixi Pickliste</th>
                                        <th>Pixi Bestand</th>
                                        <th>Aktion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $aPicklistItems = $this->backend->getPicklistItems($picklist['PLHkey']);
                                    foreach ($aPicklistItems as $pItem) {
                                        ?>
                                        <tr>
                                            <td>
                                                <center>
                                                    <?php
                                                    switch ($pItem['ItemStatus']) {
                                                        case '0':
                                                            echo '--';
                                                            break;
                                                        case '1':
                                                            echo '<b><span class="glyphicon glyphicon-ban-circle text-danger" style="font-size:110%;" title="offen"></span></b>';
                                                            break;
                                                        case '2':
                                                            echo '<b><span class="glyphicon glyphicon-ok-circle text-success" style="font-size:110%;" title="gepickt"></span></b>';
                                                            break;
                                                        case '3':
                                                            echo '<b><span class="glyphicon glyphicon-scissors" style="font-size:110%;" title="zugeschnitten"></span></b>';
                                                            break;

                                                    }
                                                    ?></center>
                                            </td>
                                            <td><?php echo $pItem['ItemNrSuppl']; ?></td>
                                            <td><?php echo $pItem['EanUpc']; ?>
                                                <span class="visible-print">
                                     <img src="libs/Barcode_org.php?text=<?php echo $pItem['EanUpc']; ?>&size=60&orientation=horizontal&codetype=code128">
                                </span>
                                            </td>
                                            <td>
                                                <center><?php echo $pItem['Qty']; ?></center>
                                            </td>
                                            <td><?php echo utf8_encode($pItem['ItemName']); ?></td>
                                            <td><?php echo $pItem['CurrentItemLocation']; ?></td>
                                            <!-- Pickzeitpunkt -->
                                            <td>
                                                <span style="font-size:0.8em;"
                                                      class="glyphicon glyphicon-calendar"></span>&nbsp;<?php echo date("d.m.Y", strtotime($pItem['TimestampUpdateStatus'])); ?>
                                                <span style="font-size:0.8em; margin-left:2em;"
                                                      class="glyphicon glyphicon-time"></span>&nbsp;<?php echo date("H:i", strtotime($pItem['TimestampUpdateStatus'])); ?>
                                                Uhr

                                            </td>
                                            <td><?php echo $pItem['BinName']; ?></td>
                                            <td><?php echo $pItem['PLIheaderRef']; ?></td>
                                            <td><?php
                                                if ($_REQUEST['getPixiBestand']) {
                                                    if ($this->Pixi->getItemStock($pItem['EanUpc'])) {
                                                        $pBestand = $this->Pixi->getItemStock($pItem['EanUpc']);
                                                        echo $pBestand['PhysicalStock'];
                                                    } else {
                                                        echo 'k.A.';
                                                    }
                                                } else {
                                                    echo "--";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($pItem['ItemStatus'] <= 1) { ?>
                                                    <form method="post">
                                                        <input type="hidden" name="delPicklistItem"
                                                               value="<?php echo $pItem['ID'] ?>">
                                                        <button type="submit" name="btnDelItem"
                                                                class="btn btn-xs btn-danger">
                                                            <span class="glyphicon glyphicon-trash"></span> Löschen
                                                        </button>
                                                    </form>
                                                <?php } ?>

                                            </td>
                                            <!--<td><?php echo $pItem['ItemStatus']; ?></td>-->
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <div class="well well-sm">
                                    <span class="glyphicon glyphicon-ban-circle"></span> offen&nbsp;&nbsp;<span
                                            class="glyphicon glyphicon-ok-circle"></span> gepickt&nbsp;&nbsp;<span
                                            class="glyphicon glyphicon-scissors"></span> zugeschnitten
                                </div>
                            </div>
                            <!-- end picklistitems -->
                            <br>
                        <?php } ?>

                    <?php } else {
                        echo '<div class="alert alert-info">';
                        echo 'Derzeit sind keine Picklisten aktiv.';
                        echo '</div>';
                    } ?>
                </div><!-- ./ pnl primary -->
            </div>
        </div>
