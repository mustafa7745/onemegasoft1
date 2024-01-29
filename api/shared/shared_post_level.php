<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/fun_va_post.php");
class SharedPostLevel
{
    public $app_package_name;
    public $app_version;
    public $sha;
    public $device_id;
    public $device_type_name;
    public $app_device_token;
    public $device_info;
    public $user_phone;
    public $user_password;
    function init_shared_post_level1() {
        checkPostValidate();
        $this->app_package_name = $_POST['app_package_name'];
        $this->sha = strtoupper($_POST['sha']);
        $this->app_version = $_POST['app_version'] ;
        $this->device_id = $_POST['device_id'];
        $this->device_type_name = $_POST['device_type_name'];
        $this->app_device_token = ($_POST['app_device_token']);
        $this->device_info = $_POST['device_info'];
    }

    function init_shared_post_level2() {
        array_push($GLOBALS['va'],"user_phone","user_password");
        checkPostValidate();
        $this->app_package_name = $_POST['app_package_name'];
        $this->sha = strtoupper($_POST['sha']);
        $this->app_version = $_POST['app_version'] ;
        $this->device_id = $_POST['device_id'];
        $this->device_type_name = $_POST['device_type_name'];
        $this->app_device_token = ($_POST['app_device_token']);
        $this->device_info = $_POST['device_info'];
        $this->user_phone = ($_POST['user_phone']);
        $this->user_password = $_POST['user_password'];
    }
    
}
?>