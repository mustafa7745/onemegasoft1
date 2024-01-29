<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');

class CheckingAppExecuter extends CheckingLevelPermissions
{

    // 
    private $app_package_name;
    private $app_sha256;
    private $app_version;
    private $device_type_name;
    private $device_id;
    // 
    private $user_phone;
    private $user_password;
    // 
    private $app_data;
    // 
    private $checking_sql;

    function initUserAttr($user_phone, $user_password)
    {
        $this->user_phone = $user_phone;
        $this->user_password = $user_password;
    }




    public function __construct(
        $app_package_name,
        $app_sha256,
        $app_version,
        $device_type_name,
        $device_id
    ) {
        $this->app_package_name = $app_package_name;
        $this->app_sha256 = $app_sha256;
        $this->app_version = $app_version;
        $this->device_type_name = $device_type_name;
        $this->device_id = $device_id;
        //
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/run_app/sql.php');
        $this->checking_sql = new CheckingAppSql();
    }


    function check()
    {
        // echo "ff";
        $sql = $this->checking_sql->check_app("\"{$this->app_package_name}\"", "'{$this->app_sha256}'", "'$this->device_id'");

        if (isset($this->user_phone) and isset($this->user_password)) {
            $sql = $sql . $this->checking_sql->check_user($this->user_phone, $this->user_password);
        }
        // echo $sql;
        // echo "ff";
        $result = fun()->exec_one_sql($sql);
         
        if ($result) {
            // echo "ff";
            $myArray = array();
            while ($row = $result->fetch_assoc()) {
                $myArray[] = $row;
            }
            $data = $myArray;
            $this->app_data = $data[0];
            return $this->app();
        }
        // echo "fff";
        return fun()->ERROR_SQL();
    }

    function app()
    {
        if ($this->app_data["app_id"]) {
            return $this->device_type();
        }
        return fun()->APP_NOT_AUTHORIAED();
    }

    function device_type()
    {
        if ($this->app_data["device_type_name"] == $this->device_type_name) {
            $v1 = $this->check_all($this->app_data, $this->app_version, $this->checking_sql->permission_name);
            $c1 = json_decode($v1, true);
            if ($c1["result"]) {
                // print_r($c1["data"]);
                // echo "fff";
                return fun()->SUCCESS_WITH_DATA($c1["data"]);
            }
            return $v1;
        }
        return fun()->APP_NOT_EXACTLY_AUTHORIAED();
    }
}
