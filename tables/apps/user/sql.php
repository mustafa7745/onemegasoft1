<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/main_sql.php');
class User_AppsSql extends MainSqlApps{
    
    function read_sql(): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = $this->INNER_JOIN();
        $condition = "1";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
}
?>