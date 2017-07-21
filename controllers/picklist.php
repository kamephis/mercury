<?php

/**
 * Picklist Controller
 *
 * @author: Marlon Böhland
 * @access: public
 */
class Picklist extends Controller
{
    private $aPicklist;

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (Session::checkAuth()) {
            $this->view->title = 'Picken';
            $this->model = new Picklist_Model();

            require_once('models/navigation_model.php');
            $this->view->nav = new Navigation_Model();

            $this->view->Picklist = $this->model;
            $this->view->AnzItems = $this->model->getPicklistItemCount($_REQUEST['picklistNr']);
            $this->view->Pixi = new Pixi();

            $this->view->render('header');
            $this->view->render('navigation');
            $this->view->render('mobile/picklist');
            $this->view->render('footer');
        }
    }

    /**
     * @return mixed
     */
    public function getAPicklist()
    {
        return $this->aPicklist;
    }

    /**
     * @param mixed $aPicklist
     */
    public function setAPicklist($aPicklist)
    {
        $this->aPicklist = $aPicklist;
    }

    function run()
       {
           $this->model->run();
       }
}