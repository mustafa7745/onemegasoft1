<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/user/sql.php');
class User_GroupsExecuter extends User_GroupsSql
{


  function execute_read_sql(): string
  {
    $sql = $this->read_sql();
    $this->initJson();
    return shared_execute_read_no_json_sql($sql);
  }


}
?>