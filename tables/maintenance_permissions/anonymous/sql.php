<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/maintenance_permissions/main_sql.php');
class Anonymous_MaintenancePermissionsSql extends MainSqlMaintenancePermissions{
    
    // function read_id_sql($permission_id,$block_type_id,$app_id): string
    // {
    //     $innerJoin = "";
    //     $condition = "$this->permission_id = $permission_id and $this->block_type_id = $block_type_id and $this->app_id = $app_id";
    //     /////
    //     return $this->r_id_sql($innerJoin, $condition);

    // }
    function read_status_sql($permission_id,$block_type_id,$app_id): string
    {
        $innerJoin = "";
        $condition = "$this->permission_id = $permission_id and $this->block_type_id = $block_type_id and $this->app_id = $app_id";
        /////
        return $this->r_status_sql($innerJoin, $condition);

    }
}
?>