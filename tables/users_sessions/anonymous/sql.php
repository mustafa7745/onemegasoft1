<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/main_sql.php');

class Anonymous_UsersSessionsSql extends MainSqlUsersSessions
{


    function read_id_sql($user_id , $device_session_id): string
    {
        $innerJoin = "";
        $condition = "$this->user_id = $user_id and $this->device_session_id = $device_session_id";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
   
   

}
?>