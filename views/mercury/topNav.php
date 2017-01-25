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
                    <a href="artikelinfo">Artikelinfo&nbsp;
                        <span
                            class="glyphicon glyphicon-search pull-right text-sm visible-xs"></span>
                    </a>
                </li>
                <li>
                    <a href="hilfe">Hilfe&nbsp;
                        <span class="glyphicon glyphicon-question-sign pull-right visible-xs"></span>
                    </a>
                </li>
                <li>
                    <a href="auftrag"><?php echo Session::get('vorname'); ?> Abmelden&nbsp;<span
                            class="glyphicon glyphicon-log-out pull-right visible-xs"></span>
                    </a>
                </li>
                <li><a href="picker" class="push-right">Picker</a></li>
                <li><a href="picklist" class="push-right">Pickliste</a></li>
                <li><a href="auftrag" class="push-right">Auftrag</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </nav>
</div>
<br>
<br>
<br>