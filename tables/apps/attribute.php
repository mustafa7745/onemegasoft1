<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/shared/shared_sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/shared/shared_executer.php');
/////

class AppsAttribute
{
    ////Name
    public $name = "app";
    ////Table Attribute
    public $table_name = "apps";
    public $app_id = "app_id";
    public $app_name = "app_name";
    public $app_package_name = "app_package_name";
    public $app_sha256 = "app_sha256";
    public $device_type_id = "device_type_id";
    public $app_icon = "app_icon";
    public $app_version = "app_version";
    public $user_id = "user_id";
    public $group_id = "group_id";
    public $app_created_at = "app_created_at";
    public $app_updated_at = "app_updated_at";
    /////json attribute
    public $devices_types_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_types/attribute.php');
        $this->devices_types_attribute = new DevicesTypesAttribute();

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
        $this->initForignkey();
        return json_encode(
            array(
                "$this->app_id" => $data[$i]["$this->app_id"],
                "$this->app_name" => $data[$i]["$this->app_name"],
                "$this->app_package_name" => $data[$i]["$this->app_package_name"],
                "$this->app_sha256" => $data[$i]["$this->app_sha256"],
                "{$this->devices_types_attribute->name}" => json_decode($this->devices_types_attribute->jsonF($data, $i)),
                "$this->app_icon" => $data[$i]["path_icon"] . $data[$i]["$this->app_icon"],
            )
        );
    }
    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->app_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkey();
        ///////
        $inner =
            FORIGN_KEY_ID_INNER_JOIN($this->devices_types_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_type_id)
            . " " .
            $this->devices_types_attribute->INNER_JOIN();
        return $inner;
    }
}
?>