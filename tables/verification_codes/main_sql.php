<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/verification_codes/attribute.php');
class MainSqlVerificationCodes extends VerificationCodesAttribute
{
    function r_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->verification_code_id}";
        // print_r($column);
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_row_sql($innerJoin, $condition): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/anonymous/sql.php');
        $anonymous_static_sql = new Anonymous_StaticSql();

        $table_name = $this->table_name;
        $column = " * , CURRENT_TIMESTAMP , ".$anonymous_static_sql->read_path_icon_app_sql("'path_icon_app'");
        // print_r($column);
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    ///Security
    // Device Request
    function r_device_request_count_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "COUNT(*) as count";
        // print_r($column);
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    // function r_app_type_id_sql($innerJoin, $condition): string
    // {
    //     $table_name = $this->table_name;
    //     $column = "{$this->table_name}.{$this->app_type_id}";
    //     /////
    //     return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    // }
    // function r_status_sql($innerJoin, $condition): string
    // {
    //     $table_name = $this->table_name;
    //     $column = "{$this->table_name}.{$this->app_status}";
    //     /////
    //     return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    // }
}
?>