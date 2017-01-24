<div class="well-sm">
    <div class="row">
        <div class="col-xs-9">
            <div class="row">
                <div class="col-xs-12 col-md-12 small">
                    <b>Lagerplatz</b>
                </div>
                <div class="col-sm-12">
                    <h1 class="pick binColor">H1-C-01</h1>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-12 small">
                    <b>Artikel</b>
                </div>
                <div class="col-sm-12">
                    <h3 class="pick">Universalstoff - Love</h3>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-12 small">
                    <b>EAN/GTIN</b>
                </div>
                <div class="col-sm-12">
                    <h2 class="pick hidden-xs">012345678910121</h2>
                    <h3 class="pick visible-xs">012345678910121</h3>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-12 small">
                    <div class="row">
                        <div class="col-xs-6 text-small"><b>Menge</b></div>
                        <div class="col-xs-6 text-small"><b>Lagerbestand</b></div>
                        <div class="col-xs-6"><h2 class="pick">3,0 m</h2></div>
                        <div class="col-xs-6"><h2 class="pick">46 m</h2></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="https://www.stoff4you.de/out/pictures/master/product/2/fn1094-love-universalstoff_z2.jpg"
                         width="100%" class="img img-responsive">
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="fixNav">
                <div class="row">
                    <div class="navbar navbar-right">
                        <div class="col-xs-12 fixB1">
                            <button type="submit" class="btn btn-danger btn-block btn-lg-touch pull-right"
                                    data-toggle="modal" data-target="#modFehler">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <small>&nbsp;</small>

                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success btn-block btn-lg-touch pull-right"

                                    data-toggle="modal" data-target="#modPicked">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </div>
                        <div class="clearfix"></div>

                        <small>&nbsp;</small>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-default btn-block btn-lg-touch pull-right"
                                    data-toggle="modal"
                                    data-target="#nextDataset">
                                <span class="glyphicon glyphicon-arrow-right"></span>
                            </button>
                        </div>
                        <div class="clearfix"></div>

                        <small>&nbsp;</small>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-default btn-block btn-lg-touch pull-right"

                                    data-toggle="modal" data-target="#nextDataset">
                                <span class="glyphicon glyphicon-arrow-left"></span>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./ row -->


        <!-- modal test -->

        <div id="modFehler" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Fehlbestand melden</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bitte wählen Sie die passende Option:</p>
                        <div class="row">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ?>" class="form-horizontal">
                                <div class="well-sm">
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="">Fehlmenge</label>
                                    </div>

                                    <div class="checkbox">
                                        <label><input type="checkbox" value="">Artikel defekt</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">Schließen
                        </button>
                        <button type="button" class="btn btn-success btn-block btn-lg" data-dismiss="modal">Bestätigen
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./ modal test -_>


           <!-- modal test -->

        <div id="modPicked" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pick bestätigen</h4>
                    </div>
                    <div class="modal-body">
                        <h1 class="text-center"><b>3 m</b></h1>
                        <h2 class="text-center"><b>gepickt?</b></h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">NEIN
                        </button>
                        <button type="button" class="btn btn-success btn-block btn-lg" data-dismiss="modal">JA</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- ./ modal test -_>

       <!-- ./ Pickliste -->
    </div>