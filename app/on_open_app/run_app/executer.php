<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');

class CheckingAppExecuter extends CheckingLevelPermissions
{

    private $shared_data;
    // 
    private $checking_sql;

    public function __construct(Shared_Data $shared_data) {
        $this->shared_data = $shared_data;
        //
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/run_app/sql.php');
        $this->checking_sql = new CheckingAppSql();
    }

    private function executeSql(): ResultData
    {
        $sql = $this->checking_sql->check_app("'{$this->shared_data->getAppPackageName()}'", "'{$this->shared_data->getSha()}'", "'{$this->shared_data->getDeviceId()}'");
        // 
        if ($this->shared_data->issetData2()) {
            $sql = $sql . $this->checking_sql->check_user($this->shared_data->getUserPhone(), $this->shared_data->getUserPassword());
        }
        $fun = fun1();
        return $fun->exec_read_one_sql($sql);
    }
    function check(): ResultData
    {
        $c1 = $this->executeSql();
        if ($c1->result) {
            if ($c1->getAppId()) {
              
                if ($c1->getDeviceTypeName()) {
                   $v = $this->check_all($c1, $this->shared_data->getAppVersion(), $this->checking_sql->permission_name);
                //    print_r($v);
                   return $v;
                  
                }
                return fun1()->UNKWON_DEVICE_TYPE();
            }
            return fun1()->APP_NOT_AUTHORIAED();
        }
        return $c1;
    }

}
