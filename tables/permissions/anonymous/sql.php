<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/main_sql.php');
class Anonymous_PermissionsSql extends MainSqlPermissions{
    
    function read_id_sql($permission_name): string
    {
        $innerJoin = "";
        $condition = "$this->permission_name = $permission_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);

    }
    // function read_is_under_maintenance($permission_name): string
    // {
    //     $innerJoin = "";
    //     $condition = "$this->permission_name = $permission_name";
    //     /////
    //     return $this->r_is_under_maintenance($innerJoin, $condition);

    // }

    // function read_required_version($permission_name): string
    // {
    //     $innerJoin = "";
    //     $condition = "$this->permission_name = $permission_name";
    //     /////
    //     return $this->r_required_version($innerJoin, $condition);

    // }
}
?>