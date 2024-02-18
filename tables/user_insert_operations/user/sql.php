<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_insert_operations/main_sql.php');

class User_UserInsertOperationsSql extends MainSqlUserInsertOperations
{
    function insert_sql($permission_id, $user_session_id, $device_session_id, $user_insert_operation_values): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->permission_id`,`$this->user_session_id`,`$this->device_session_id`,`$this->user_insert_operation_values`)";
        $values = "($permission_id,
        $user_session_id,
        $device_session_id,
        $user_insert_operation_values)";
        return shared_insert_sql($table_name, $columns, $values);
    }
}
?>