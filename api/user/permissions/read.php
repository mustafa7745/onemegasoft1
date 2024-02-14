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
    $v1 = '';
    if ($this->shared_data->getTag() == "read") {
      $v1 = $this->controller->read_permissions($this->shared_data->getFrom());
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






    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      return json_encode($c1["data"]);
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
