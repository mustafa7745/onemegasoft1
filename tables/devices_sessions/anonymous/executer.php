<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/anonymous/sql.php');
class Anonymous_DevicesSessionsExecuter extends Anonymous_DevicesSessionsSql
{

  function execute_insert_sql($device_app_session_id, $device_id, $app_id, $device_app_token): string
  {
    $sql = $this->insert_sql("'$device_app_session_id'", "'$device_id'", "'$app_id'", "'$device_app_token'");
    return shared_execute_insert_sql($sql);
  }

  function execute_update_token_sql($device_id, $app_id, $device_app_token): string
  {
    $sql = $this->update_token_sql("'$device_id'", "'$app_id'", "'$device_app_token'");
    return shared_execute_update_sql($sql);
  }

  function execute_read_limit_sql($device_id, $app_id): string
  {
    $sql = $this->read_limit_sql("'$device_id'", "'$app_id'");
    $this->initJson();
    return shared_execute_read_sql($sql,$this->json);
  }


}
?>