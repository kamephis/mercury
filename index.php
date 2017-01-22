<?php
session_start();
error_reporting(E_ALL);
require_once('application/libs/bootstrap.php');
require_once('application/libs/model.php');
require_once('application/libs/controller.php');
require_once('application/libs/view.php');
require_once('application/libs/lang.php');
require_once('application/libs/dBase.php');
$bs = new Bootstrap();
$controller = new Controller();
