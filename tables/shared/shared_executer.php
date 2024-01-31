<?php
// require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_insert_operations/t/sql.php');
// require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_update_operations/t/sql.php');
// require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_delete_operations/t/sql.php');

function shared_execute_read_sql($sql, $json): string
{
    $result = fun()->exec_one_sql($sql);
    if ($result) {
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $myArray[] = $row;
        }
        $data = $myArray;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = json_decode($json($data, $i));
        }
        // print_r($data);
        return fun()->SUCCESS_WITH_DATA($data);
    }
    return fun()->ERROR_SQL();
}
function shared_execute_read_one_sql($sql): string
{
    $result = fun()->exec_one_sql($sql);
    if ($result) {
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $myArray[] = $row;
        }
        $data = $myArray;
        return fun()->SUCCESS_WITH_DATA($data);
    }
    return fun()->ERROR_SQL();
}
function shared_execute_read_no_json_sql($sql): string
{
    $result = fun()->exec_one_sql($sql);
    if ($result) {
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $myArray[] = $row;
        }
        $data = $myArray;
        return fun()->SUCCESS_WITH_DATA($data);
    }
    return fun()->ERROR_SQL();
}

function shared_execute_insert_sql($sql)
{
    $sql_array = array($sql);
    $v1 = fun()->exec_sql($sql_array);
    $c1 = json_decode($v1);
    if ($c1->result) {
        return fun()->SUCCESS_NO_DATA();
    }
    return $v1;
}
function shared_execute_more_sql($sql_array)
{
    // print_r($sql_array)
    $v1 = fun()->exec_sql($sql_array);
    $c1 = json_decode($v1);
    if ($c1->result) {
        return fun()->SUCCESS_NO_DATA();
    }
    return $v1;
}
function shared_execute_update_sql($sql)
{
    $sql_array = array($sql);
    $v1 = fun()->exec_sql($sql_array);
    $c1 = json_decode($v1);
    if ($c1->result) {
        return fun()->SUCCESS_NO_DATA();
    }
    return $v1;
}
function shared_execute_update_2sql($sql1,$sql2)
{
    $sql_array = array($sql1,$sql2);
    $v1 = fun()->exec_sql($sql_array);
    $c1 = json_decode($v1);
    if ($c1->result) {
        return fun()->SUCCESS_NO_DATA();
    }
    return $v1;
}

function shared_execute_insert1_sql(
    $user_id,
    $mycode_id,
    $app_type_id,
    $device_app_session_id,
    /////
    $sql,
    $insertd_json
): string {
    $t_user_codes_executer = new T_UserCodesExecuter();
    $v1 = $t_user_codes_executer->execute_read_user_code_sql($mycode_id, $app_type_id);
    $c1 = json_decode($v1);
    if ($c1->result) {
        $user_code = $c1->data;
        ////////
        $t_user_insert_operations_sql = new T_UserInsertOperationsSql();
        ////////
        $sql1 = $sql;
        $sql2 = $t_user_insert_operations_sql->insert_sql("'$user_code'", "'$user_id'", "'$device_app_session_id'", $insertd_json);
        //    print_r($sql1);
        //    print_r($sql2);
        $sql_array = array($sql1,$sql2);
        $v1 = fun()->exec_sql($sql_array);
        $c1 = json_decode($v1);
        if ($c1->result) {
            return fun()->SUCCESS_NO_DATA();
        }
        return $v1;
    }
    return $v1;
}

function shared_execute_read_where_ids_sql($ids, $sql, $json): string
{
    $v1 = fun()->CONVERT_IDS_TO_LIST($ids);
    $c1 = json_decode($v1);
    // print_r("dff");
    if ($c1->result) {
        // print_r($sql);
        $result = fun()->exec_one_sql($sql($c1->data));
        if ($result) {
            $myArray = array();
            while ($row = $result->fetch_assoc()) {
                $myArray[] = $row;
            }
            $data = $myArray;
            for ($i = 0; $i < count($data); $i++) {
                // $app = $this->user_sessions_sql->jsonApp($data,$i);
                $data[$i] = json_decode($json($data, $i));
            }
            $data = json_encode(array("data" => $data, "ids" => $c1->data));
            return fun()->SUCCESS_WITH_DATA($data);
        }
        return fun()->ERROR_SQL();
    }
    return $v1;
}

function shared_execute_delete_sql(
    $user_id,
    $mycode_id,
    $app_type_id,
    $device_app_session_id,
    $ids,
    $sql_ids,
    $sql,
    $json
): string {

    $t_user_codes_executer = new T_UserCodesExecuter();
    $v1 = $t_user_codes_executer->execute_read_user_code_sql($mycode_id, $app_type_id);

    $c1 = json_decode($v1);
    if ($c1->result) {
        // print_r("dff");
        $user_code = $c1->data;

        ////////
        $v1 = shared_execute_read_where_ids_sql($ids, $sql_ids, $json);
        // print_r($user_code);
        $c1 = json_decode($v1);
        if ($c1->result) {
            $resData = json_decode($c1->data);

            $deleted_data = json_encode($resData->data);
            /////
            $t_user_delete_operations_sql = new T_UserDeleteOperationsSql();
            $sql1 = $sql($resData->ids);
            $sql2 = $t_user_delete_operations_sql->insert_sql("'$user_code'", "'$user_id'", "'$device_app_session_id'", "'$deleted_data'");
            $sql_array = array($sql1,$sql2);
            $v1 = fun()->exec_sql($sql_array);
            $c1 = json_decode($v1);
            if ($c1->result) {
                return fun()->SUCCESS_NO_DATA();
            }
            return $v1;
        }
        return $v1;
    }
    return $v1;
}

function shared_execute_search_sql($sql, $json): string
{
    $result = fun()->exec_one_sql($sql);
    if ($result) {
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $myArray[] = $row;
        }
        $data = $myArray;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = json_decode($json($data, $i));
        }

        return fun()->SUCCESS_WITH_DATA($data);
    }
    return fun()->ERROR_SQL();

}

function shared_execute_read_one_json_sql($sql, $json): string
{
    $result = fun()->exec_one_sql($sql);
    if ($result) {
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $myArray[] = $row;
        }
        $data = $myArray;
        for ($i = 0; $i < count($data); $i++) {
            // $app = $this->user_sessions_sql->jsonApp($data,$i);
            $data[$i] = json_decode($json($data, $i));
        }
        return fun()->SUCCESS_WITH_DATA($data);
        // if (count($data) == 1) {
        //     return fun()->SUCCESS_WITH_DATA($data);
        // } elseif (count($data) == 0) {
        //     return fun()->DATA_NOT_FOUND();
        // }
        //  else
        //     return fun()->DATA_MORE_THAN_ONE();
    }
    return fun()->ERROR_SQL();
}

function shared_execute_update1_sql($user_id, $mycode_id, $app_type_id, $device_app_session_id, $pre_value, $post_value, $sql): string
{
    $t_user_codes_executer = new T_UserCodesExecuter();
    $v1 = $t_user_codes_executer->execute_read_user_code_sql($mycode_id, $app_type_id, fun());
    // print_r($);
    $c1 = json_decode($v1);

    if ($c1->result) {

        $user_code = $c1->data;
        //////////////
        $t_user_update_operations_sql = new T_UserUpdateOperationsSql();
        //////////////
        // $pre_value = $this->read_json_one_sql("'$id'");
        // $post_value = json_encode(array("$this->mycode_name" => $value, "$this->mycode_id" => $id));
        $sql1 = $t_user_update_operations_sql->insert_sql("'$user_code'", "'$user_id'", "'$device_app_session_id'", $pre_value, "'$post_value'");
        $sql2 = $sql;
        // print_r($sql1);
        // print_r($sql2);

        /////////
        $sql_array = array($sql1,$sql2);
        $v1 = fun()->exec_sql($sql_array);
        $c1 = json_decode($v1);
        if ($c1->result) {
            return fun()->SUCCESS_NO_DATA();
        }
        return $v1;
    }
    return $v1;
}


?>