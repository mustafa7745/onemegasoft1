<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_code_status_processes/main_sql.php');

class Whatsapp_UserCodesStatusProcessesSql extends MainSqlUserCodesStatusProcesses
{

    function read_status_sql($user_id, $app_id, $mycode_name): string
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/user_codes/whatsapp/sql.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/whatsapp/sql.php');
        $whatsapp_mycodes_sql = new Whatsapp_MyCodesSql();
        $mycode_id = $whatsapp_mycodes_sql->read_id_sql($mycode_name);
        /////
        $user_code = (new Whatsapp_UserCodesSql())->read_user_code_sql($user_id, $app_id, $mycode_id);
        $innerJoin = "";
        $condition = "$this->user_code = $user_code";
        /////
        return $this->r_status_sql($innerJoin, $condition);
    }

}
?>