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
  public $group_id;
  public $permission_id;

  function __construct()
  {
    $this->shared_post_level = new SharedPostLevel();

    array_push($GLOBALS['va'], "group_id");
    array_push($GLOBALS['va'], "permission_id");

    // 
    if (isset($_POST["group_id"]) && $_POST["group_id"] != null && isset($_POST["permission_id"]) && $_POST["permission_id"] != null) {
    //  echo"gg";
      $this->group_id = $_POST["group_id"];
     $this->permission_id = $_POST["permission_id"];
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
    sleep(5);
    // echo "dd";
      $v1 = $this->controller->add_permission_group($this->permission_id,$this->group_id);
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
