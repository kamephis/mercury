<?php if (isset($_SESSION['userName'])) { ?>
    <br><br>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-4">
            <img src="out/img/logo_600.jpg" class="img img-responsive">
            <br>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-7 col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Position 1/4</div>

                <div class="panel-body">
                    <div class="col-xs-12 col-md-4">
                        <img
                            src="https://www.stoff4you.de/out/pictures/master/product/1/terra_allround_s4_1000_z1(1).jpg"
                            class="img img-responsive img-thumbnail">
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <span class="text-large"><strong>Artikel:</strong></span>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-10">
                                <span class="text-large">Universal Stoff Weihnachten Terra</span>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <span class="text-large"><strong>Anzahl:</strong></span>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-10">
                                <span class="text-large">5 Stk.</span>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-xs-12 col-sm-6 col-md-2">
                                <span class="text-large"><strong>Länge:</strong></span>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-10">
                                <span class="text-large">0,50 m</span>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                            <div class="row">
                                <div class="col-xs-4 col-md-2">
                                    <form name="auftragFertig"
                                          action="http://dev.stoffpalette.com/pixiPickprozess/finishOrder">
                                        <button type="button"
                                                class="btn btn-lg btn-default btn-touch-xs pull-right form-contol">
                                            <span class="glyphicon glyphicon-ban-circle"></span>
                                        </button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                                <div class="col-xs-4 col-md-2">
                                    <form name="auftragFertig"
                                          action="http://dev.stoffpalette.com/pixiPickprozess/finishOrder">
                                        <button type="button"
                                                class="btn btn-lg btn-default btn-touch-xs pull-right form-contol">
                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                        </button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                                <div class="col-xs-4 col-md-2">
                                    <form name="auftragFertig"
                                          action="http://dev.stoffpalette.com/pixiPickprozess/finishOrder">
                                        <button type="button"
                                                class="btn btn-lg btn-default btn-touch-xs pull-right form-contol">
                                            <span class="glyphicon glyphicon-ok-circle"></span>
                                        </button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-3">
            <?php require_once('nav.php'); ?>
        </div>
    </div>
<?php } else {
    echo 'Zugriff verweigert!';
} ?>
