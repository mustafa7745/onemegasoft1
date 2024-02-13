<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/check_user/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");

/////////////////

class ThisClass
{
  // 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
  public $controller;
  public $shared_data;

  function __construct()
  {
    $this->shared_data = new Shared_Data();
    $this->shared_data->data2();
    // 
    $this->controller = new Login( 
      $this->shared_data->getAppPackageName(),
      $this->shared_data->getSha(),
      $this->shared_data->getAppVersion(),
      $this->shared_data->getDeviceTypeName(),
      $this->shared_data->getDeviceId(),
      $this->shared_data->getDeviceInfo(),
      $this->shared_data->getDeviceAppToken(),
      $this->shared_data->getUserPhone(),
      $this->shared_data->getUserPassword()
      );
  }

  function main(): string
  {
    // sleep(1);
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