<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_types/attribute.php');
class MainSqlDevicesTypes extends DevicesTypesAttribute
{
    function r_name_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_type_name}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
    
}
?>