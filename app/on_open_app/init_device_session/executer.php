<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingInitDeviceSession extends CheckingLevelPermissions
{
    private $shared_data;
    // 
    public function __construct(Shared_Data $shared_data) {
        $this->shared_data = $shared_data;
    }
    function check(): ResultData
    {

        // 1) Check Run App
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device/executer.php');
        $resultData = (new CheckingInitDevice($this->shared_data))->check();
        // 
        if ($resultData->result) {
            // 2) Check if Device Session Exist in Database
            if ($resultData->getDeviceSessionId() == null) {
                require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                $checking_sql = new SharedCheckingLevelSql("INIT_NEW_DEVICE_SESSION");
                $sql = $checking_sql->check_permission($resultData->data[0]);
                // 
                $resultData1 = fun1()->exec_read_one_sql($sql);
                if ($resultData1->result) {
                    // 3) Check Permission in Levels Permissions
                    $resultData2 = $this->check_all($resultData1, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
                    if ($resultData2->result) {
                        return $this->add_device_session($resultData);
                    }
                    return $resultData2;
                }
                return $resultData1;
            }
            return $resultData;
        }
        return $resultData;
    }



    function add_device_session(ResultData $data): ResultData
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/anonymous/executer.php');
        $anonymous_devices_sessions_executer = new Anonymous_DevicesSessionsExecuter();
        ///////////////////////
        $device_session_id = uniqid(rand(), false);
        $resultData = $anonymous_devices_sessions_executer->execute_insert_sql(
            $device_session_id,
            $data->getDeviceId(),
            $data->getAppId(),
            $this->shared_data->getDeviceAppToken()
        );
        /////////////////////////
        if ($resultData->result) {
            $data->setDeviceSessionId($device_session_id) ;
            $data->setDeviceSessionStatus("1") ;
            $data->setDeviceAppToken($this->shared_data->getDeviceAppToken()) ;
            return $data;
        }
        return $resultData;
    }
}
