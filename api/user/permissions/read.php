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
    if ($this->shared_data->getTag() == "read") {
      // sleep(10);
      $resultData = $this->controller->read_permissions($this->shared_data->getFrom());
    } elseif ($this->shared_data->getTag() == "search") {
      if ($this->shared_data->getSearchBy() == "name") {
        $resultData = $this->controller->search_by_name($this->shared_data->getSearch(), $this->shared_data->getFrom());
      } else
        return json_encode(fun1()->UNKOWN_SEARCH_BY()->data);
    } else
      return json_encode(fun1()->UNKOWN_TAG()->data);

    if ($resultData->result) {
      return json_encode($resultData->data);
    }
    return json_encode($resultData->data);
  }
}

$this_class = new ThisClass();
echo $this_class->main();
