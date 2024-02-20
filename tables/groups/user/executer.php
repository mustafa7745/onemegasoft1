<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/user/sql.php');
class User_GroupsExecuter extends User_GroupsSql
{


  function execute_read_sql(): ResultData
  {
    $sql = $this->read_sql();
    $this->initJson();
    return shared_execute_read_no_json_sql($sql);
  }
  function execute_read_in_sql($ids): string
  {
    $sql = $this->read_in_sql($ids);
    // echo $sql;
    $this->initJson();
    return shared_execute_read_no_json_sql($sql);
  }


}
?>