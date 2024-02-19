<?php
require_once("./init.php");
/////////////////

class ThisClass
{

  public $controller;
  public $shared_data;
  // 

  function __construct()
  {
    $this->shared_data = new Shared_Data();
    $this->shared_data->data3();
    $this->shared_data->checkPostData3();
    //
    $this->controller = getPermission($this->shared_data);
  }


  function main(): string
  {

    $this->shared_data->getTagUpdate();
    $resultData = $this->controller->update_permission($this->shared_data->getName(), $this->shared_data->getId());
    if ($resultData->result) {
      return json_encode($resultData->data);
    }
    return json_encode($resultData->data);
  }
}

$this_class = new ThisClass();
echo $this_class->main();
