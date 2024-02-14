<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingInitDevice extends CheckingLevelPermissions
{
    private $app_package_name;
    private $app_sha256;
    private $app_version;
    private $device_type_name;
    private $device_id;
    private $device_info;
    // 
    private $app_data;
    // 
    private $device_data;
    // 
    private $check_app;
    //   
    function initUserAttr($user_phone, $user_password)
    {
        $this->check_app->initUserAttr($user_phone, $user_password);
    }

    public function __construct(
        $app_package_name,
        $app_sha256,
        $app_version,
        $device_type_name,
        $device_id,
        $device_info
    ) {
        $this->app_package_name = $app_package_name;
        $this->app_sha256 = $app_sha256;
        $this->app_version = $app_version;
        $this->device_type_name = $device_type_name;
        $this->device_id = $device_id;
        $this->device_info = $device_info;

        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/run_app/executer.php');
        $this->check_app =
            new CheckingAppExecuter(
                $this->app_package_name,
                $this->app_sha256,
                $this->app_version,
                $this->device_type_name,
                $this->device_id
            );
    }
    function check()
    { 
        $v1 = $this->check_app->check();
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
           
            $this->app_data = $c1["data"];
            if ($this->app_data["device_id"] == null) {
              
                require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                $checking_sql = new SharedCheckingLevelSql("INIT_NEW_DEVICE");
                $sql = $checking_sql->check_permission($this->app_data);
                // print_r($sql);
                $result = fun()->exec_one_sql($sql);
                if ($result) {
                    // echo "dd";
                   
                    $myArray = array();
                    while ($row = $result->fetch_assoc()) {
                        $myArray[] = $row;
                    }
                    $this->device_data = $myArray[0]; 
                    // print_r($this->device_data);
                    $v1 = $this->check_all($this->device_data, $this->app_version, $checking_sql->permission_name);
                    $c1 = json_decode($v1, true);
                    if ($c1["result"]) {
                        // echo "fff";
                        return $this->add_device();
                    }
                    return $v1;
                }
                return fun()->ERROR_SQL();
            }
            return fun()->SUCCESS_WITH_DATA($this->app_data);
        }
        return $v1;
    }



    function add_device()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/anonymous/executer.php');
        $anonymous_devices_executer = new Anonymous_DevicesExecuter();

        $v1 = $anonymous_devices_executer->execute_insert_sql(
            $this->device_id,
            $this->app_data["device_type_id"],
            $this->device_info
        );
        $c1 = json_decode($v1);
        if ($c1->result) {
            // echo "dd";
            $this->app_data["device_id"] = $this->device_id;
            $this->app_data["device_info"] = $this->device_info;
            return fun()->SUCCESS_WITH_DATA($this->app_data);
        }
        return $v1;
    }
}
