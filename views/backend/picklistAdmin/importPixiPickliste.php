<?php
/**
 * Picklistenerstellung
 * User: Marlon
 * Date: 17.03.2017
 * Time: 08:13
 *
 * Version 1.0
 */

// init
$pl = $this->pl;

// Pixi Picklisten auslesen (zur Auswahl)
if ($pl->getAllPixiPicklists()) {
    $aPicklists = $pl->getAllPixiPicklists();
}


// Importieren der ausgewählten Pickliste
if (isset($_REQUEST['selectedPicklist'])) {
    $pl->importPicklist($_REQUEST['selectedPicklist']);
}
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        Schritt 1 &ndash; Pixi Pickliste Importieren
    </div>
    <div class="panel-body">
        <div class="well">
            Importieren Sie eine über Pixi erstellte Pickliste. Die Artikel dieser Pickliste sind die Basis für die
            individuellen Stoff Palette Picklisten.
        </div>

        <form method="post">
            <div class="form-group">
                <div class="col-sm-5">

                    <div class="input-group">
                        <select name="selectedPicklist" class="form-control" name="pixiPlist">
                            <?php
                            if (is_array($aPicklists[0])) {
                                foreach ($aPicklists as $item) {
                                    echo '<option value="' . $item['PLHkey'] . '">' . $item['PLHkey'] . ' ' . utf8_encode($item['PLcomment']) . '</option>';
                                }
                            } else {
                                echo '<option value="' . $aPicklists['PLHkey'] . '">' . $aPicklists['PLHkey'] . ' | ' . utf8_encode($aPicklists['PLcomment']) . '</option>';
                            }
                            ?>
                        </select>

                        <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-cloud-download"></span>
                                    &nbsp;pixi* Pickliste Importieren</button>
                                </span>
                    </div>

                    <div class="clearfix"></div>
                    <br>
                    <div class="alert alert-warning alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b>ACHTUNG!</b> Beim Import einer pixi* Pickliste, wird immer der in diesem Moment, aktuelle
                        Stand der Pickliste importiert. Im parallel Betrieb (gedruckte / digitale Pickliste)
                        muss ganz besonders darauf geachtetet werden. Möchte man den Stand der pixi* Picklisten
                        aktualisieren, müssen zuerst die Tabellen (die Aufträge) aus der
                        internen Datenbank geleert werden. So ist sichergestellt, dass Veränderungen auch auf die
                        interne Pickliste übertragen werden.
                    </div>
                    <div class="clearfix"></div>
                    <a href="neuePickliste" class="btn btn-default">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                        &nbsp;Neue interne Pickliste erstellen
                    </a>
                </div>
        </form>
    </div>
</div>
</div>