<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/attribute.php');
class MainSqlLevelPermissions extends LevelPermissionsAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->level_permission_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>