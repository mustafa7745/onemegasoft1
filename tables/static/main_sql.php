<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/attribute.php');
class MainSqlStatic extends StaticAttribute
{
    function r_value_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->value}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
    function r_domain_sql():String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->value}";
        /////
        return read_by_condition_sql($table_name, $column, " ", "{$this->table_name}.$this->key = 'domain'");
    } 
  
}
?>