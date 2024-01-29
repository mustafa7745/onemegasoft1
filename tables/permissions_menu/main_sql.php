<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_menu/attribute.php');
class MainSqlPermissionsMenu extends PermissionsMenuAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_menu_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>