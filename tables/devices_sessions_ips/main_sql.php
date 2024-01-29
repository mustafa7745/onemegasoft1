<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/attribute.php');
class MainSqlDevicesSessionsIps extends DevicesSessionsIpsAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->device_session_ip_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>