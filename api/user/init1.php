<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_open_app/init_device_session_ip/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");
/////////////////

class ThisClass
{
  // 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
  public $controller;
  public $shared_data;

  function __construct()
  {
    print_r($_POST["data1"]);
    // print_r($_POST);
    $this->shared_data = new Shared_Data();
    // checkPosts1($GLOBALS['va']);
  }
  
  function init()
  {
    $this->shared_data->data1();
    $this->controller = new CheckingInitDeviceSessionIp(
      $this->shared_data->app_package_name,
      $this->shared_data->sha,
      $this->shared_data->app_version,
      $this->shared_data->device_type_name,
      $this->shared_data->device_id,
      $this->shared_data->device_info,
      $this->shared_data->app_device_token
    );
    // $this->controller->initUserAttr( $user_phone, $user_password);


  }
  // {"app_package_name":"","sha":"","app_version":"","device_type_name":"","device_id":"","device_info":"","app_device_token":""}

  function main(): string
  {
    $this->init();
    // sleep(2);
    // echo "dd";
    $v1 = $this->controller->check();
    $c1 = json_decode($v1);
    if ($c1->result) {
      return $v1;
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();

?>