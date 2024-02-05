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
  public $ids;
  public $count;

  function __construct()
  {
    $this->shared_post_level = new SharedPostLevel();
    array_push($GLOBALS['va'], "ids");
    checkPosts2($GLOBALS['va']);
    $v1 = check_deleted_ids();
    $c1 = json_decode($v1, true);
    $c1 = json_decode($c1['data'], True);
    $this->ids = $c1['ids'];
    $this->count = $c1['count'];

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
    $this->init();
    sleep(5);
    $v1 = $this->controller->delete_permissions_groups($this->ids);
    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      // print_r($c1["data"]);
      return "";
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
