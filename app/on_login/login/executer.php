<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class Login extends CheckingLevelPermissions
{
    private $shared_data;

    public function __construct(Shared_Data $shared_data) {
        $this->shared_data = $shared_data;
    }
    function check()
    {
         // 1) Check Run App
         require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session_ip/executer.php');

         $resultData = (new CheckingInitDeviceSessionIp($this->shared_data))->check();
         // 
         
         if ($resultData->result) {
          
             
                 require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                 $checking_sql = new SharedCheckingLevelSql("LOGIN");
                 $sql = $checking_sql->check_permission($resultData->data[0]);
                 // 
                 $resultData1 = fun1()->exec_read_one_sql($sql);
                 if ($resultData1->result) {
                     // 2) Check Permission in Levels Permissions
                     $resultData2 = $this->check_all($resultData1, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
                     if ($resultData2->result) {
                        if ($resultData->issetUserId() and $resultData->getUserId() != null){
                            if ($resultData->issetUserSessionId() != null){
                                return $resultData;
                            }
                            return $this->add_user_session($resultData);
                        }
                        return fun1()->USER_OR_PASSWORD_ERROR();
                     }
                     return $resultData2;
                 }
                 return $resultData1;
         }
         return $resultData;

        // $v1 = $this->check->check();
        // $c1 = json_decode($v1, true);
        // if ($c1["result"]) {
        //     // print_r("ddrr");
        //     $app_data = $c1["data"];
        //     $this->app_data = $app_data;
        //     require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');

        //     // print_r($app_data);
        //     $checking_sql = new SharedCheckingLevelSql("LOGIN");
        //     $sql = $checking_sql->check_permission($app_data);
        //     // echo $sql;
        //     $result = fun()->exec_one_sql($sql);
        //     // print_r("ddrr");
        //     if ($result) {
        //         $myArray = array();
        //         while ($row = $result->fetch_assoc()) {
        //             $myArray[] = $row;
        //         }

        //         $this->login_data = $myArray[0];
        //         print_r($this->login_data);

        //         $v1 = $this->check_all($this->login_data, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
        //         $c1 = json_decode($v1, true);
        //         if ($c1["result"]) {
        //             if (isset($this->app_data["user_id"]) and $this->app_data["user_id"] != null) {
        //                 if ($this->app_data["user_session_id"] != null) {
        //                     return fun()->SUCCESS_WITH_DATA($this->app_data);
        //                 }
        //                 return $this->add_user_session();
        //             }
        //             return fun()->USER_OR_PASSWORD_ERROR();
        //         }
        //         return $v1;
        //     }
        //     return fun()->ERROR_SQL();
        // }
        // return $v1;
    }

    function add_user_session(ResultData $data):ResultData
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/user/executer.php');
        $user_users_sessions_executer = new User_UsersSessionsExecuter();
        $user_session_id = uniqid(rand(), false);
        $resultData = $user_users_sessions_executer->execute_insert_sql(
            $user_session_id,
            $data->getUserId(),
            $data->getDeviceSessionId(),
            fun()
        ); 
        if ($resultData->result) {
            $data->setUserSessionId($user_session_id);
            return $data;
        }
        return $resultData;
    }




}
