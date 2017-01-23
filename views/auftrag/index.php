<!-- Top Bar -->
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading"><?php $this->title; ?></div>

        <div class="panel-body">
            <div class="col-sm-2"><img
                    src="https://www.stoff4you.de/out/pictures/master/product/1/fn1094-love-universalstoff-_z1.jpg"
                    width="150px"
                    class="img img-responsive img-square"></div>
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-3">Artikel (Variante)</div>
                    <div class="col-sm-4">Universalstoff (rot)</div>
                    <div class="clearfix"></div>

                    <div class="col-sm-3">Art.Nr.</div>
                    <div class="col-sm-4">60003001</div>
                    <div class="clearfix"></div>

                    <div class="col-sm-3">EAN</div>
                    <div class="col-sm-4">01234567890123</div>
                    <div class="clearfix"></div>

                    <div class="col-sm-3">Lagerplatz</div>
                    <div class="col-sm-4">H1-C-01</div>
                    <div class="clearfix"></div>

                    <div class="col-sm-3">Lagerbestand</div>
                    <div class="col-sm-4">145</div>
                </div>
            </div>
            <div class="col-sm-3">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
                    <button type="submit" class="btn btn-lg btn-default btn-block pull-right">
                        <span class="glyphicon glyphicon-user"></span> Abmelden
                    </button>
                </form>
                <div class="clearfix"></div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
                    <button type="submit" class="btn btn-lg btn-danger btn-block pull-right">
                        <span class="glyphicon glyphicon-remove"></span> Abbrechen
                    </button>
                </form>
                <div class="clearfix"></div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
                    <button type="submit" class="btn btn-lg btn-success btn-block pull-right">
                        <span class="glyphicon glyphicon-check"></span> Abschließen
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- ./ Top Bar -->

<!-- Auftragspositionen / Header -->
<div class="row">
    <div class="col-sm-2"><b>#</b></div>
    <div class="col-sm-4"><b>Info</b></div>
    <div class="col-sm-2"><b>Anzahl</b></div>
    <div class="col-sm-4"><b>Aktion</b></div>
</div>
<!-- Auftragspositionen -->
<div class="row row-table">
    <div class="col-sm-2">01</div>

    <div class="col-sm-4">
        Pickliste: 6585<br>
        Expires: 17.02.2017
    </div>

    <div class="col-sm-2">12m</div>

    <div class="col-sm-2">
            <button type="submit" class="btn btn-danger btn-lg btn-block">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
    </div>

    <div class="col-sm-2">
            <button type="submit" class="btn btn-success btn-lg btn-block">
                <span class="glyphicon glyphicon-ok"></span>
            </button>
    </div>
</div>
<!-- ./ Auftragspositionen -->
