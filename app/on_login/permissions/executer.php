<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class Permissions extends CheckingLevelPermissions
{
    private $shared_data;

    public function __construct(Shared_Data $shared_data)
    {
        $this->shared_data = $shared_data;
    }
    function check($permission_name)
    {
        // 1) Check Run App
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session_ip/executer.php');

        $resultData = (new CheckingInitDeviceSessionIp($this->shared_data))->check();
        // 

        if ($resultData->result) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
            $checking_sql = new SharedCheckingLevelSql($permission_name);
            $sql = $checking_sql->check_permission($resultData->data[0]);
            // 
            $resultData1 = fun1()->exec_read_one_sql($sql);
            if ($resultData1->result) {
                // 2) Check Permission in Levels Permissions
                $resultData2 = $this->check_all($resultData1, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
                if ($resultData2->result) {
                    if ($resultData->issetUserId() and $resultData->getUserId() != null) {
                        if ($resultData->issetUserSessionId() != null) {
                            return $resultData;
                        }
                        return fun1()->USER_SESSION_NOT_FOUND_PLEASE_LOGIN_AGAIN();
                    }
                    return fun1()->USER_OR_PASSWORD_ERROR();
                }
                return $resultData2;
            }
            return $resultData1;
        }
        return $resultData;
    }

    function read_permissions($offset): ResultData
    {
        $resultData = $this->check("READ_PERMISSIONS");
        if ($resultData->result) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_read_sql($offset);
        }
        return $resultData;
    }
    function read_permissions_from_pg($id)
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
        $user_permissions_executer = new User_PermissionsExecuter();
        return $user_permissions_executer->execute_read_permission_from_pg_sql($id);
    }

    function search_by_name_for_add_to_pg($search, $offset, $group_id)
    {
        $v1 = $this->check("READ_PERMISSIONS");
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_search_by_name_for_add_to_pg_sql($search, $offset, $group_id);
        }
        return $v1;
    }
    //
    function add_permission($permission_name)
    {
        $v1 = $this->check("ADD_PERMISSION");
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_add_permission_sql($permission_name);
        }
        return $v1;
    }
    function delete_permission($ids)
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
        $user_permissions_executer = new User_PermissionsExecuter();
        return $user_permissions_executer->execute_delete_sql($ids);
    }
    function edit_permission($name, $id)
    {
        $v1 = $this->check("UPDATE_PERMISSION_NAME");
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_update_name_sql($name, $id);
        }
        return $v1;
    }

    function search_by_name($search, $offset)
    {
        $v1 = $this->check("READ_PERMISSIONS");
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_search_by_name_sql($search, $offset);
        }
        return $v1;
    }
}
