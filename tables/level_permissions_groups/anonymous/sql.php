<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions_groups/attribute.php');
class Anonymous_PermissionsSql extends MainSqlPermissions{
    
    function read_id_sql($permission_name): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_name = $permission_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>