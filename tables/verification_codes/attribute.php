<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/shared/shared_sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/shared/shared_executer.php');
/////

class VerificationCodesAttribute
{
    ////Name
    public $name = "verification_code";
    ////Table Attribute
    public $table_name = "verification_codes";
    public $verification_code_id = "verification_code_id";
    public $verification_code_data = "verification_code_data";
    public $device_app_ip_session_id = "device_app_ip_session_id";
    public $user_phone = "user_phone";
    public $mycode_id = "mycode_id";
    public $verification_code_created_at = "verification_code_created_at";
    public $verification_code_updated_at = "verification_code_updated_at";
    ///////
    public $CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP";
    /////json attribute
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
        // echo "df";
        $this->initForignKeys();
        return json_encode(
            array(
                "$this->verification_code_id" => $data[$i]["$this->verification_code_id"],
                "$this->verification_code_data" => $data[$i]["$this->verification_code_data"], 
                "{$this->device_app_ip_sessions_attribute->name}" => json_decode($this->device_app_ip_sessions_attribute->jsonF($data, $i)),
                "$this->user_phone" => $data[$i]["$this->user_phone"],
                "{$this->mycodes_attribute->name}" => json_decode($this->mycodes_attribute->jsonF($data, $i)),
                "$this->verification_code_created_at" => $data[$i]["$this->verification_code_created_at"],
                "$this->verification_code_updated_at" => $data[$i]["$this->verification_code_updated_at"],
                "$this->CURRENT_TIMESTAMP" => $data[$i]["$this->CURRENT_TIMESTAMP"],
            )
        );
    }

    ///Forign Keys
    public $mycodes_attribute;
    public $device_app_ip_sessions_attribute;
    function initForignKeys()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/device_app_ip_sessions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/attribute.php');
        $this->mycodes_attribute = new MyCodesAttribute();
        $this->device_app_ip_sessions_attribute = new DeviceAppIpSessionsAttribute();
    }


    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->verification_code_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignKeys();
        $inner = FORIGN_KEY_ID_INNER_JOIN($this->mycodes_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->mycode_id)
        . " " .
        $this->mycodes_attribute->INNER_JOIN()
        . " " .
        FORIGN_KEY_ID_INNER_JOIN($this->device_app_ip_sessions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_app_ip_session_id)
        . " " .
        $this->device_app_ip_sessions_attribute->INNER_JOIN();
        return $inner;
    }
}
?>