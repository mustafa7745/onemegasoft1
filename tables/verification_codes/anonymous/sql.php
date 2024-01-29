<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/verification_codes/main_sql.php');

class Anonymous_VerificationCodesSql extends MainSqlVerificationCodes
{
    function insert_sql($verification_code_id,$verification_code_data, $mycode_id, $user_phone, $device_app_ip_session_id): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->verification_code_id`,`$this->verification_code_data`,`$this->mycode_id`,`$this->user_phone`,`$this->device_app_ip_session_id`)";
        $values = "($verification_code_id,$verification_code_data, $mycode_id,$user_phone,$device_app_ip_session_id)";
        // print_r(shared_insert_sql($table_name, $columns, $values));
        return shared_insert_sql($table_name, $columns, $values);
    }

    function read_row_sql($mycode_id, $user_phone, $device_app_ip_session_id): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->table_name.$this->mycode_id = $mycode_id and $this->table_name.$this->user_phone = $user_phone and $this->table_name.$this->device_app_ip_session_id =$device_app_ip_session_id ";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_row_sql($innerJoin, $condition);
    }
   
    function read_row_sql2($verification_code_data): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->verification_code_data = $verification_code_data";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_row_sql($innerJoin, $condition);
    }

    ///Security
    // Device 
    function read_device_request_count_for_one_day_sql($device_id): string
    {
        $innerJoin = $this->INNER_JOIN();
        $devices_attribute = new DevicesAttribute();
        $condition = "{$devices_attribute->table_name}.{$devices_attribute->device_id} = $device_id  AND CURRENT_DATE = DATE($this->verification_code_created_at)";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_device_request_count_sql($innerJoin, $condition);
    }
    function update_verification_code_sql($verification_code_data, $verification_code_id)
    {
        // return "UPDATE `$this->table_name`SET $this->device_info = $device_info  WHERE $this->device_id = $device_id";
        $table_name = $this->table_name;
        $set_query = "SET $this->verification_code_data = $verification_code_data";
        $condition = "$this->verification_code_id = $verification_code_id";
        return shared_update_sql($table_name, $set_query, $condition);
    }
    function update_updated_at_sql($verification_code_id)
    {
        // return "UPDATE `$this->table_name`SET $this->device_info = $device_info  WHERE $this->device_id = $device_id";
        $table_name = $this->table_name;
        $set_query = "SET $this->verification_code_updated_at = CURRENT_TIMESTAMP";
        $condition = "$this->verification_code_id = $verification_code_id";
        return shared_update_sql($table_name, $set_query, $condition);
    }

}
?>