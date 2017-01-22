<?php if (isset($_SESSION['userName'])) { ?>
    Auftragsbearbeitung
<?php } else {
    echo 'Zugriff verweigert!';
} ?>
