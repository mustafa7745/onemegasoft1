<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/main_sql.php');
class User_GroupsSql extends MainSqlGroups{
    
    function read_sql(): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "1";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
    function read_in_sql($ids): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->group_id IN ($ids)";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
}
?>