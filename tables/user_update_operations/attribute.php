<?php
class UserUpdateOperationsAttribute
{

    public $name = "user_update_operation";
    /////
    public $table_name = "user_update_operations";
    public $user_update_operation_id = "user_update_operation_id";
    public $permission_id = "permission_id";
    public $user_session_id = "user_session_id";
    public $updated_id = "updated_id";
    public $user_update_operation_pre_value = "user_update_operation_pre_value";
    public $user_update_operation_post_value = "user_update_operation_post_value";
    public $user_update_operation_created_at = "user_update_operation_created_at";

    /////
    public $user_codes_attribute;
    public $device_app_session_attribute;
    function initForignKeys()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/device_app_sessions/attribute.php');
        $this->user_codes_attribute = new UserCodesAttribute();
        $this->device_app_session_attribute = new DeviceAppSessionsAttribute();
    }
    ////

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
                "$this->user_update_operation_id" => $data[$i]["$this->user_update_operation_id"],
                "{$this->user_codes_attribute->name}" => json_decode($this->user_codes_attribute->jsonF($data, $i)),
                "{$this->device_app_session_attribute->name}" => json_decode($this->device_app_session_attribute->jsonF($data, $i)),
                "$this->user_update_operation_post_value" => $data[$i]["$this->user_update_operation_post_value"],
                "$this->user_update_operation_created_at" => $data[$i]["$this->user_update_operation_created_at"],
            )
        );
    }

    function NATIVE_INNER_JOIN(): string
    {
        $inner = "INNER JOIN {$this->table_name} ON {$this->table_name}.{$this->user_update_operation_id}";
        return $inner;
    }

    function INNER_JOIN(): string
    {
        $this->initForignKeys();
        $inner = FORIGN_KEY_ID_INNER_JOIN($this->user_codes_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->user_code)
            . " " .
            $this->user_codes_attribute->INNER_JOIN();
        return $inner;
    }



}
?>