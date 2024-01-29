<?php
class PermissionsGroupsAttribute
{

    public $name = "permission_group";
    public $table_name = "permissions_groups";
    public $permission_group_id = "permission_group_id";
    public $permission_id = "permission_id";
    public $group_id = "group_id";

    public $permissions_attribute;
    public $groups_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/attribute.php');
        $this->groups_attribute = new GroupsAttribute();
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
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->permission_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $inner =
        FORIGN_KEY_ID_INNER_JOIN($this->permissions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->permission_id)
        . " " .
        $this->permissions_attribute->INNER_JOIN()
        . " " .
        FORIGN_KEY_ID_INNER_JOIN($this->groups_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->group_id)
        . " " .
        $this->groups_attribute->INNER_JOIN();
    return $inner;
    }



}
?>