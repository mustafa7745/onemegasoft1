<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/permissions/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_data.php");

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
    //
    $this->controller = new Permissions($this->shared_data);
  }


  function main(): string
  {
    $resultData ;
    if ($this->shared_data->getTag() == "read") {
      // sleep(10);
      $resultData = $this->controller->read_permissions($this->shared_data->getFrom());
    } elseif ($this->shared_data->getTag() == "SEARCH") {
      // print_r(isset($data["SEARCH_BY"]) );
      if (isset($data["SEARCH_BY"]) && isset($data["SEARCH"])) {
        $SEARCH_BY = $data["SEARCH_BY"];
        $SEARCH = $data["SEARCH"];
        if ($SEARCH_BY == "NAME") {
          if (isset($data["CAUSE"]) && isset($data["G_ID"])) {
            $CAUSE = $data["CAUSE"];
            $G_ID = $data["G_ID"];
            // 
            if ($CAUSE == "ADD_TO_PG") {
              $v1 = $this->controller->search_by_name_for_add_to_pg($SEARCH, $FROM, $G_ID);
            } else
              return fun()->UNKOWN_CAUSE();
          } else {
            $v1 = $this->controller->search_by_name($SEARCH, $FROM);
          }
        } else
          return fun()->UNKOWN_SEARCH_BY();
      } else
        return fun()->UNKOWN_FORMAT_SEARCH();
    } else
      return fun()->UNKOWN_TAG();



      if ($resultData->result) {
        return json_encode($resultData->data);
      }
      return json_encode($resultData->data) ;
}
}

$this_class = new ThisClass();
echo $this_class->main();
