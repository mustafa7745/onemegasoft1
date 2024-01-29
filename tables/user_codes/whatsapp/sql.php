<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/main_sql.php');

class Whatsapp_UserCodesSql extends MainSqlUserCodes
{

    function read_user_code_sql($user_id, $app_id, $mycode_id): string
    {
     
        $innerJoin = "";
        $condition = "$this->user_id = $user_id and $this->app_id = $app_id and $this->mycode_id = $mycode_id";
        /////
        return $this->r_user_code_sql($innerJoin, $condition);
    }
    function read_status_sql($user_id, $app_id, $mycode_name): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/whatsapp/sql.php');
        $whatsapp_mycodes_sql = new Whatsapp_MyCodesSql();
        $mycode_id = $whatsapp_mycodes_sql->read_id_sql($mycode_name);
        $innerJoin = "";
        $condition = "$this->user_id = $user_id and $this->app_id = $app_id and $this->mycode_id = $mycode_id";
        /////
        return $this->r_status_sql($innerJoin, $condition);
    }

}
?>