<?php

class Etikett extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->title = 'Etikettendruck';
        $this->view->render('header');

        // Umschlaten der Ansicht je nach Etiketten-Typ
        if (isset($_POST['etyp'])) {
            switch ($_POST['etyp']) {
                case 'ok':
                    $this->view->etyp = 'ok';
                    break;

                case 'fehler':
                    $this->view->etyp = 'fehler';
                    break;
            }
            $this->view->render('etikett/index');
        }
        $this->view->render('footer');
    }
}