<?php

class UsersSessionsAttribute
{

  public $name = "user_session";
  //////////
  public $table_name = "users_sessions";
  public $user_session_id = "user_session_id";
  public $user_id = "user_id";
  public $device_session_id = "device_session_id";
  public $user_session_created_at = "user_session_created_at";
  //////////
  public $json;
  function initJson()
  {
    $this->json = function ($data, $i) {
      return $this->jsonF($data, $i);
    };
  }
  // 
  public $users_attribute;
  public $devices_sessions_attribute;

  function initForignkey()
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/attribute.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/attribute.php');

    $this->users_attribute = new UsersAttribute();
    $this->devices_sessions_attribute = new DevicesSessionsAttribute();

  }
  /////json function
  function jsonF($data, $i)
  {
    $this->initForignkey();

    return json_encode(
      array(
        "$this->user_session_id" => $data[$i]["$this->user_session_id"],
        "{$this->users_attribute->name}" => json_decode($this->users_attribute->jsonF($data, $i)),
        "{$this->devices_sessions_attribute->name}" => json_decode($this->devices_sessions_attribute->jsonF($data, $i)),
      )
    );
  }
  function NATIVE_INNER_JOIN(): string
  {
    $inner = "INNER JOIN {$this->table_name} ON {$this->table_name}.{$this->user_session_id}";
    return $inner;
  }

  function INNER_JOIN(): string
  {
    $this->initForignkey();
    return
      FORIGN_KEY_ID_INNER_JOIN($this->users_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->user_id)
      . " " .
      $this->users_attribute->INNER_JOIN()
      . " " .
      FORIGN_KEY_ID_INNER_JOIN($this->devices_sessions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_session_id)
      . " " .
      $this->devices_sessions_attribute->INNER_JOIN();

    ;
  }

}
?>