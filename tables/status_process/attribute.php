<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/shared/shared_sql.php');
////
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/attribute.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
class StatusProcessAttribute
{
    public $name = "status_process";
    public $table_name = "status_process";
    public $status_process_id = "status_process_id";
    public $app_id = "app_id";
    public $mycode_id = "mycode_id";
    public $status_process_is_under_maintenance = "status_process_is_under_maintenance";
    public $required_version = "required_version";
    ////forign table attribute
    public $apps_attribute;
    public $mycodes_attribute;

    /////json attribute
    public $json;

    function initForignkey()
    {
        $this->apps_attribute = new AppsAttribute();
        $this->mycodes_attribute = new MyCodesAttribute();
    }
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
                "$this->status_process_id" => $data[$i]["$this->status_process_id"],
                "{$this->apps_attribute->name}" => $this->apps_attribute->jsonF($data, $i),
                "{$this->mycodes_attribute->name}" => $this->mycodes_attribute->jsonF($data, $i),
                "$this->status_process_is_under_maintenance" => $data[$i]["$this->status_process_is_under_maintenance"],
                "$this->required_version" => $data[$i]["$this->required_version"],
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
            FORIGN_KEY_ID_INNER_JOIN($this->apps_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->app_id)
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($$this->mycodes_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->mycode_id);
        return $inner;
    }

}
?>