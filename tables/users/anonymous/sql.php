<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/main_sql.php');

class Anonymous_UsersSql extends MainSqlUsers
{


    function read_id_sql($user_phone , $user_password): string
    {
        $innerJoin = "";
        $condition = "$this->user_phone = $user_phone and $this->user_password = SHA2($user_password,512)";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
   
   

}
?>