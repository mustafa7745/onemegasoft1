<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/whatsapp/sql.php');

class Whatsapp_UserCodesExecuter extends Whatsapp_UserCodesSql
{

  function execute_read_status_sql($user_id, $app_id, $mycode_name): string
  {
    $sql = $this->read_status_sql("'$user_id'","'$app_id'", "'$mycode_name'");
    // print_r($sql);
    return shared_execute_read_one_sql($sql);
  }


}
?>