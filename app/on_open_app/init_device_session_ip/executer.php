<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingInitDeviceSessionIp extends CheckingLevelPermissions
{
    private $shared_data;
    // 
    public function __construct(Shared_Data $shared_data)
    {
        $this->shared_data = $shared_data;
    }
    function check()
    {
       
        // 1) Check Run App
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session/executer.php');
        $resultData = (new CheckingInitDeviceSession($this->shared_data))->check();
        // print_r("mu");
        // 
        if ($resultData->result) {
            // 2) Check if Device Session Exist in Database
            if ($resultData->getDeviceSessionIpId() == null) {
                require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                $checking_sql = new SharedCheckingLevelSql("INIT_NEW_DEVICE_SESSION_IP");
                $sql = $checking_sql->check_permission($resultData->data[0]);
                // 
                $resultData1 = fun1()->exec_read_one_sql($sql);
                if ($resultData1->result) {
                    // 3) Check Permission in Levels Permissions
                    $resultData2 = $this->check_all($resultData1, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
                    if ($resultData2->result) {
                        // print_r("mu");
                        return $this->index($resultData);
                    }
                    return $resultData2;
                }
                return $resultData1;
            }
            return $resultData;
        }
        return $resultData;
    }




    function add_device_session_ip(ResultData $data): ResultData
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/anonymous/executer.php');
        $anonymous_devices_sessions_ips_executer = new Anonymous_DevicesSessionsIpsExecuter();
        $device_session_ip_id = uniqid(rand(), false);
        $ip = getenv("REMOTE_ADDR");
        $resultData1 = $anonymous_devices_sessions_ips_executer->execute_insert_sql(
            $device_session_ip_id,
            $data->getDeviceSessionId(),
            $ip
        );
        if ($resultData1->result) {
            $data->setDeviceSessionIpId($device_session_ip_id);
            return $data;
        }
        return $resultData1;

    }

    function index(ResultData $data): ResultData
    {
        if (!$data->getIp()) {
            $resultData = $this->add_ip($data);
            if ($resultData->result) {
                if (!$data->getDeviceSessionIpId()) {
                    return $this->add_device_session_ip($data);
                }
                return $resultData;
            }
            return $resultData;
        }
        if (!$data->getDeviceSessionIpId()) {
            return $this->add_device_session_ip($data);
        }
        return $data;
    }

    function add_ip(ResultData $data): ResultData
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/anonymous/executer.php');
        $anonymous_ips_executer = new Anonymous_IpsExecuter();
        // 
        $ip = getenv("REMOTE_ADDR");
        $resultData = $anonymous_ips_executer->execute_insert_sql($ip);

        if ($resultData->result) {
            $data->setIp($ip);
            return $data;
        }
        return $resultData;

    }
}
