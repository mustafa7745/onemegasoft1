<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/main_sql.php');
///

class Anonymous_DevicesSessionsSql extends MainSqlDevicesSessions
{

    function insert_sql($device_session_id, $device_id, $app_id, $device_app_token): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->device_session_id`,`$this->device_id`,`$this->app_id`,`$this->device_app_token`) ";
        $values = "($device_session_id,$device_id,$app_id,$device_app_token)";
        return shared_insert_sql($table_name, $columns, $values);
    }

    function update_token_sql($device_id, $app_id, $device_app_token)
    {
        $table_name = $this->table_name;
        $set_query = "SET $this->device_app_token = $device_app_token";
        $condition = "$this->device_id = $device_id and $this->app_id = $app_id";
        return shared_update_sql($table_name, $set_query, $condition);
    }
    // function update_count_request_sql($device_app_session_id)
    // {
    //     $table_name = $this->table_name;
    //     $set_query = "SET $this->device_app_session_count_request = $this->device_app_session_count_request + 1";
    //     $condition = "$this->device_app_session_id = $device_app_session_id";
    //     return shared_update_sql($table_name, $set_query, $condition);
    // }

    function read_status_sql($device_id, $app_id): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->device_id = $device_id and $this->app_id = $app_id";
        /////
        return $this->r_status_sql($innerJoin, $condition);
    }
    function read_id_sql($device_id, $app_id): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->device_id = $device_id and $this->app_id = $app_id";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
   
    function read_token_sql($device_id, $app_id): string
    {
        $innerJoin = "";
        $condition = "$this->device_id = $device_id and $this->app_id = $app_id";
        /////
        return $this->r_token_sql($innerJoin, $condition);
    }

    function read_limit_sql($device_id, $app_id): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->table_name.$this->device_id = $device_id and $this->table_name.$this->app_id = $app_id LIMIT 0,1";
        /////
        // print_r($this->r_limit_sql($innerJoin, $condition));
        return $this->r_limit_sql($innerJoin, $condition);
    }



}
?>