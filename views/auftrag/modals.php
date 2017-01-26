<div id="modFehler" class="modal fade" role="dialog">
    <form action="etikett/index" method="post">
        <input type="hidden" name="etyp" value="fehler">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Fehlergrund auswählen</h4>
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
                <button type="submit" class="btn btn-success btn-block btn-lg" data-dismiss="modal">Bestätigen

                </button>
            </div>
        </div>

    </div>
    </form>
</div>


<div id="modPicked" class="modal fade" role="dialog">
    <form action="etikett/index" method="post">
        <input type="hidden" name="etyp" value="ok">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bearbeitung bestätigen</h4>
            </div>
            <div class="modal-body">
                <h1 class="text-center"><b><?php echo $item['Qty']; ?> m</b></h1>
                <h2 class="text-center"><b>bearbeitet?</b></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">NEIN</button>
                <button type="submit" class="btn btn-success btn-block btn-lg" data-dismiss="modal">JA</button>
            </div>
        </div>

    </div>
    </form>
</div>
