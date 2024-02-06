<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/user/sql.php');
class User_PermissionsGroupsExecuter extends User_PermissionsGroupsSql
{


  function execute_read_by_group_id_sql($group_id): string
  {
    $sql = $this->read_by_group_id_sql("'$group_id'");
    $this->initJson();
    // print_r($sql);
    return shared_execute_read_sql($sql,$this->json);
  }
  function execute_delete_sql($ids): string
  {
    $sql = $this->delete_sql($ids);
    // print_r($sql);
    return shared_execute_delete_sql($sql);
  }
  function execute_add_sql($permission_id, $group_id): string
  {
    $sql = $this->add_sql("'$permission_id'", "'$group_id'");
    return shared_execute_insert_sql($sql);
  }


}
?>