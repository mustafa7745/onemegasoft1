<?php
 require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_code_status_processes/attribute.php');
class MainSqlUserCodesStatusProcesses extends UserCodesStatusProcessesAttribute
{
    function r_status_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->user_code_status_process_status} as status";
        // print_r($column);
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }
}
?>