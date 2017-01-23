<div class="row">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navigation ein/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-leaf small"></span>&nbsp;Mercury
                <small style="color:red;">beta</small>
            </a>
        </div>
        <!-- ./ Header -->
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?p=artinfo">Artikelinfo&nbsp;<span
                            class="glyphicon glyphicon-search pull-right text-sm hidden-sm"></span></a>
                </li>
                <li>
                    <a href="#">Hilfe&nbsp;
                        <span class="glyphicon glyphicon-question-sign pull-right"></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?p=home"><?php echo $_SESSION['vorname']; ?> Abmelden&nbsp;<span
                            class="glyphicon glyphicon-log-out pull-right hidden-sm"></span>
                    </a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </nav>
</div>
<br>
<br>
<br>