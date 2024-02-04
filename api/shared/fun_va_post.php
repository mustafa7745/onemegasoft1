<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/fun.php");
$va = array(
    "app_package_name",
    "sha",
    "app_version",
    "device_id",
    "device_type_name",
    "device_info",
    "app_device_token",
);

function fun(): Fun
{
    return new Fun();
}

function checkPosts1($va)
{
    $v1 = fun()->isSetValues0();
    $c1 = json_decode($v1);
    if (!$c1->result) {
        echo $v1;
        exit();
    }
}
function checkPosts2($va)
{
    $v1 = fun()->isSetValues1();
    $c1 = json_decode($v1);
    if (!$c1->result) {
        echo $v1;
        exit();
    }
    // echo "dd";
}



function check_id($id)
{
    $v1 = fun()->CHECK_ID_JSON($id);
    $c1 = json_decode($v1,true);
    if (!$c1["result"]) {
        echo $v1;
        exit();
    }
    // echo "dd";
}

function checkPostValidate()
{
    // echo count($GLOBALS['va']);
    if (count($_POST) == count($GLOBALS['va'])) {
        foreach ($_POST as $key => $value) {
            // echo $key;
            if (!in_array($key, $GLOBALS['va'])) {
                echo fun()->PARAMETER_INVALID();
                exit();
            }
        }
    } else {
        echo fun()->PARAMETER_INVALID();
        exit();
    }


}

?>