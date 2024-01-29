<?php
class IpsAttribute
{
    public $name = "ip";
    public $table_name = "ips";
    public $ip = "ip";
    public $ip_created_at = "ip_created_at";

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
                "$this->ip" => $data[$i]["$this->ip"],
                "$this->ip_created_at" => $data[$i]["$this->ip_created_at"]
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->ip);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        return "";
    }

}
?>