<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
class MainSqlApps extends AppsAttribute
{
    function r_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->app_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = " * ";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_device_type_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_type_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_group_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->group_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_version_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->app_version}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
}
?>