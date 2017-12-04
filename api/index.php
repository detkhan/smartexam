<?php
$controller=$_GET['controller'];
$action=$_GET['action'];
$param=$_GET['parameter'];
require_once("controller/".$controller.".php");
$object=new $controller;
$object->$action($param);
 ?>
