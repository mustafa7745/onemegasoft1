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
    function r_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = " * ";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }

}
?>