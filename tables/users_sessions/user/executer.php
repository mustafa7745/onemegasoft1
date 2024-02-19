<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/user/sql.php');
class User_UsersSessionsExecuter extends User_UsersSessionsSql
{

  function execute_insert_sql($user_session_id, $user_id, $device_session_id, $fun): ResultData
  {
    $sql = $this->insert_sql("'$user_session_id'","'$user_id'", "'$device_session_id'");
    return shared_execute_insert_server_sql($sql);
  }
 
}
?>