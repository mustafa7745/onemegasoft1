<?php
class LevelPermissionsGroupsAttribute
{

    public $name = "level_permission_group";
    public $table_name = "level_permissions_groups";
    public $level_permission_group_id = "level_permission_group_id";
    public $level_permission_id = "level_permission_id";
    public $group_id = "group_id";
    ////////

    public $level_permissions_attribute;
    public $groups_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/attribute.php');
        $this->groups_attribute = new GroupsAttribute();
        $this->level_permissions_attribute = new LevelPermissionsAttribute();

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
                "$this->level_permission_group_id" => $data[$i]["$this->level_permission_group_id"],
                "{$this->groups_attribute->name}" => json_decode($this->groups_attribute->jsonF($data, $i)),
                "{$this->level_permissions_attribute->name}" => json_decode($this->level_permissions_attribute->jsonF($data, $i)),
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->level_permission_group_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkey();
        ///////
        $inner =
            FORIGN_KEY_ID_INNER_JOIN($this->level_permissions_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->level_permission_id)
            . " " .
            $this->level_permissions_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->groups_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->group_id)
            . " " .
            $this->groups_attribute->INNER_JOIN();
        return $inner;
    }



}
?>