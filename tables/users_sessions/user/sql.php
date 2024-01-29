<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/main_sql.php');

class User_UsersSessionsSql extends MainSqlUsersSessions
{
    function insert_sql($user_session_id, $user_id, $device_session_id): string
    {
        // return "INSERT INTO $this->table_name (`$this->device_id`,`$this->device_info`) VALUES ($device_id,$device_info)";
        $table_name = $this->table_name;
        $columns = "(`$this->user_session_id`,`$this->user_id`,`$this->device_session_id`)";
        $values = "($user_session_id,$user_id,$device_session_id)";
        // print_r(shared_insert_sql($table_name, $columns, $values));
        return shared_insert_sql($table_name, $columns, $values);
    }


}
?>