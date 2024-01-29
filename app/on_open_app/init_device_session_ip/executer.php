<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingInitDeviceSessionIp extends CheckingLevelPermissions
{
    private $app_package_name;
    private $app_sha256;
    private $app_version;
    private $device_type_name;
    private $device_id;
    private $device_info;
    private $app_device_token;
    // 
    private $app_data;
    private $device_session_ip_data;
    // 
    private $check;
    // 
    function initUserAttr($user_phone, $user_password)
    {
        $this->check->initUserAttr($user_phone, $user_password);
    }

    public function __construct(
        $app_package_name,
        $app_sha256,
        $app_version,
        $device_type_name,
        $device_id,
        $device_info,
        $app_device_token
    ) {
        $this->app_package_name = $app_package_name;
        $this->app_sha256 = $app_sha256;
        $this->app_version = $app_version;
        $this->device_type_name = $device_type_name;
        $this->device_id = $device_id;
        $this->device_info = $device_info;
        $this->app_device_token = $app_device_token;
        //
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session/executer.php');
        $this->check =
            new CheckingInitDeviceSession(
                $this->app_package_name,
                $this->app_sha256,
                $this->app_version,
                $this->device_type_name,
                $this->device_id,
                $this->device_info,
                $this->app_device_token,
            );
    }
    function check()
    {
        $v1 = $this->check->check();
        $c1 = json_decode($v1, true);
        // 
        if ($c1["result"]) {
            $this->app_data = $c1["data"];
            if (!$this->app_data["device_session_ip_id"]) {
                require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                $checking_sql = new SharedCheckingLevelSql("INIT_NEW_DEVICE_SESSION_IP");
                $sql = $checking_sql->check_permission($this->app_data);
                // 
                $result = fun()->exec_one_sql($sql);
                if ($result) {
                    $myArray = array();
                    while ($row = $result->fetch_assoc()) {
                        $myArray[] = $row;
                    }
                    $this->device_session_ip_data = $myArray[0]; {
                        $v1 = $this->check_all($this->device_session_ip_data, $this->app_version, $checking_sql->permission_name);
                        $c1 = json_decode($v1, true);
                        if ($c1["result"]) {
                            return $this->add_device_session_ip();
                        }
                        return $v1;
                    }
                    return fun()->ERROR_SQL();
                }
            }
            return fun()->SUCCESS_WITH_DATA($this->app_data);
        }
        return $v1;
    }




    function add_device_session_ip()
    {
        // print_r($this->app_data);
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/anonymous/executer.php');
        $anonymous_devices_sessions_ips_executer = new Anonymous_DevicesSessionsIpsExecuter();
        // 
        $device_session_ip_id = uniqid(rand(), false);
        $ip = getenv("REMOTE_ADDR");
        // 
        if (!$this->app_data["ip"]) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/anonymous/executer.php');
            $anonymous_ips_executer = new Anonymous_IpsExecuter();
            // 
            $sql2 = $anonymous_devices_sessions_ips_executer->insert_sql(
                "'$device_session_ip_id'",
                "'{$this->app_data["device_session_id"]}'",
                "'$ip'",
            );
            
            $v1 = $anonymous_ips_executer->execute_insert_sql(
                $ip,
                $sql2,
                fun()
            );
            $c1 = json_decode($v1);
            if ($c1->result) {
                $this->app_data["device_session_ip_id"] = $device_session_ip_id;
                $this->app_data["ip"] = $ip;
                return fun()->SUCCESS_WITH_DATA($this->app_data);
            }
            return $v1;
        } else {
            $v1 = $anonymous_devices_sessions_ips_executer->execute_insert_sql(
                $device_session_ip_id,
                $this->app_data["device_session_id"],
                $ip,
                fun()
            );
            $c1 = json_decode($v1);
            if ($c1->result) {
                $this->app_data["device_session_ip_id"] = $device_session_ip_id;
                return fun()->SUCCESS_WITH_DATA($this->app_data);
            }
            return $v1;
        }
    }
}
