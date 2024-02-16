<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_open_app/init_device_session_ip/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");
/////////////////

class ThisClass
{
  public $controller;
  public $shared_data;

  function __construct()
  {
    // 
    $this->shared_data = new Shared_Data();
    $this->shared_data->data1();
    //  
    $this->controller = new CheckingInitDeviceSessionIp(
      $this->shared_data->getAppPackageName(),
      $this->shared_data->getSha(),
      $this->shared_data->getAppVersion(),
      $this->shared_data->getDeviceTypeName(),
      $this->shared_data->getDeviceId(),
      $this->shared_data->getDeviceInfo(),
      $this->shared_data->getDeviceAppToken()
    );
  }
  
 
  function main(): string
  {
    // sleep(2);
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