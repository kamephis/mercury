<?php if (isset($_SESSION['userName'])) { ?>

    <!-- Navigation -->
    <div class="panel col-xs-12 col-md-12 col-md-offset-0" id="request">
        <div class="panel panel-primary" style="margin-top:30px;">
            <div class="panel-header"></div>

            <div class="panel-body">
                <div style="float-left;"><b><h2>Auftragsbearbeitung</h2></b></div>
                <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#modAbschließen">
                    <span class="glyphicon glyphicon-check"></span> Abschließen
                    </p></button>

                <button class="btn btn-danger pull-right" data-toogle="modal" data-target="#modBeenden">
                    <span class="glyphicon glyphicon-ban-circle"></span> Beenden
                    </p></button>

                <button class="btn btn-primary pull-right" data-toogle="modal" data-target="#modAbmelden">
                    <span class="glyphicon glyphicon-off"></span> Abmelden
                    </p></button>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>

    <!-- Artikelinformationen -->
    <div class="panel panel-primary" style="margin-top:5px;">

        <div class="panel-header">
            <div class="col-sm-4 col-md-4">
                <br>
                <img alt="Stoffpalette" src="Stoff3.jpeg">
            </div>

            <div class="col-sm-4 col-md-4">
                <br>
                <ul class="list-group">
                    <li class="list-group-item">EAN-Artikel</li>
                    <li class="list-group-item">Artikelnummer</li>
                    <li class="list-group-item">Lagerplatz</li>
                    <li class="list-group-item">Stoffbezeichnung</li>
                    <li class="list-group-item">Stofffarbe</li>
                </ul>
            </div>

            <div class="col-sm-4 col-md-4"></div>
        </div>

        <div class="panel-body"></div>
        <div class="panel-footer"></div>
    </div>

    <!-- Meteranzahl / Position  -->
    <div class="panel panel-primary" style="margin-top:5px;">
        <div class="panel col-xs-12 col-md-12 col-md-offset-0">
            <div class="panel-header"></div>
            <div class="panel-body">
                <div class="row">

                    <!-- Informationen -->
                    <div class="col-sm-8">
                        <br>
                        <div class="well well-sm">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Informationen</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>PIC-EAN</td>
                                </tr>
                                <tr>
                                    <td>Auftragsnummer</td>
                                </tr>
                                <tr>
                                    <td>Meteranzahl</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Button  (p= Button Größer machen)-->
                    <div class="col-sm-4">
                        <br>
                        <button class="btn btn-success btn-block pull-right" data-toogle="modal"
                                data-target="#modBearbeiten">
                            <span class="glyphicon glyphicon-ok"></span> Bearbeiten
                            </p></button>

                        <button class="btn btn-danger btn-block pull-right" data-toogle="modal"
                                data-target="#modNichtBearbeiten">
                            <span class="glyphicon glyphicon-remove"></span> Nicht Bearbeitbar
                            </p></button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- eNDE Seiteninhalte -->
    </div>

    <!-- Modals start -->

    <!-- Modal Auftrag abschließen -->
    <div id="modAbschließen" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Auftrag abschließen</h4>
                </div>
                <div class="modal-body">
                    <p>Wollen Sie den Auftrag abschließen?</p>
                </div>
                <div class="modal-footer">
                    <p>
                        <button type="button" class="btn btn-default">Abbrechen</button>
                        <button type="button" class="btn btn-warning">Auftrag abschließen</button>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Beenden -->
    <div id="modBeenden" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Beenden</h4>
                </div>
                <div class="modal-body">
                    <p>Wollen Sie die Bearbeitung beenden?</p>
                </div>
                <div class="modal-footer">
                    <p>
                        <button type="button" class="btn btn-default">Abbrechen</button>
                        <button type="button" class="btn btn-danger">Beenden</button>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Abmelden -->
    <div id="modAbmelden" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Abmdelden</h4>
                </div>
                <div class="modal-body">
                    <p>Wollen Sie sich Abmelden?</p>
                </div>
                <div class="modal-footer">
                    <p>
                        <button type="button" class="btn btn-default">Abbrechen</button>
                        <button type="button" class="btn btn-primary">Abmelden</button>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Bearbeiten-->
    <div id="modBearbeiten" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bearbeiten</h4>
                </div>
                <div class="modal-body">
                    <p>Wurde der Stoff bearbeitet?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Bearbeitet</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nicht Bearbeitbar-->
    <div id="modNichtBearbeitbar" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nicht Bearbeitbar</h4>
                </div>
                <div class="modal-body">
                    <p>Der Stoff konnte nicht bearbeitet werden.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Nicht Bearbeitbar</button>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo 'Zugriff verweigert!';
} ?>
