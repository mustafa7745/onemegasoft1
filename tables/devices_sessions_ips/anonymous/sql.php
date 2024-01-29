<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/main_sql.php');
///

class Anonymous_DevicesSessionsIpsSql extends MainSqlDevicesSessionsIps
{
    function read_id_sql($device_session_id, $ip): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->device_session_id = $device_session_id and $this->ip = $ip";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
    function insert_sql($device_session_ip_id, $device_session_id, $ip): string
    {
        $table_name = $this->table_name;
        $columns = "(`$this->device_session_ip_id`,`$this->device_session_id`,`$this->ip`) ";
        $values = "($device_session_ip_id,$device_session_id,$ip)";
        return shared_insert_sql($table_name, $columns, $values);
    }

}
?>