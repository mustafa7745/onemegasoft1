<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps_groups/attribute.php');
class MainSqlAppsGroups extends AppsGroupsAttribute
{
    function r_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = " * ";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
  
   
}
?>