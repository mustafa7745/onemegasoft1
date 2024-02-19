<?php
require_once("./init.php");

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

    $resultData = null; 
    if ($this->shared_data->getTag() == "delete") {
      $v1 = json_decode($this->shared_data->getIds(),TRUE);
      $ids = $v1["ids"];
      $count = $v1["count"];
      // 
      $resultData = $this->controller->delete_permission($ids,$count);
      if ($resultData->result) {
        return json_encode($resultData->data);
      }
      return json_encode($resultData->data) ;
      // 
    } else
      return json_encode(fun1()->UNKOWN_TAG());

   
  }
}
$this_class = new ThisClass();
echo $this_class->main();
