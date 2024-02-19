<?php
// Shared
function shared_execute_read_no_json_sql($sql): ResultData
{
    return fun1()->exec_read_one_sql($sql);
}
// User
function shared_execute_insert_sql($sql1, $sql2, ResultData $data): ResultData
{
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_insert_operations/user/sql.php');
    $user_insert_operartion_sql = new User_UserInsertOperationsSql();
    $sql3 = $user_insert_operartion_sql->insert_sql("'{$data->getPermissionId()}'", "'{$data->getUserSessionId()}'", $sql2);
    // 
    $sql_array = array($sql1, $sql3);
    return fun1()->exec_sql($sql_array);
}
function shared_execute_delete_sql($sql1, $sqlRead, $count, ResultData $data)
{
    $resultData = fun1()->exec_read_one_sql($sqlRead);
    if ($resultData->result) {
        // print_r($resultData);
        if (count($resultData->data) == $count) {
            $json = json_encode($resultData->data);
            // 
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_delete_operations/user/sql.php');
            $user_delete_operartion_sql = new User_UserDeleteOperationsSql();
            $sql2 = $user_delete_operartion_sql->insert_sql("'{$data->getPermissionId()}'", "'{$data->getUserSessionId()}'", "'$json'");
            // 
            $sql_array = array($sql1, $sql2);
            return fun1()->exec_sql($sql_array);
        }
        return fun1()->INCOMPATABLE_DELETD_DATA_COUNT();
    }
    return $resultData;


}
function shared_execute_update_sql($sqlPreValue, $sqlUpdate, $newValue, $updated_id, ResultData $data)
{
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_update_operations/user/sql.php');
    $user_update_operartion_sql = new User_UserUpdateOperationsSql();
    $sql1 = $user_update_operartion_sql->insert_sql("'{$data->getPermissionId()}'", "'{$data->getUserSessionId()}'", "'$updated_id'", $sqlPreValue, "'$newValue'");
    // 
    $sql_array = array($sql1, $sqlUpdate);
    return fun1()->exec_sql($sql_array);
}
// Server
function shared_execute_insert_server_sql($sql): ResultData
{
    $sql_array = array($sql);
    $v1 = fun1()->exec_sql($sql_array);
    if ($v1->result) {
        return fun1()->SUCCESS_NO_DATA();
    }
    return $v1;
}

?>