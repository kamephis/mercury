<div class="panel col-xs-12 col-md-6 col-md-offset-3" id="loginbox">
    <div class="panel-heading">
        Kennwort Code scannen
    </div>

    <div class="panel-body loginPanel">
        <form id="loginform" class="form-horizontal" role="form" method="post" action="login">
            <input type="hidden" name="appTarget" value="<?php echo $appTarget; ?>">

            <div class="input-group inputLogin">
                <input type="hidden" name="artNr" value="<?php echo $_REQUEST['artNr']; ?>">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="login-password" type="password" class="form-control" name="passwd"
                       placeholder=" Kennwort...<?php #echo $lang->aText['inputUserPasswordRequiredText'];?>" required>
            </div>
            <div style="margin-top:10px" class="form-group">
                <div class="col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <button type="submit" class="btn btn-success btn-block">
                                Anmelden <?php #echo $lang->aText['buttonLoginText'];?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
