<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/attribute.php');
class MainSqlDevicesSessions extends DevicesSessionsAttribute
{
    function r_token_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_app_token}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
    function r_limit_sql($innerJoin, $condition):String{
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/anonymous/sql.php');
        $anonymous_static_sql = new Anonymous_StaticSql();
        $table_name = $this->table_name;
        $column = " * "." , " . $anonymous_static_sql->read_path_icon_app_sql("'path_icon_app'");
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 


    
    function r_status_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_session_status}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_session_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>