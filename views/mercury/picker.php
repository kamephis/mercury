
    <div class="well-sm">
    <!-- Anzeige Picklisten -->
    <div class="row">
        <div class="col-xs-12">
            <h1>Aktive Picklisten</h1>
            <p class="lead">Hallo <?php echo Session::get('vorname'); ?>, folgende Picklisten sind für dich zum
                Picken
                freigegeben.</p>
        </div>
        </div>
        <?php
        foreach ($this->masterPicklist as $pickList) {
        ?>
    <div class="row">
        <div class="col-xs-3 col-md-1">
            <h4><b>#</b></h4>
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $pickList['PLHkey']; ?>
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
                    <?php echo utf8_encode($pickList['CreatedBy']); ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-5 col-md-2 text-left">
                    Erstellt am:
                </div>
                <div class="col-xs-7 text-left">
                    <?php echo $pickList['createDate']; ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-5 col-md-2 text-left">
                    Verfällt am:
                </div>
                <div class="col-xs-7 text-left">
                    <?php echo $pickList['expDate']; ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-5 col-md-2 text-left">
                    Positionen:
                </div>
                <div class="col-xs-7 text-left	">

                </div>
                <div class="clearfix"></div>
                <br>
                <!-- smarter -->
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <form action="<?php echo URL; ?>picklist" method="post" role="form">
                <input type="text" name="p" value="<?php echo $pickList['PLHkey']; ?>">
                <button type="submit" class="btn btn-success btn-block btn-lg" name="btnStartPick"
                        id="btnStartPick">
                    <span class="glyphicon glyphicon-time"></span> Picken beginnen
                </button>
            </form>
        </div>
        </div>
    </div><?php
}
//var_dump($this->masterPicklist);
?>