<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/attribute.php');
class MainSqlGroups extends GroupsAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->group_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
    function r_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = " * ";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>