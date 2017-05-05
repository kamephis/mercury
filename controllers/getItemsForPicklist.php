<?php

/**
 * GetItemForPicklist Controller
 *
 * @author: Marlon Böhland
 * @access: public
 */
class GetItemsForPicklist extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->model = new GetItemsForPicklist_Model();
        $this->view->pl = $this->model;
        $this->view->render('backend/picklistAdmin/getItemForPicklist');
    }

    function run()
    {
        $this->model->run();
    }
}