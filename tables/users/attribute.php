<?php

class UsersAttribute
{

  public $name = "user";
  //////////
  public $table_name = "users";
  public $user_id = "user_id";
  public $user_name = "user_name";
  public $user_phone = "user_phone";
  public $user_password = "user_password";
  public $user_2fa_password = "user_2fa_password";
  public $user_created_at = "user_created_at";
  public $user_updated_at = "user_updated_at";
  //////////
  public $json;
  function initJson()
  {
    $this->json = function ($data, $i) {
      return $this->jsonF($data, $i);
    };
  }
  /////json function
  function jsonF($data, $i)
  {

    return json_encode(
      array(
        "$this->user_id" => $data[$i]["$this->user_id"],
        "$this->user_name" => $data[$i]["$this->user_name"],
        "$this->user_phone" => $data[$i]["$this->user_phone"],
        "$this->user_password" => $data[$i]["$this->user_password"],
        "$this->user_2fa_password" => $data[$i]["$this->user_2fa_password"],
        "$this->user_created_at" => $data[$i]["$this->user_created_at"],
        "$this->user_updated_at" => $data[$i]["$this->user_updated_at"],
      )
    );
  }
  function NATIVE_INNER_JOIN(): string
  {
    $inner = "INNER JOIN {$this->table_name} ON {$this->table_name}.{$this->user_id}";
    return $inner;
  }

  function INNER_JOIN(): string
  {
     
      return "";
  }

}
?>