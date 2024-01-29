<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/attribute.php');
class MainSqlIps extends IpsAttribute
{
    function r_ip_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->ip}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
}
?>