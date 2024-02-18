<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_open_app/init_device_session_ip/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session/executer.php');



/////////////////

class ThisClass
{
  public $controller;
  public $shared_data;

  function __construct()
  {
    // $v = (new WrongResponse())->error_response("ar","en",300);
    // print_r(json_encode($v->data));
    // 
    $this->shared_data = new Shared_Data();
    $this->shared_data->data1();
    $this->shared_data->checkPostData1();
    //  
    // print_r($this->shared_data->getAppPackageName());
    // $this->controller = new CheckingInitDeviceSessionIp($this->shared_data);
    $this->controller = new CheckingInitDeviceSessionIp($this->shared_data);

  }
  
 
  function main(): string
  {
    // sleep(1);
    $resultData = $this->controller->check();
    if ($resultData->result) {
      return json_encode($resultData->data);
    }
    return json_encode($resultData->data) ; 
  }
}

$this_class = new ThisClass();
echo $this_class->main();

?>