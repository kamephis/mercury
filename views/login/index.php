<div class="panel col-xs-12 col-md-6 col-md-offset-3" id="loginbox">
    <div class="panel-heading">
        <img src="<?php echo IMG_PATH; ?>logo_600.jpg" style="width:350px" class="img img-responsive">
    </div>

    <div class="panel-body loginPanel">
        <h3>Zuschnitt Auftragsbearbeitung</h3>
        <form id="loginform" class="form-horizontal" role="form" method="post" action="login/run">

            <div class="input-group inputLogin">
                <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                <input id="login-username" type="password" class="form-control" name="userPasswd" value=""
                       placeholder="Login Barcode scannen..." required autofocus>
            </div>

            <div style="margin-top:10px" class="form-group">
                <div class="col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <button type="submit" class="btn btn-success btn-block">
                                Anmelden
                            </button>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                                    data-target="#hilfe">
                                Hilfe
                            </button>
                        </div>
                    </div>

                    <div id="hilfe" class="collapse">
                        <br>
                        <div class="alert alert-info" id="helpMsg">
                            <p>Scannen Sie ihren Zugriffsbarcode auf Ihrer ID-Karte ein.<br>
                                sollte der Barcode beschädigt sein, können Sie sich manuell am System anmelden.
                                Hierzu geben Sie ihren Benutzernamen und Ihr Kennwort in folgendem Format in das
                                Eingabefeld ein.<br><br>
                                <code>benutzername-kennwort</code><br><br>bestätigen Sie Ihre Eingabe mit drücken des
                                Anmelden Buttons.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
