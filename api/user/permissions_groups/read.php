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
  public $id;
  public $type;

  function __construct()
  {
    $this->shared_post_level = new SharedPostLevel();
    array_push($GLOBALS['va'], "id");
    // 
    if (isset($_POST["id"]) && $_POST["id"] != null) {
      check_id($_POST["id"]);
      $d = json_decode($_POST["id"], TRUE);
      // print_r($d);
      $this->id = $d["id"];
      $this->type = $d["type"];

      checkPosts2($GLOBALS['va']);
    } else {
      echo fun()->PARAMETER_INVALID();
      exit();
    }
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
    // echo "dd";
    if ($this->type == "group") {
      $v1 = $this->controller->read_permissions_groups_by_group_id($this->id);
    } else
      fun()->UNKOWN_TYPE();


    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      // print_r($c1["data"]);
      return json_encode($c1["data"]);
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
