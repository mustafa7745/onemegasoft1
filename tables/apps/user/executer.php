<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/user/sql.php');
class User_AppsExecuter extends User_AppsSql
{


  function execute_read_sql(): string
  {
    $sql = $this->read_sql();
    $this->initJson();
    // print_r($sql);
    return shared_execute_read_sql($sql,$this->json);
  }
  function execute_read_by_group_id_sql($group_id): string
  {
    $sql = $this->read_by_group_id_sql("'$group_id'");
    $this->initJson();
    // print_r($sql);
    return shared_execute_read_sql($sql,$this->json);
  }


}
?>