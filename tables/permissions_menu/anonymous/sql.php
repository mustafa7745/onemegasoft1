<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_menu/main_sql.php');
class Anonymous_PermissionsMenuSql extends MainSqlPermissionsMenu
{

    function read_id1_sql($permission_id, $block_type_id, $level_permission_id, $app_id): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->permission_id = $permission_id and $this->level_permission_id = $level_permission_id  and $this->app_id = $app_id and $this->block_type_id = $block_type_id";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
    function read_id2_sql($permission_id, $block_type_id, $level_permission_id, $specified_id, $app_id): string
    {
        $innerJoin = "";
        $condition = "$this->permission_id = $permission_id and $this->block_type_id = $block_type_id and $this->level_permission_id = $level_permission_id and $this->specified_id = $specified_id and $this->app_id =$app_id ";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>