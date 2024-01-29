<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/status_process/attribute.php');
class MainSqlStatusProcess extends StatusProcessAttribute
{
    function r_is_under_maintenance($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->status_process_is_under_maintenance}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 

    function r_required_version($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->required_version}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
    
}
?>