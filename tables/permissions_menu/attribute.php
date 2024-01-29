<?php
class PermissionsMenuAttribute
{

    public $name = "permissions_menu";
    public $table_name = "permissions_menu";
    public $permission_menu_id = "permission_menu_id";
    public $permission_id = "permission_id";
    public $level_permission_id = "level_permission_id";
    public $specified_id = "specified_id";
    public $block_type_id = "block_type_id";
    public $app_id = "app_id";
    ////////

    public $level_permissions_attribute;
    public $apps_attribute;
    public $block_types_attribute;
    public $permissions_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/block_types/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');

        $this->permissions_attribute = new PermissionsAttribute();
        $this->level_permissions_attribute = new LevelPermissionsAttribute();
        $this->apps_attribute = new AppsAttribute();
        $this->block_types_attribute = new BlockTypesAttribute();


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
                "$this->permission_menu_id" => $data[$i]["$this->permission_menu_id"],
                "{$this->apps_attribute->name}" => json_decode($this->apps_attribute->jsonF($data, $i)),
                "{$this->level_permissions_attribute->name}" => json_decode($this->level_permissions_attribute->jsonF($data, $i)),
                "{$this->block_types_attribute->name}" => json_decode($this->block_types_attribute->jsonF($data, $i)),
                "{$this->permissions_attribute->name}" => json_decode($this->permissions_attribute->jsonF($data, $i)),
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->permission_menu_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkey();
        ///////
        $inner =
            FORIGN_KEY_ID_INNER_JOIN($this->permissions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->permission_id)
            . " " .
            $this->permissions_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->block_types_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->block_type_id)
            . " " .
            $this->block_types_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->apps_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->app_id)
            . " " .
            $this->apps_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->level_permissions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->level_permission_id)
            . " " .
            $this->level_permissions_attribute->INNER_JOIN();
        return $inner;
    }



}
?>