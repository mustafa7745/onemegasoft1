<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_update_operations/main_sql.php');

class Whatsapp_UserUpdateOperationsSql extends MainSqlUserUpdateOperations
{

    function insert_sql($user_code, $device_app_session_id, $user_update_operation_pre_value, $user_update_operation_post_value): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->user_code`,`$this->device_app_session_id`,`$this->user_update_operation_pre_value`,`$this->user_update_operation_post_value`)";
        $values = "($user_code,
        $device_app_session_id,
        $user_update_operation_pre_value,$user_update_operation_post_value)";
        return shared_insert_sql($table_name, $columns, $values);
    }

}
?>