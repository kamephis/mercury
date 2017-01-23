</div> <!-- END:Container -->
<?php
// Individuelle JavaScripte für jede View laden
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>
<script src="out/lib/js/jquery-3.1.1.min.js"></script>
<script src="out/lib/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="out/lib/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>