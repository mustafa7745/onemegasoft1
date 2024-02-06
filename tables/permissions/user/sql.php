<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/main_sql.php');
class User_PermissionsSql extends MainSqlPermissions
{

    function read_sql($offset): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "";
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
    function search_by_name_sql($search): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_name LIKE '%$search%'";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
}
