<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/fun_va_post.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/filter_posted_data.php");

class Shared_Data
{
    public $data;
    public $filter_posted_data;

    // function __construct()
    // {

    // }


    function data1()
    {
        if (!isset($_POST["data1"])) {
            $this->exitFromScript(fun()->POST_DATA_NOT_FOUND(1));
        }
        if (!fun()->json_validate($_POST["data1"])) {
            $this->exitFromScript(fun()->JSON_FORMAT_INVALID("DATA1"));
        }
        $this->data = json_decode($_POST["data1"], true);
        $this->filter_posted_data = new FilterPostedData($this->data);
    }
    function getAppPackageName()
    {
        $v1 = $this->filter_posted_data->checkAppPackageName();
        return $this->returnData($v1);
    }
    function getSha()
    {

        $v1 = $this->filter_posted_data->checkAppSha();
        return $this->returnData($v1);
    }
    function getAppVersion()
    {
        $v1 = $this->filter_posted_data->checkAppVersion();
        return $this->returnData($v1);
    }
    function getDeviceId()
    {
        $v1 = $this->filter_posted_data->checkDeviceId();
        return $this->returnData($v1);
    }
    function getDeviceTypeName()
    {
        $v1 = $this->filter_posted_data->checkDeviceTypeName();
        return $this->returnData($v1);
    }
    function getDeviceInfo()
    {
        $v1 = $this->filter_posted_data->checkDeviceInfo();
        return $this->returnData($v1);
    }
    function returnData($v1)
    {
        $c1 = json_decode($v1, TRUE);
        if (!$c1["result"]) {
            $this->exitFromScript($v1);
        }
        return $c1["data"];
    }
    private function exitFromScript($v1)
    {
        echo $v1;
        exit();
    }

    // function init_shared_post_level2() {
    //     array_push($GLOBALS['va'],"user_phone","user_password","data");
    //     checkPostValidate();
    //     $this->app_package_name = $_POST['app_package_name'];
    //     $this->sha = strtoupper($_POST['sha']);
    //     $this->app_version = $_POST['app_version'] ;
    //     $this->device_id = $_POST['device_id'];
    //     $this->device_type_name = $_POST['device_type_name'];
    //     $this->app_device_token = ($_POST['app_device_token']);
    //     $this->device_info = $_POST['device_info'];
    //     $this->user_phone = ($_POST['user_phone']);
    //     $this->user_password = $_POST['user_password'];
    //     $this->data = $_POST["data"];
    //     // 
    //     if (!fun()->json_validate($this->data)) {
    //         echo fun()->JSON_FORMAT_INVALID();
    //         exit();
    //     }
    // }

}
