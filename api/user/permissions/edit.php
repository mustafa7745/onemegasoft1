<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/permissions/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");

/////////////////

class ThisClass
{
  // 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
  public $controller;
  public $shared_data;
  // 

  function __construct()
  {
    $this->shared_data = new Shared_Data();
    $this->shared_data->data3();
    //
    $this->controller = new Permissions(
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

    $this->shared_data->getTagUpdate();
    $v1 = $this->controller->edit_permission($this->shared_data->getName(), $this->shared_data->getId());
    // 
    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      return json_encode($c1["data"]);
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
