<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/fun_va_post.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/filter_posted_data.php");

class Shared_Data
{
    public $data1;
    public $data2;
    public $data3;

    public $filter_posted_data;

    function data1()
    {
        $name = "data1";
        if (!isset($_POST[$name])) {
            $this->exitFromScript(fun1()->POST_DATA_NOT_FOUND(1));
        }
        if (!fun()->json_validate($_POST[$name])) {
            $this->exitFromScript(fun1()->JSON_FORMAT_INVALID("DATA1"));
        }
        $this->data1 = json_decode($_POST[$name], true);
        $this->filter_posted_data = new FilterPostedData();
        $this->filter_posted_data->data1($this->data1);
    }
    function checkPostData1()
    {
        if (count($_POST) > 1) {
            $this->exitFromScript(fun1()->MORE_THAN_POST_DATA());
        }
    }
    function data2()
    {
        $this->data1();
        // 
        $name = "data2";
        if (!isset($_POST[$name])) {
            $this->exitFromScript(fun()->POST_DATA_NOT_FOUND(2));
        }
        if (!fun()->json_validate($_POST[$name])) {
            $this->exitFromScript(fun()->JSON_FORMAT_INVALID("DATA2"));
        }
        $this->data2 = json_decode($_POST[$name], true);
        $this->filter_posted_data = new FilterPostedData();
        $this->filter_posted_data->data2($this->data1, $this->data2);
    }
    function checkPostData2()
    {
        if (count($_POST) > 2) {
            $this->exitFromScript(fun1()->MORE_THAN_POST_DATA());
        }
    }
    function data3()
    {
        $this->data2();
        // 
        $name = "data3";
        if (!isset($_POST[$name])) {
            $this->exitFromScript(fun()->POST_DATA_NOT_FOUND(3));
        }
        if (!fun()->json_validate($_POST[$name])) {
            $this->exitFromScript(fun()->JSON_FORMAT_INVALID("DATA3"));
        }
        $this->data3 = json_decode($_POST[$name], true);
        $this->filter_posted_data = new FilterPostedData();
        $this->filter_posted_data->data3($this->data1, $this->data2, $this->data3);
    }
    function issetData2()
    {
        $name = "data2";
        if (!isset($_POST[$name])) {
            return false;
        }
        return true;
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
    function getDeviceAppToken()
    {
        $v1 = $this->filter_posted_data->checkDeviceAppToken();
        return $this->returnData($v1);
    }
    function getUserPhone()
    {
        $v1 = $this->filter_posted_data->checkUserPhone();
        return $this->returnData($v1);
    }
    function getUserPassword()
    {
        $v1 = $this->filter_posted_data->checkUserPassword();
        return $this->returnData($v1);
    }
    // 
    function getTag()
    {
        $v1 = $this->filter_posted_data->checkTag();
        return $this->returnData($v1);
    }
    function getTagUpdate()
    {
        if ($this->getTag() != "update") {
            $this->exitFromScript(fun()->UNKOWN_TAG());
        }
    }
    function getTagRead()
    {
        if ($this->getTag() != "read") {
            $this->exitFromScript(fun()->UNKOWN_TAG());
        }
    }
    function getTagDelete()
    {
        if ($this->getTag() != "update") {
            $this->exitFromScript(fun()->UNKOWN_TAG());
        }
    }
    function getFrom()
    {
        $v1 = $this->filter_posted_data->checkFrom();
        return $this->returnData($v1);
    }
    function getName()
    {
        $v1 = $this->filter_posted_data->checkName();
        return $this->returnData($v1);
    }


    function getIds()
    {
        $v1 = $this->filter_posted_data->checkIds();
        return $this->returnData($v1);
    }
    function getId()
    {
        $v1 = $this->filter_posted_data->checkId();
        return $this->returnData($v1);
    }
    function returnData(ResultData $v1)
    {
        // print_r($v1);
        if (!$v1->result) {
            $this->exitFromScript($v1->data);
        }
        return $v1->data;
    }
    private function exitFromScript($v1)
    {
        echo json_encode($v1->data);
        exit();
    }


}
