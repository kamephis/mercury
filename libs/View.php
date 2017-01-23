<?php

class View
{

    function __construct()
    {
        echo 'this is the view';
    }

    public function render($name, $noInclude = false)
    {
        echo $name;
        require 'views/' . $name . '.php';
    }
}