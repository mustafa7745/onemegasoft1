<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/main_sql.php');
class User_PermissionsSql extends MainSqlPermissions
{

    function read_sql($offset): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "1";
        /////
        return $this->r_sql($innerJoin, $condition, $offset);
    }
    function read_one_by_id_sql($permission_id): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_id = $permission_id";
        /////
        return $this->r_sql($innerJoin, $condition, "0");
    }
    function read_in_sql($ids): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_id IN ($ids)";
        /////
        return $this->r_in_sql($innerJoin, $condition);
    }
    function search_by_name_for_add_to_pg_sql($search, $offset, $group_id): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/user/sql.php');
        $user_permission_group_sql = new User_PermissionsGroupsSql();
        $permission_ids = $user_permission_group_sql->read_permission_ids_by_group_id_sql($group_id);

        $innerJoin = "";
        $condition = "$this->permission_name LIKE '%$search%' AND $this->permission_id NOT IN ($permission_ids)";
        /////
        return $this->r_sql($innerJoin, $condition, $offset);
    }
    function add_permission_sql($permission_id, $permission_name): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $table_name = $this->table_name;
        $columns = "(`$this->permission_id`,`$this->permission_name`)";
        $values = "($permission_id,$permission_name)";
        /////
        return shared_insert_sql($table_name, $columns, $values);
    }
    function readOneJson($id): string
    {

        return "(SELECT JSON_OBJECT('$this->permission_id',$this->permission_id,
         '$this->permission_name', $this->permission_name)
         FROM $this->table_name WHERE $this->permission_id = $id)
         ";

    }
    function read_name_json_sql($id): string
    {

        return "(SELECT JSON_OBJECT(
         '$this->permission_name', $this->permission_name)
         FROM $this->table_name WHERE $this->permission_id = $id)
         ";

    }
    function search_by_name_sql($search, $offset): string
    {

        $innerJoin = "";
        $condition = "$this->permission_name LIKE '%$search%'";
        /////
        return $this->r_sql($innerJoin, $condition, $offset);
    }
    function delete_sql($ids): string
    {
        $condition = "$this->permission_id IN ($ids)";
        /////
        return $this->d_sql($condition);
    }
    function update_name_sql($name, $id): string
    {
        $set_query = "SET $this->permission_name = $name";
        $condition = "$this->permission_id = $id";
        /////
        return $this->upd_sql($set_query, $condition);
    }
}
