<?php
class DevicesSessionsAttribute
{

    public $name = "device_session";
    public $table_name = "devices_sessions";
    public $device_session_id = "device_session_id";
    public $device_id = "device_id";
    public $app_id = "app_id";
    public $device_app_token = "device_app_token";
    public $device_session_status = "device_session_status";
    public $device_session_created_at = "device_session_created_at";
    public $device_session_updated_at = "device_session_updated_at";
    //////////
    public $devcies_attribute;
    public $apps_attribute;

    function initForignkeys()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
        $this->devcies_attribute = new DevicesAttribute();
        $this->apps_attribute = new AppsAttribute();
    }
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
        $this->initForignkeys();
        return json_encode(
            array(
                "$this->device_session_id" => $data[$i]["$this->device_session_id"],
                "{$this->devcies_attribute->name}" => json_decode($this->devcies_attribute->jsonF($data, $i)),
                "{$this->apps_attribute->name}" => json_decode($this->apps_attribute->jsonF($data, $i))
            )
        );
    }
    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->device_session_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkeys();
        ///////
        $inner =
            FORIGN_KEY_ID_INNER_JOIN($this->devcies_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_id)
            . " " .
            $this->devcies_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->apps_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->app_id)
            . " " .
            $this->apps_attribute->INNER_JOIN();

        return $inner;
    }




}
?>