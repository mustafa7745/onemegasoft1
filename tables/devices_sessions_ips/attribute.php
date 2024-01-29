<?php
class DevicesSessionsIpsAttribute
{

    public $name = "device_session_ip";
    public $table_name = "devices_sessions_ips";
    public $device_session_ip_id = "device_session_ip_id";
    public $device_session_id = "device_session_id";
    public $ip = "ip";
    public $device_session_created_at = "device_session_created_at";
    public $device_session_updated_at = "device_session_updated_at";
    //////////
    public $devcies_sessions_attribute;
    public $ips_attribute;

    function initForignkeys()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/attribute.php');
        $this->devcies_sessions_attribute = new DevicesSessionsAttribute();
        $this->ips_attribute = new IpsAttribute();
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
                "$this->device_session_ip_id" => $data[$i]["$this->device_session_ip_id"],
                "$this->device_session_id" => $data[$i]["$this->device_session_id"],
                "{$this->ips_attribute->name}" => json_decode($this->ips_attribute->jsonF($data, $i)),
                "{$this->devcies_sessions_attribute->name}" => json_decode($this->devcies_sessions_attribute->jsonF($data, $i)),

            )
        );
    }
    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->device_session_ip_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkeys();
        ///////
        $inner =
            FORIGN_KEY_ID_INNER_JOIN($this->devcies_sessions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->device_session_id)
            . " " .
            $this->devcies_sessions_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->ips_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->ip)
            . " " .
            $this->ips_attribute->INNER_JOIN();

        return $inner;
    }




}
?>