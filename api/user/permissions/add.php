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
    $resultData = '';
    // sleep(1);
    if ($this->shared_data->getTag() == "add") {
      $resultData = $this->controller->add_permission($this->shared_data->getName());
    } else
      return json_encode(fun1()->UNKOWN_TAG());

    if ($resultData->result) {
      return json_encode($resultData->data[0]);
    }
    return json_encode($resultData->data);
  }
}

$this_class = new ThisClass();
echo $this_class->main();
