<?php
class AppsGroupsAttribute
{

    public $name = "app_group";
    public $table_name = "apps_groups";
    public $app_group_id = "app_group_id";
    public $app_id = "app_id";
    public $group_id = "group_id";

    public $apps_attribute;
    public $groups_attribute;

    function initForignkey()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/attribute.php');
        $this->groups_attribute = new GroupsAttribute();
        $this->apps_attribute = new AppsAttribute();
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
                "{$this->apps_attribute->name}" => json_decode($this->apps_attribute->jsonF($data, $i)),
                "{$this->groups_attribute->name}" => json_decode($this->groups_attribute->jsonF($data, $i))
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->app_group_id);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignkey();
        $inner =
        FORIGN_KEY_ID_INNER_JOIN($this->apps_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->app_id)
        . " " .
        $this->apps_attribute->INNER_JOIN()
        . " " .
        FORIGN_KEY_ID_INNER_JOIN($this->groups_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->group_id)
        . " " .
        $this->groups_attribute->INNER_JOIN();
    return $inner;
    }



}
?>