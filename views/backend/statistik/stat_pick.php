<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            <?php
            $jsonPickedLists = $this->statistik->getPickStatistik($_REQUEST['bearbeiter'], $_REQUEST['auftragsdatum']);
            ?>
            ['Task', 'Hours per Day'],
            <?php foreach ($jsonPickedLists as $jPick) { ?>
            ['<?php echo utf8_encode($jPick['picker']); ?>', <?php echo $jPick['menge']; ?>],
            <?php } ?>
        ]);

        var options = {
            title: 'Verhältnis Picker / Picks Gesamt'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>

<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">Picker-Auswertung</div>
        <div class="panel-body">
            <div id="piechart" style="width: 800px; height: 350px;"></div>

            <form name="frmFilter">
                <?php $aPicker = $this->back->getAllPicker(); ?>
                <label>Mitarbeiter
                    <select name="bearbeiter" class="form-control">
                        <option value="">Alle</option>
                        <?php foreach ($aPicker as $sPicker) { ?>
                            <option value="<?php echo $sPicker['UID'] ?>"><?php echo $sPicker['vorname'] . ' ' . $sPicker['name']; ?></option>
                        <?php } ?>
                    </select>
                </label>

                <label>Auftragsdatum
                    <input type="date" id="auftragsdatum" name="auftragsdatum" class="form-control"
                           placeholder="T.M.JJJJ">
                </label>

                <button type="submit" class="btn btn-default">
                    Auswertung anzeigen
                </button>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <?php if (isset($_REQUEST['auftragsdatum']) || isset($_REQUEST['bearbeiter'])) {
                        $aPickedLists = $this->statistik->getPickStatistik($_REQUEST['bearbeiter'], $_REQUEST['auftragsdatum']); ?>
                        <table class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Bearbeiter</th>
                                <th>Picks</th>
                                <th>Dauer (Minuten)</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($aPickedLists as $pickedList) { ?>
                                <tr>
                                    <td>
                                        <span style="font-size:0.8em;"
                                              class="glyphicon glyphicon-calendar"></span>
                                        <?php echo $pickedList['datum']; ?></td>
                                    <td><?php echo utf8_encode($pickedList['picker']); ?></td>
                                    <td><?php echo $pickedList['menge']; ?></td>
                                    <td><?php echo number_format($pickedList['dauer'] / 60, 2); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>