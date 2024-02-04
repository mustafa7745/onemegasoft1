<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/main_sql.php');
class User_PermissionsGroupsSql extends MainSqlPermissionsGroups{
    
    function read_id_sql($permission_id,$group_id): string
    {
        $innerJoin = "";
        $condition = "$this->group_id = $group_id and $this->permission_id = $permission_id";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
    function read_permissions_ids_sql($group_id): string
    {
        $innerJoin = "";
        $condition = "$this->group_id = $group_id";
        /////
        return $this->r_permission_id_sql($innerJoin, $condition);
    }
}
?>