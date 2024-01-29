<?php

class UserCodesStatusProcessesAttribute
{

  public $name = "user_code_status_processes";
  ///
  public $table_name = "user_code_status_processes";
  public $user_code_status_process_id = "user_code_status_process_id";
  public $user_code = "user_code";
  public $user_code_status_process_status = "user_code_status_process_status";
  public $user_code_status_process_created_at = "user_code_status_process_created_at";
  public $user_code_status_process_updated_at = "user_code_status_process_updated_at";
  //////////
  public $user_codes_attribute;
  function initForignKeys()
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/attribute.php');
    $this->user_codes_attribute = new UserCodesAttribute();
  }
  /////
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

    $this->initForignKeys();
    return json_encode(
      array(
        "$this->user_code_status_process_id" => $data[$i]["$this->user_code_status_process_id"],
        "{$this->user_codes_attribute->name}" => json_decode($this->user_codes_attribute->jsonF($data, $i)),
        "$this->user_code_status_process_status" => $data[$i]["$this->user_code_status_process_status"],
        "$this->user_code_status_process_created_at" => $data[$i]["$this->user_code_status_process_created_at"],
        "$this->user_code_status_process_updated_at" => $data[$i]["$this->user_code_status_process_updated_at"],
      )
    );
  }

  function NATIVE_INNER_JOIN(): string
  {
    $inner = "INNER JOIN {$this->table_name} ON {$this->table_name}.{$this->user_code_status_process_id}";
    return $inner;
  }

}
?>