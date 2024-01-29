<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/anonymous/sql.php');
class Anonymous_DevicesExecuter extends Anonymous_DevicesSql
{

  function execute_insert_sql($device_id,$device_type_id, $device_info): string
  {
    $sql = $this->insert_sql("'$device_id'","'$device_type_id'", "'$device_info'");
    return shared_execute_insert_sql($sql);
  }
  function execute_update_info_sql($device_id, $device_info): string
  {
    $sql = $this->update_info_sql("'$device_info'", "'$device_id'");
    return shared_execute_update_sql($sql);
  }
}
?>