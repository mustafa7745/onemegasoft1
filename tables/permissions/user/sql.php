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
        return $this->r_sql($innerJoin, $condition,$offset);
    }
    function read_in_sql($in_data): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_id IN ($in_data)";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
    function search_by_name_for_add_to_pg_sql($search,$offset,$group_id): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/user/sql.php');
        $user_permission_group_sql = new User_PermissionsGroupsSql();
        $permission_ids = $user_permission_group_sql->read_permission_ids_by_group_id_sql($group_id);

        $innerJoin = "";
        $condition = "$this->permission_name LIKE '%$search%' AND $this->permission_id NOT IN ($permission_ids)";
        /////
        return $this->r_sql($innerJoin, $condition,$offset);
    }
}
