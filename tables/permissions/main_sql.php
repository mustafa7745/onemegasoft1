<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/attribute.php');
class MainSqlPermissions extends PermissionsAttribute
{
    function r_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->permission_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);

    }
    function r_sql($innerJoin, $condition,$offset): string
    {
        $table_name = $this->table_name;
        $column = " * ";
        $orederdBy = "$this->permission_created_at";
        $orederdType = "DESC";
        /////
        return read_limit_sql($table_name, $column, $innerJoin,$orederdBy,$orederdType,$offset, $condition);
    }
    function r_in_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = " * ";
        /////
        return read_sql($table_name, $column,$innerJoin, $condition);
    }
   
    function d_sql($condition): string
    {
        $table_name = $this->table_name;
        /////
        return delete_sql($table_name, $condition);
    }
    function upd_sql($set_query,$condition): string
    {
        $table_name = $this->table_name;
        /////
        return shared_update_sql($table_name,$set_query, $condition);
    }

}
?>