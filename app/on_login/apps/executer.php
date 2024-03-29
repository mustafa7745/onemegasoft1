<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class Apps extends CheckingLevelPermissions
{
    private $app_package_name;
    private $app_sha256;
    private $app_version;
    private $device_type_name;
    private $device_id;
    private $device_info;
    private $app_device_token;
    private $user_phone;
    private $user_password;
    // 
    private $app_data;
    private $login_data;
    // 
    private $check;
    // 
    public $id;

    public function __construct(
        $app_package_name,
        $app_sha256,
        $app_version,
        $device_type_name,
        $device_id,
        $device_info,
        $app_device_token,
        $user_phone,
        $user_password
    ) {
        $this->app_package_name = $app_package_name;
        $this->app_sha256 = $app_sha256;
        $this->app_version = $app_version;
        $this->device_type_name = $device_type_name;
        $this->device_id = $device_id;
        $this->device_info = $device_info;
        $this->app_device_token = $app_device_token;
        $this->user_phone = $user_phone;
        $this->user_password = $user_password;
        // 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/init_device_session_ip/executer.php');
        $this->check =
            new CheckingInitDeviceSessionIp(
                $this->app_package_name,
                $this->app_sha256,
                $this->app_version,
                $this->device_type_name,
                $this->device_id,
                $this->device_info,
                $this->app_device_token
            );
        $this->check->initUserAttr($this->user_phone, $this->user_password);

        // echo "hh";
    }
    function read($read_type)
    {
        $v1 = $this->check->check();
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            $app_data = $c1["data"];
            $this->app_data = $app_data;
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');

            $checking_sql = new SharedCheckingLevelSql("READ_APPS");
            $sql = $checking_sql->check_permission($app_data);
            // echo $sql;
            $result = fun()->exec_one_sql($sql);
            if ($result) {
                $myArray = array();
                while ($row = $result->fetch_assoc()) {
                    $myArray[] = $row;
                }

                $this->login_data = $myArray[0];
               

                $v1 = $this->check_all($this->login_data, $this->app_version, $checking_sql->permission_name);
                $c1 = json_decode($v1, true);
                if ($c1["result"]) {
                    if (isset($this->app_data["user_id"]) and $this->app_data["user_id"] != null) {
                        if ($this->app_data["user_session_id"] != null) {
                            if ($read_type == 'group') {
                                return $this->read_by_group_id($this->id);
                            }
                            return $this->read_groups();
                        }
                        return $fun()->USER_SESSION_NOT_FOUND_PLEASE_LOGIN_AGAIN();
                    }
                    return fun()->USER_OR_PASSWORD_ERROR();
                }
                return $v1;
            }
            return fun()->ERROR_SQL();
        }
        return $v1;
    }

    function read_groups()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/user/executer.php');
        
        $user_apps_executer = new User_AppsExecuter();
        
        return $user_apps_executer->execute_read_sql();
    }
    
    function read_by_group_id($id)
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/user/executer.php');
        $user_apps_executer = new User_AppsExecuter();
        return $user_apps_executer->execute_read_by_group_id_sql($this->id);
    }





}
