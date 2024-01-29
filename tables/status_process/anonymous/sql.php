<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/status_process/main_sql.php');
class Anonymous_StatusProcessSql extends MainSqlStatusProcess
{

    function read_is_under_maintenance($app_id, $mycode_id): string
    {
        $innerJoin = "";
        $condition = "$this->mycode_id = $mycode_id and $this->app_id = $app_id";
        /////
        return $this->r_is_under_maintenance($innerJoin, $condition);

    }

    function read_required_version($app_id, $mycode_id): string
    {
        $innerJoin = "";
        $condition = "$this->mycode_id = $mycode_id and $this->app_id = $app_id";
        /////
        return $this->r_required_version($innerJoin, $condition);

    }


}
?>