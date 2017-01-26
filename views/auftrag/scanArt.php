<div class="panel col-xs-12 col-md-6 col-md-offset-3" id="loginbox">
    <div class="panel-heading">
        Artikelnummer code scannen
    </div>

    <div class="panel-body loginPanel">
        <form id="loginform" class="form-horizontal" role="form" method="post" action="login/run">
            <input type="hidden" name="user" value="<?php echo $_REQUEST['user']; ?>">
            <input type="hidden" name="password" value="<?php echo $_REQUEST['password']; ?>">
            <div class="input-group inputLogin">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="artNr" type="text" class="form-control" name="artNr" placeholder=" ArtNr..." required>
            </div>
            <div style="margin-top:10px" class="form-group">
                <div class="col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <button type="submit" class="btn btn-success btn-block">
                                weiter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>