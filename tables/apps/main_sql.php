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
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/anonymous/sql.php');
        $anonymous_static_sql = new Anonymous_StaticSql();
        // 
        $table_name = $this->table_name;
        $column = " * "." , " . $anonymous_static_sql->read_path_icon_app_sql("'path_icon_app'");
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