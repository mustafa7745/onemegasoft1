<?php
class DevicesTypesAttribute
{
    public $name = "device_type";
    public $table_name = "devices_types";
    public $device_type_id = "device_type_id";
    public $device_type_name = "device_type_name";
    public $device_type_created_at = "device_type_created_at";
    public $device_type_updated_at = "device_type_updated_at";
   

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
       
      
        return json_encode(
            array(
                "$this->device_type_id" => $data[$i]["$this->device_type_id"],
                "$this->device_type_name" => $data[$i]["$this->device_type_name"],
                "$this->device_type_created_at" => $data[$i]["$this->device_type_created_at"],
                "$this->device_type_updated_at" => $data[$i]["$this->device_type_updated_at"],
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->device_type_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
       return "";
    }

}
?>