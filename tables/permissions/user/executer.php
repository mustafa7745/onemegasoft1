<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/sql.php');
class User_PermissionsExecuter extends User_PermissionsSql
{


  function execute_read_sql($offset): string
  {
    $sql = $this->read_sql($offset);
    return shared_execute_read_no_json_sql($sql);
  }

  
  function execute_read_permission_from_pg_sql($group_id): string
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/user/sql.php');
    $user_permission_group_sql = new User_PermissionsGroupsSql();
    $in_data = $user_permission_group_sql->read_permissions_ids_sql("'$group_id'");
    $sql = $this->read_in_sql($in_data);
    return shared_execute_read_no_json_sql($sql);
  }
  function execute_search_by_name_for_add_to_pg_sql($search,$offset,$group_id): string
  {
    $sql = $this->search_by_name_for_add_to_pg_sql($search,$offset,"'$group_id'");
    // print_r($sql);
    return shared_execute_read_no_json_sql($sql);
  }

  function execute_search_by_name_sql($search,$offset): string
  {
    $sql = $this->search_by_name_sql($search,$offset);
    // print_r($sql);
    return shared_execute_read_no_json_sql($sql);
  }

}
?>