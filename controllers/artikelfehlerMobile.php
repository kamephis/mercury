<?php

/**
 * Fehler-Artikel Controller
 *
 * @author: Marlon Böhland
 * @access: public
 */
class ArtikelFehlerMobile extends Controller
{
    function __construct()
    {
        parent::__construct();
        Session::init();
    }

    function index()
    {
        if (Session::checkAuth()) {
            $this->view->title = 'Artikelfehler';
            require_once('models/navigation_model.php');
            $this->view->nav = new Navigation_Model();

            $this->view->artikelFehler = $this->model->getFehlerhafteArtikel();
            $this->view->artikelFehlerMobile = $this->model;
            $this->view->Picklist = new Picklist_Model();

            $this->view->render('header');
            $this->view->render('navigation');
            $this->view->render('mobile/picker');
            $this->view->render('footer');
        } else {
            Error::getError('401');
        }
    }

    function run()
    {
        $this->model->run();
    }
}