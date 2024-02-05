<?php
$root = "onemegasoft1";
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/app/on_login/permissions/executer.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/api/shared/shared_post_level.php");
/////////////////

class ThisClass
{
  // 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
  public $controller;
  public $shared_post_level;
  // 
  public $search;
  public $searchBy;

  function __construct()
  {
    $this->shared_post_level = new SharedPostLevel();
    if (isset($_POST["search"]) && $_POST["search"] != null) {
      array_push($GLOBALS['va'], "search");
      check_search($_POST["search"]);
      $d = json_decode($_POST["search"], TRUE);
      $this->search = $d["search"];
      $this->searchBy = $d["searchBy"];
    }
    checkPosts2($GLOBALS['va']);
  }
  function init()
  {
    // echo "dd";
    $this->shared_post_level->init_shared_post_level2();
    // echo "dd";
    $this->controller = new Permissions(
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
    $v1 = null;
    $this->init();
    // sleep(1);
    if ($this->search != null) {
      // echo $this->controller->id;
      if ($this->searchBy == "name") {
        $v1 = $this->controller->search_by_name($this->search);
      } else {
        return fun()->UNKOWN_TYPE_SEARCH();
      }
    } else {

      $v1 = $this->controller->read_permissions();
    }

    $c1 = json_decode($v1, true);
    if ($c1["result"]) {

      return json_encode($c1["data"]);
    }
    return $v1;
  }
}

$this_class = new ThisClass();
echo $this_class->main();
