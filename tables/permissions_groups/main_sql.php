<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/attribute.php');
class MainSqlPermissionsGroups extends PermissionsGroupsAttribute
{
    function r_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_group_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);

    }

    function r_permission_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);

    }
    function r_sql($innerJoin, $condition,$offset): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/anonymous/sql.php');
        $anonymous_static_sql = new Anonymous_StaticSql();
        // 
        $table_name = $this->table_name;
        $column = " * " . " , " . $anonymous_static_sql->read_path_icon_app_sql("'path_icon_app'");
        $orederdBy = "$this->permission_group_created_at";
        $orederdType = "DESC";
        /////
        return read_limit_sql($table_name, $column, $innerJoin,$orederdBy,$orederdType,$offset, $condition);
    }

    function d_sql($condition): string
    {
        $table_name = $this->table_name;
        /////
        return delete_sql($table_name, $condition);
    }

}
?>