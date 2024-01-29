<?php
 require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/attribute.php');
class MainSqlUserCodes extends UserCodesAttribute
{
    function r_user_code_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->user_code}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
    function r_status_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->user_code_status} as status";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
}
?>