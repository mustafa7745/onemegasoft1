<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/anonymous/sql.php');
class Anonymous_DevicesSessionsIpsExecuter extends Anonymous_DevicesSessionsIpsSql
{

    function execute_insert_sql($device_session_ip_id, $device_session_id, $ip): ResultData
    {
        $sql = $this->insert_sql("'$device_session_ip_id'", "'$device_session_id'", "'$ip'");
        return shared_execute_insert_server_sql($sql);
    }

}
?>