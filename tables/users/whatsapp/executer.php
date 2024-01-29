<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/whatsapp/sql.php');
class Whatsapp_UsersExecuter extends Whatsapp_UsersSql
{
  function execute_insert_sql(
    $user_name,
    $user_phone,
    $user_password,
    $user_2fa_password,
    // 
    $sql2
  ): string {
    $user_id = uniqid(rand(), false);
    $sql1 = $this->insert_sql("'$user_id'", "'$user_name'", "'$user_phone'", "'$user_password'", "'$user_2fa_password'");
    return shared_execute_more_sql(array($sql1, $sql2));
  }
  function execute_update_user_2fa_password_sql(
    $user_id,
    $user_2fa_password,
    // 
    $mycode_name,
    $app_id,
    $device_app_session_id,
    // 
    $sql3,
  ): string {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_update_operations/whatsapp/sql.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/whatsapp/sql.php');
    $whatsapp_mycodes_sql = new Whatsapp_MyCodesSql();
    $mycode_id = $whatsapp_mycodes_sql->read_id_sql("'$mycode_name'");

    // 1) Read pre and post value
    $user_update_operation_pre_value = "{}";
    $user_update_operation_post_value = "{}";
    // 2) Update value 
    $sql1 = $this->update_update_user_2fa_password_sql("'$user_id'", "'$user_2fa_password'");
    // 3) Update operation
    $user_code = (new Whatsapp_UserCodesSql())->read_user_code_sql("'$user_id'", "'$app_id'", $mycode_id);
    $sql2 = (new Whatsapp_UserUpdateOperationsSql())->insert_sql($user_code, "'$device_app_session_id'", "'$user_update_operation_pre_value'", "'$user_update_operation_post_value'");
    $sql_array = array($sql1,$sql2, $sql3);
    print_r($sql_array);
    return shared_execute_more_sql($sql_array);
  }
  function execute_read_id_sql($verification_code): string
  {
    $sql = $this->read_id_sql("'$verification_code'");
    return shared_execute_read_one_sql($sql);
  }


}
?>