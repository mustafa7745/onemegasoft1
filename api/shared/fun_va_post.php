<?php
$root = "onemegasoft1";
$path = $_SERVER["DOCUMENT_ROOT"] . "/$root/";
require_once($path . 'functions/fun1.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");
function getPath()
{
    return $GLOBALS["path"];
}
$fun = new Fun1();
function fun1(): Fun1
{
    return $GLOBALS["fun"];
}

?>