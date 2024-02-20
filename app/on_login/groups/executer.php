<?php
require_once(getPath() . 'app/on_login/check_permission.php');
class Groups
{
    private $shared_data;
    private $check;

    public function __construct(Shared_Data $shared_data)
    {
        $this->shared_data = $shared_data;
        $this->check = (new CheckPermission($this->shared_data));
    }

    function read_groups():ResultData
    {
        $resultData = $this->check->check("READ_PERMISSIONS");
        if ($resultData->result) {
            require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/user/executer.php');
            $user_groups_executer = new User_GroupsExecuter();
            return $user_groups_executer->execute_read_sql();
        }
        return $resultData;
    }
    function read_in($ids)
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/user/executer.php');
        $user_groups_executer = new User_GroupsExecuter();
        return $user_groups_executer->execute_read_in_sql($ids);
    }
}
