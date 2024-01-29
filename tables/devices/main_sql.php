<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/attribute.php');
class MainSqlDevices extends DevicesAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    
   
    function r_info_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_info}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }

    
}
?>