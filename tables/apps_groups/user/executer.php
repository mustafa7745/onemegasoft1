<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps_groups/user/sql.php');
class User_AppsGroupsExecuter extends User_AppsGroupsSql
{


  function execute_read_by_group_id_sql($group_id): string
  {
    $sql = $this->read_by_group_id_sql("'$group_id'");
    $this->initJson();
    // print_r($sql);
    return shared_execute_read_sql($sql,$this->json);
  }


}
?>