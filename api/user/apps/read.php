<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/apps/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_post_level.php");
/////////////////

class ThisClass
{
  // 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
  public $controller;
  public $shared_post_level;

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
    $this->controller = new Apps(
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

  function main(): string
  {
    $this->init();
    // sleep(1);
    // echo "dd";
    $v1 = $this->controller->read();
    $c1 = json_decode($v1,true);
      if ( $c1["result"]) {
        return json_encode($c1["data"]);
      }
      return $v1;
    }
}

$this_class = new ThisClass();
echo $this_class->main();