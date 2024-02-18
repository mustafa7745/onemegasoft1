<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingInitDevice extends CheckingLevelPermissions
{
    private $shared_data;
    public function __construct(Shared_Data $shared_data)
    {
        $this->shared_data = $shared_data;
    }
    function check(): ResultData
    {
        // 1) Check Run App
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/run_app/executer.php');
        $resultData = (new CheckingAppExecuter($this->shared_data))->check();
        // 
        if ($resultData->result) {
            // 2) Check if Device Exist in Database
            if ($resultData->getDeviceId() == null) {
                require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/shared_checking_level_sql.php');
                $checking_sql = new SharedCheckingLevelSql("INIT_NEW_DEVICE");
                $sql = $checking_sql->check_permission($resultData->data[0]);
                // 
                $resultData1 = fun1()->exec_read_one_sql($sql);
                if ($resultData1->result) {
                    // 3) Check Permission in Levels Permissions
                    $resultData2 = $this->check_all($resultData1, $this->shared_data->getAppVersion(), $checking_sql->permission_name);
                    if ($resultData2->result) {
                        return $this->add_device($resultData);
                    }
                    return $resultData2;
                }
                return $resultData1;
            }
            return $resultData;
        }
        return $resultData;
    }



    function add_device(ResultData $data): ResultData
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/anonymous/executer.php');
        $anonymous_devices_executer = new Anonymous_DevicesExecuter();
        //////////////////////////
        $resultData = $anonymous_devices_executer->execute_insert_sql(
            $this->shared_data->getDeviceId(),
            $data->getDeviceTypeId(),
            $this->shared_data->getDeviceInfo());
        //////////////////////////
        if ($resultData->result) {
            $data->setDeviceId($this->shared_data->getDeviceId());
            $data->setDeviceInfo($this->shared_data->getDeviceInfo());
            return $data;
        }
        return $resultData;
    }
}
