<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/permissions_groups/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_post_level.php");
/////////////////

class ThisClass
{

  // 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
  public $controller;
  public $shared_post_level;
  // 

  function __construct()
  {
    $this->shared_post_level = new SharedPostLevel();
    checkPosts2($GLOBALS['va']);
  }
  function init()
  {
    // echo "dd";
    $this->shared_post_level->init_shared_post_level2();
    // echo "dd";
    $this->controller = new PermissionsGroups(
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
    $data = json_decode($this->shared_post_level->data, TRUE);
    if (isset($data["TAG"]) && isset($data["FROM"])) {
      if (isset($data["READ_BY"])) {
        if (isset($data["ID"])) {
          $TAG = $data["TAG"];
          $FROM = $data["FROM"];
          $READ_BY = $data["READ_BY"];
          $ID = $data["ID"];
          if ($TAG == "READ") {
            if ($READ_BY == "GROUP_ID") {
              $v1 = $this->controller->read_permissions_groups_by_group_id($ID,$FROM);
            } else
              return fun()->UNKOWN_READ_BY();
          } else
            return fun()->UNKOWN_TAG();
        } else
          return fun()->ID_NOT_FOUND();
      } else
        return fun()->READ_BY_NOT_FOUND();
    } else
      return fun()->TAG_NOT_FOUND();

    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      return json_encode($c1["data"]);
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
