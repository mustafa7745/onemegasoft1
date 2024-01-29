<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/main_sql.php');

class Whatsapp_UsersSql extends MainSqlUsers
{
    function insert_sql($user_id, $user_name, $user_phone, $user_password, $user_2fa_password): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->user_id`,`$this->user_name`,`$this->user_phone`,`$this->user_password`,`$this->user_2fa_password`)";
        $values = "($user_id,$user_name, $user_phone,SHA2($user_password,512),SHA2($user_2fa_password,512))";
        // print_r(shared_insert_sql($table_name, $columns, $values));
        return shared_insert_sql($table_name, $columns, $values);
    }

    function read_id_sql($user_phone): string
    {
        $innerJoin = "";
        $condition = "$this->user_phone = $user_phone";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }

    
    function update_update_user_2fa_password_sql($user_id, $user_2fa_password)
    {
        // return "UPDATE `$this->table_name`SET $this->device_info = $device_info  WHERE $this->device_id = $device_id";
        $table_name = $this->table_name;
        $set_query = "SET $this->user_2fa_password = SHA2($user_2fa_password,512)";
        $condition = "$this->user_id = $user_id";
        return shared_update_sql($table_name, $set_query, $condition);
    }

}
?>