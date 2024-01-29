<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_open_app/init_device_session_ip/executer.php");
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
    checkPosts1($GLOBALS['va']);
  }
  function init()
  {
    $this->shared_post_level->init_shared_post_level1();
    $this->controller = new CheckingInitDeviceSessionIp(
      $this->shared_post_level->app_package_name,
      $this->shared_post_level->sha,
      $this->shared_post_level->app_version,
      $this->shared_post_level->device_type_name,
      $this->shared_post_level->device_id,
      $this->shared_post_level->device_info,
      $this->shared_post_level->app_device_token,
      fun()
    );
    // $this->controller->initUserAttr( $user_phone, $user_password);


  }

  function main(): string
  {
    $this->init();
    // sleep(2);
    $v1 = $this->controller->check();
    $c1 = json_decode($v1);
    if ($c1->result) {
      return $v1;
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();

?>