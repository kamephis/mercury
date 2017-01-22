<?php

/**
 * User: Marlon
 * Date: 11.12.2016
 * Time: 23:06
 */
class Error extends Controller
{
    /**
     * Error constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->view->render('error/index');
    }

    public function e401()
    {
        echo '<div class="alert alert-danger">';
        echo 'ERROR 401: Forbidden.';
        echo '</div>';
    }

    public function e404()
    {
        echo '<div class="alert alert-danger">';
        echo 'ERROR 404: File not found.';
        echo '</div>';
    }
}