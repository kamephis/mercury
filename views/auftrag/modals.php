<div id="modOK" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Position bearbeitet?</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">
                    Schließen
                </button>
                <form action="etikett" method="post" role="form">
                    <input type="hidden" name="eType" value="eok">
                    <input type="hidden" name="artNr" value="<?php echo Session::get('artNr'); ?>">
                    <button type="submit" class="btn btn-success btn-block btn-lg" data-dismiss="modal">
                        Etikett Drucken
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>