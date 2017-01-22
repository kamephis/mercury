<!-- Anzeige Picklisten -->
<div class="row">
    <div class="col-xs-12">
        <h1>Aktive Picklisten</h1>
        <p class="lead">Hallo USERNAME, folgende Picklisten sind für dich zum Picken freigegeben.</p>
    </div>
</div>

<div class="row">
    <div class="col-xs-3 col-md-1">
        <h4><b>#</b></h4>
        <div class="row">
            <div class="col-xs-12">
                65584
            </div>
        </div>
    </div>
    <div class="col-xs-9 col-md-4 text-left">
        <h4><b>Picklisten Details</b></h4>
        <div class="row">
            <div class="col-xs-5 col-md-2 text-left">
                Erstellt von:
            </div>
            <div class="col-xs-7">
                Böhland
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-5 col-md-2 text-left">
                Erstellt am:
            </div>
            <div class="col-xs-7 text-left">
                01.02.2017
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-5 col-md-2 text-left">
                Verfällt am:
            </div>
            <div class="col-xs-7 text-left">
                11.02.2017
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-5 col-md-2 text-left">
                Positionen:
            </div>
            <div class="col-xs-7 text-left	">
                142
            </div>
            <div class="clearfix"></div>
            <br>
            <!-- smarter -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
            <input type="hidden" name="p" value="picklist">
            <button type="submit" class="btn btn-success btn-block btn-lg" name="btnStartPick" id="btnStartPick">
                <span class="glyphicon glyphicon-time"></span> Picken beginnen
            </button>
        </form>
    </div>
</div>