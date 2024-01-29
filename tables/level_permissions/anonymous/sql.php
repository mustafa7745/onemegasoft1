<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/main_sql.php');
class Anonymous_LevelPermissionsSql extends MainSqlLevelPermissions{
    
    function read_id_sql($level_permission_name): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->level_permission_name = $level_permission_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>