<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_update_operations/main_sql.php');

class User_UserUpdateOperationsSql extends MainSqlUserUpdateOperations
{
    function insert_sql($permission_id, $user_session_id,$updated_id, $user_update_operation_pre_value ,$user_updatet_operation_post_value ): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->permission_id`,`$this->user_session_id`,`$this->updated_id`,`$this->user_update_operation_pre_value`,`$this->user_update_operation_post_value`)";
        $values = "($permission_id,$user_session_id,$updated_id,$user_update_operation_pre_value,$user_updatet_operation_post_value)";
        return shared_insert_sql($table_name, $columns, $values);
    }
}
?>