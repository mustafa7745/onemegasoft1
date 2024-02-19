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
  function execute_add_permission_sql($permission_name, ResultData $data): ResultData
  {
    $permission_id = uniqid(rand(), false);
    $sql1 = $this->add_permission_sql("'$permission_id'", "'$permission_name'");
    $sql2 = $this->readOneJson("'$permission_id'");
    // print_r($sql);
    $resultData = shared_execute_insert_sql($sql1, $sql2, $data);
    if ($resultData->result) {
      $sql = $this->read_one_by_id_sql("'$permission_id'");
      $resultData1 = shared_execute_read_no_json_sql($sql);
      if ($resultData1) {
        return $resultData1;
      }
      return fun1()->SUCCESS_NO_DATA();
    }
    return $resultData;
  }

  function execute_search_by_name_sql($search, $offset): ResultData
  {
    $sql = $this->search_by_name_sql($search, $offset);
    // print_r($sql);
    return shared_execute_read_no_json_sql($sql);
  }

  function execute_delete_sql($ids, $count, ResultData $data): ResultData
  {

    $sqlRead = $this->read_in_sql($ids);
    $sql1 = $this->delete_sql($ids);

    // print_r($sql);
    return shared_execute_delete_sql($sql1, $sqlRead, $count, $data);
  }

  function execute_update_name_sql($name, $id, ResultData $data): ResultData
  {
    $sqlPreValue = $this->read_name_json_sql("'$id'");
    $sqlUpdate = $this->update_name_sql("'$name'", "'$id'");
    $newValue = json_encode($name);
    // print_r($sql);
    return shared_execute_update_sql($sqlPreValue, $sqlUpdate, $newValue, $id, $data);
  }
}
?>