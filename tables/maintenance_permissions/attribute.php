<?php
class MaintenancePermissionsAttribute
{

    public $name = "maintenance_permission";
    public $table_name = "maintenance_permissions";
    public $maintenance_permission_id = "maintenance_permission_id";
    public $permission_id = "permission_id";
    public $block_type_id = "block_type_id";
    public $app_id = "app_id";
    public $maintenance_permission_status = "maintenance_permission_status";

    public $block_types_attribute;
    public $apps_attributre;
    public $permissions_attribute;
    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/block_types/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/attribute.php');

        //  
        $this->block_types_attribute = new BlockTypesAttribute();
        $this->apps_attributre = new AppsAttribute();
        $this->permissions_attribute = new PermissionsAttribute();

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

        return json_encode(
            array(
                "$this->maintenance_permission_id" => $data[$i]["$this->maintenance_permission_id"],
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->maintenance_permission_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        return "";
    }



}
?>