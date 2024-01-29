<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/verification_codes/whatsapp/sql.php');
class Whatsapp_VerificationCodesExecuter extends Whatsapp_VerificationCodesSql
{
 
  
  function execute_read_row_sql($verification_code_id, $fun): string
  {
    $sql = $this->read_row_sql("'$verification_code_id'");
    // echo $sql;
    $this->initJson();
    return shared_execute_read_one_json_sql($sql,$this->json);
  }
  function execute_delete_row_sql($verification_code_id, $fun): string
  {
    $sql = $this->delete_row_sql("'$verification_code_id'");
    // print_r($sql);
    return shared_execute_more_sql(array($sql));
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