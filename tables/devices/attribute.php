<?php

class DevicesAttribute
{

    public $name = "device";
    public $table_name = "devices";
    public $device_id = "device_id";
    public $device_type_id = "device_type_id";
    public $device_info = "device_info";
    //////////

    /////json attribute
    public $json;


    function initJson()
    {
        $this->json = function ($data, $i) {
            return $this->jsonF($data, $i);
        };
    }
    ////// 
    public $devices_types_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/device_types/attribute.php');
        $this->devices_types_attribute = new DevicesTypesAttribute();

    }
    /////json function

    function jsonF($data, $i)
    {
        $this->initForignkey();

        return json_encode(
            array(
                "$this->device_id" => $data[$i]["$this->device_id"],
                "{$this->devices_types_attribute->name}" => json_decode($this->devices_types_attribute->jsonF($data, $i)),
                "$this->device_info" => json_decode($data[$i]["$this->device_info"]),
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->device_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkey();
        return
            FORIGN_KEY_ID_INNER_JOIN($this->devices_types_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_type_id)
            ." ".
            $this->devices_types_attribute->INNER_JOIN()
            ;
    }


}
?>