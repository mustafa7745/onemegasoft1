<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/attribute.php');
class MainSqlPermissionsGroups extends PermissionsGroupsAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_group_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
    function r_permission_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
    function r_sql($innerJoin, $condition):String{
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/anonymous/sql.php');
        $anonymous_static_sql = new Anonymous_StaticSql();
        // 
        $table_name = $this->table_name;
        $column = " * "." , " . $anonymous_static_sql->read_path_icon_app_sql("'path_icon_app'");
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
   
}
?>