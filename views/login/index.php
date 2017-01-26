<div class="panel col-xs-12 col-md-6 col-md-offset-3" id="loginbox">
    <div class="panel-heading">
        <img src="<?php echo IMG_PATH; ?>logo_600.jpg" class="img img-responsive">
    </div>

    <div class="panel-body loginPanel">
        <form id="loginform" class="form-horizontal" role="form" method="post" action="login">
            <input type="hidden" name="appTarget" value="<?php echo $appTarget; ?>">
            <input type="hidden" name="artNr" value="35003999">
            <div class="input-group inputLogin">
                <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                <input id="login-username" type="text" class="form-control" name="user" value=""
                       placeholder=" Benutzername...<?php # echo $lang->aText['inputUserNameRequiredText'];?>" required>
            </div>
            <div class="input-group inputLogin">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="login-password" type="password" class="form-control" name="passwd"
                       placeholder=" Kennwort...<?php #echo $lang->aText['inputUserPasswordRequiredText'];?>" required>
            </div>
            <?php
            if (isset($_REQUEST['e'])) {

                switch ($_REQUEST['e']) {
                    case '401':
                        echo '<div class="alert alert-danger">';
                        echo '<span class="glyphicon glyphicon-exclamation-sign"></span> ';
                        //echo $this->lang->aText['alert401'];
                        echo 'Zugriff verweigert.';
                        echo '</div>';
                        break;
                    case 'logout':
                        echo '<div class="alert alert-info">';
                        echo '<span class="glyphicon glyphicon-info-sign"></span> ';
                        //echo $this->lang->aText['alertLogout'];
                        echo 'Sie wurden vom System abgemeldet.';
                        echo '</div>';
                        break;
                }
            }
            ?>

            <!--<a href="?lang=de_DE">Deutsch</a>
            <a href="?lang=en_EN">English</a>-->
            <div style="margin-top:10px" class="form-group">
                <div class="col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <button type="submit" class="btn btn-success btn-block">
                                Anmelden <?php #echo $lang->aText['buttonLoginText'];?></button>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <button type="button" class="btn btn-default btn-block" data-toggle="collapse"
                                    data-target="#hilfe">
                                Hilfe<?php # echo $lang->aText['buttonHelpText'];?></button>
                        </div>
                    </div>

                    <div id="hilfe" class="collapse">
                        <br>
                        <div class="alert alert-info" id="helpMsg">
                            <!--<?php echo $lang->aText['alertHelpText']; ?>-->
                            1. Barcode <strong>Benutzername</strong> scannen.<br>2. Barcode <strong>Kennwort</strong>
                            scannen.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
