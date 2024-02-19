<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/sql.php');
class User_PermissionsExecuter extends User_PermissionsSql
{


  function execute_read_sql($offset): ResultData
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
  function execute_search_by_name_for_add_to_pg_sql($search, $offset, $group_id): string
  {
    $sql = $this->search_by_name_for_add_to_pg_sql($search, $offset, "'$group_id'");
    // print_r($sql);
    return shared_execute_read_no_json_sql($sql);
  }
  function execute_add_permission_sql($permission_name): string
  {
    $permission_id = uniqid(rand(), false);
    $sql = $this->add_permission_sql("'$permission_id'", "'$permission_name'");
    // print_r($sql);
    $v1 = shared_execute_insert_sql1($sql);
    $c1 = json_decode($v1, true);
    if ($c1["result"]) {
      $sql = $this->read_one_by_id_sql("'$permission_id'");

      $v1 = shared_execute_read_no_json_sql($sql);
      $c1 = json_decode($v1,true);
      if ($c1["result"]){
        // print_r($c1);
        return fun()->SUCCESS_WITH_DATA($c1["data"][0]) ;
      }
      return fun()->INSERTED_BUT_CANNOT_READ();
    }
    return $v1;
  }

  function execute_search_by_name_sql($search, $offset): string
  {
    $sql = $this->search_by_name_sql($search, $offset);
    // print_r($sql);
    return shared_execute_read_no_json_sql($sql);
  }

  function execute_delete_sql($ids): string
  {
    $sql = $this->delete_sql($ids);
    // print_r($sql);
    return shared_execute_delete_sql($sql);
  }

  function execute_update_name_sql($name, $id): string
  {
    $sql = $this->update_name_sql("'$name'", "'$id'");
    // print_r($sql);
    return shared_execute_delete_sql($sql);
  }
}
?>