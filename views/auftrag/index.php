<!-- Top Bar -->
<div class="row text-mobile-large">
            <div class="col-sm-2"><img
                    src="https://www.stoff4you.de/out/pictures/master/product/1/fn1094-love-universalstoff-_z1.jpg"
                    width="100%"
                    class="img img-responsive img-square img-thumbnail">
            </div>

    <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-4"><b>Artikel:</b></div>
                    <div class="col-sm-8">Universalstoff - Love</div>

                    <div class="col-sm-4"><b>Art.Nr:</b></div>
                    <div class="col-sm-8">FN1094</div>
                </div>
            </div>

    <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-4"><b>EAN</b></div>
                        <div class="col-sm-8">01234567890123</div>

                        <div class="col-sm-4"><b>Lager</b></div>
                        <div class="col-sm-8">H1-C-01</div>

                        <div class="col-sm-4"><b>Bestand</b></div>
                        <div class="col-sm-8">145</div>
                    </div>
                </div>
    <div class="col-sm-2">
        <p><b>Auftrag 16895</b></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
                    <button type="submit" class="btn btn-lg btn-default btn-block" style="margin-bottom:5px;">
                        <span class="glyphicon glyphicon-remove"></span> Abbrechen
                    </button>
                </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
            <button type="submit" class="btn btn-info btn-lg btn-block">
                <span class="glyphicon glyphicon-ok"></span> Abschließen
                    </button>
                </form>
            </div>
</div>
<!-- ./ Top Bar -->
<br><br>
<!-- Auftragspositionen / Header -->
<div class="row text-mobile-large">
    <div class="col-sm-1 text-left"><b>#</b></div>
    <div class="col-sm-7 text-left"><b>Info</b></div>
    <div class="col-sm-1"><b>Anzahl</b></div>
    <div class="col-sm-3 text-left"><b></b></div>
</div>

<!-- Auftragspositionen -->
<div class="row row-table default-state">
    <div class="col-sm-1">01</div>

    <div class="col-sm-7">
        Pickliste: 6585 | Expires: 17.02.2017<br>
        Auftragsdatum: 16.01.2017

    </div>

    <div class="col-sm-1">12 m</div>

    <div class="col-sm-3">
        <button type="submit" class="btn btn-danger btn-lg-square pull-right" style="margin-left:10px;">
            <span class="glyphicon glyphicon-remove text-glyphicon-lg"></span>
            </button>

        <button type="submit" class="btn btn-success btn-lg-square pull-right">
            <span class="glyphicon glyphicon-ok text-glyphicon-lg"></span>
            </button>
    </div>
</div>

<div class="row row-table important-state">
    <div class="col-sm-1">01</div>

    <div class="col-sm-7">
        Pickliste: 6585 | Expires: 17.02.2017<br>
        Auftragsdatum: <strong><u>16.01.2017</u></strong>

    </div>

    <div class="col-sm-1">12 m</div>

    <div class="col-sm-3">
        <button type="submit" class="btn btn-danger btn-lg-square pull-right" style="margin-left:10px;">
            <span class="glyphicon glyphicon-remove text-glyphicon-lg"></span>
        </button>

        <button type="submit" class="btn btn-success btn-lg-square pull-right">
            <span class="glyphicon glyphicon-ok text-glyphicon-lg"></span>
        </button>
    </div>
</div>

<div class="row row-table default-state">
    <div class="col-sm-1">01</div>

    <div class="col-sm-7">
        Pickliste: 6585 | Expires: 17.02.2017<br>
        Auftragsdatum: 16.01.2017

    </div>

    <div class="col-sm-1">12 m</div>

    <div class="col-sm-3">
        <button type="submit" class="btn btn-danger btn-lg-square pull-right" style="margin-left:10px;">
            <span class="glyphicon glyphicon-remove text-glyphicon-lg"></span>
        </button>

        <button type="submit" class="btn btn-success btn-lg-square pull-right">
            <span class="glyphicon glyphicon-ok text-glyphicon-lg"></span>
        </button>
    </div>
</div>




<!-- ./ Auftragspositionen -->


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
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">NEIN</button>
                <button type="button" class="btn btn-success btn-block btn-lg" data-dismiss="modal">JA</button>
            </div>
        </div>

    </div>
</div>
<!-- ./ modal test -_>

