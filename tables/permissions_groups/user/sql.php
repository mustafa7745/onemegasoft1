<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/main_sql.php');
class User_PermissionsGroupsSql extends MainSqlPermissionsGroups
{

    function read_permission_ids_by_group_id_sql($group_id): string
    {
        $innerJoin = "";
        $condition = "$this->table_name.$this->group_id = $group_id";
        /////
        return $this->r_permission_id_sql($innerJoin, $condition);
    }

    function read_by_group_id_sql($group_id,$offset): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->table_name.$this->group_id = $group_id";
        /////
        return $this->r_sql($innerJoin, $condition,$offset);
    }
    function read_permissions_ids_sql($group_id): string
    {
        $innerJoin = "";
        $condition = "$this->group_id = $group_id";
        /////
        return $this->r_permission_id_sql($innerJoin, $condition);
    }
    function delete_sql($ids): string
    {
        $condition = "$this->permission_group_id IN ($ids)";
        /////
        return $this->d_sql($condition);
    }
    function add_sql($permission_id, $group_id): string
    {
        $permission_group_id  = uniqid(rand(), false);
        $table_name = $this->table_name;
        $columns = "(`$this->permission_group_id`,`$this->permission_id`,`$this->group_id`)";
        $values = "('$permission_group_id',$permission_id,$group_id)";
        return shared_insert_sql($table_name, $columns, $values);
    }
}
