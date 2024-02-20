<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/attribute.php');
class MainSqlUsersSessions extends UsersSessionsAttribute
{
    function r_id_sql($innerJoin, $condition): string
    {
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->user_session_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    }

}
?>