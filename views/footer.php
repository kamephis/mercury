</div> <!-- END:Container -->
<?php
// Individuelle JavaScripte für jede View laden
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>


</body>
</html>