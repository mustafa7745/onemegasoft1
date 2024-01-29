<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/verification_codes/anonymous/sql.php');
class Anonymous_VerificationCodesExecuter extends Anonymous_VerificationCodesSql
{
 
  function execute_insert_sql($verification_code_id,$verification_code_data, $mycode_id, $user_phone, $device_app_ip_session_id): string
  {
    $sql = $this->insert_sql("'$verification_code_id'","'$verification_code_data'", "'$mycode_id'", "'$user_phone'", "'$device_app_ip_session_id'");
    // echo $sql;
    return shared_execute_insert_sql($sql);
  }
  function execute_read_row_sql($mycode_id, $user_phone, $device_app_ip_session_id): string
  {
    $sql = $this->read_row_sql("'$mycode_id'", "'$user_phone'", "'$device_app_ip_session_id'");
    // echo $sql;
    $this->initJson();
    return shared_execute_read_sql($sql,$this->json);
  }
  function execute_read_row_sql2($verification_code_data): string
  {
    $sql = $this->read_row_sql2("'$verification_code_data'");
    $this->initJson();
    return shared_execute_read_sql($sql,$this->json);
  }
  function execute_update_verification_code_sql($verification_code_data, $verification_code_id): string
  {
    $sql = $this->update_verification_code_sql("'$verification_code_data'", "'$verification_code_id'");
    print_r($sql);
    return shared_execute_update_sql($sql);
  }
  function execute_update_updated_at_sql($verification_code_id): string
  {
    $sql = $this->update_updated_at_sql("'$verification_code_id'");
    // print_r($sql);
    return shared_execute_update_sql($sql);
  }
  function execute_read_device_request_count_for_one_day_sql($device_id): string
  {
    $sql = $this->read_device_request_count_for_one_day_sql("'$device_id'");
    // print_r($sql);
    return shared_execute_read_one_sql($sql);
  }

  function differentTime($large, $small): bool
  {
    $CURRENT_TIMESTAMP = strtotime($large);
    $verification_code_updated_at = strtotime($small);
    $diff = $CURRENT_TIMESTAMP - $verification_code_updated_at;
    // echo $diff;
      return $diff > 600;


  }
}
?>