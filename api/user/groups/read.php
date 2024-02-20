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

  function init()
  {
    // echo "dd";
    $this->shared_post_level->init_shared_post_level2();
    // echo "dd";
    $this->controller = new Groups(
      $this->shared_post_level->app_package_name,
      $this->shared_post_level->sha,
      $this->shared_post_level->app_version,
      $this->shared_post_level->device_type_name,
      $this->shared_post_level->device_id,
      $this->shared_post_level->device_info,
      $this->shared_post_level->app_device_token,
      $this->shared_post_level->user_phone,
      $this->shared_post_level->user_password
    );
  }
  // 
  function main(): string
  {
    $v1 = null;
    $this->init();
    // sleep(1);
    // echo "dd";
    // if ($this->id != null) {
    //   $this->controller->id = $this->id;
    //   // echo $this->controller->id;
    //   $v1 = $this->controller->read("in");
    // }
    // else{

    //   $v1 = $this->controller->read("");
    // }

    $data = json_decode($this->shared_post_level->data, TRUE);
    // print_r($data);
    if (isset($data["TAG"]) && isset($data["FROM"])) {
      $TAG = $data["TAG"];
      $FROM = $data["FROM"];
      if ($TAG == "READ") {
        $v1 = $this->controller->read("");
      } elseif ($TAG == "SEARCH") {
        // print_r(isset($data["SEARCH_BY"]) );
        if (isset($data["SEARCH_BY"]) && isset($data["SEARCH"])) {
          $SEARCH_BY = $data["SEARCH_BY"];
          $SEARCH = $data["SEARCH"];
          if ($SEARCH_BY == "NAME") {
            if (isset($data["CAUSE"]) && isset($data["G_ID"])) {
              $CAUSE = $data["CAUSE"];
              $G_ID =  $data["G_ID"];
              // 
              if ($CAUSE == "ADD_TO_PG") {
                $v1 = $this->controller->search_by_name_for_add_to_pg($SEARCH, $FROM, $G_ID);
              } else
                return fun()->UNKOWN_CAUSE();
            } else {
              $v1 = $this->controller->read_groups();
            }
          } else
            return fun()->UNKOWN_SEARCH_BY();
        } else
          return fun()->UNKOWN_FORMAT_SEARCH();
      } else
        return fun()->UNKOWN_TAG();
    } else
      return fun()->TAG_NOT_FOUND();
    
    $c1 = json_decode($v1,true);
      if ( $c1["result"]) {
        return json_encode($c1["data"]);
        // 
      }
      return $v1;
    }
}

$this_class = new ThisClass();
echo $this_class->main();
