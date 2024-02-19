<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/login/executer.php");
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
    $this->shared_data->checkPostData2();
    // 
    $this->controller = new Login($this->shared_data);
  }

  function main(): string
  {
    // sleep(3);
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