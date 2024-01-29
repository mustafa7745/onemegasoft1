<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/groups/attribute.php');
class Anonymous_GroupsSql extends MainSqlGroups{
    
    function read_id_sql($group_name): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->group_name = $group_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>