<?php
require_once(getPath() . 'app/on_login/check_permission.php');
class Permissions 
{
    private $shared_data;
    private $check;

    public function __construct(Shared_Data $shared_data)
    {
        $this->shared_data = $shared_data;

        $this->check = (new CheckPermission($this->shared_data));
    }

    function read_permissions($offset): ResultData
    {
        $resultData = $this->check->check("READ_PERMISSIONS");
        if ($resultData->result) {
            require_once(getPath() . 'tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_read_sql($offset);
        }
        return $resultData;
    }
    // function read_permissions_from_pg($id)
    // {
    //     require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
    //     $user_permissions_executer = new User_PermissionsExecuter();
    //     return $user_permissions_executer->execute_read_permission_from_pg_sql($id);
    // }

    // function search_by_name_for_add_to_pg($search, $offset, $group_id)
    // {
    //     $v1 = $this->check("READ_PERMISSIONS");
    //     $c1 = json_decode($v1, true);
    //     if ($c1["result"]) {
    //         require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/user/executer.php');
    //         $user_permissions_executer = new User_PermissionsExecuter();
    //         return $user_permissions_executer->execute_search_by_name_for_add_to_pg_sql($search, $offset, $group_id);
    //     }
    //     return $v1;
    // }
    //
    function add_permission($permission_name)
    {
        $resultData = $this->check->check("READ_PERMISSIONS");
        if ($resultData->result) {
            require_once(getPath(). 'tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_add_permission_sql($permission_name, $resultData);
        }
        return $resultData;
    }
    function delete_permission($ids, $count): ResultData
    {
        $resultData = $this->check->check("DELETE_PERMISSIONS");
        if ($resultData->result) {
            require_once(getPath(). 'tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_delete_sql($ids, $count, $resultData);
        }
        return $resultData;
    }
    function update_permission($name, $id)
    {
        $resultData = $this->check->check("UPDATE_PERMISSION_NAME");
        if ($resultData->result) {
            require_once(getPath() . 'tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_update_name_sql($name, $id, $resultData);
        }
        return $resultData;
    }

    function search_by_name($search, $offset)
    {
        $resultData = $this->check->check("SEARCH_PERMISSIONS_BY_NAME");
        if ($resultData->result) {
            require_once(getPath() . 'tables/permissions/user/executer.php');
            $user_permissions_executer = new User_PermissionsExecuter();
            return $user_permissions_executer->execute_search_by_name_sql($search, $offset);
        }
        return $resultData;
    }
}
