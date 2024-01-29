<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/maintenance_permissions/attribute.php');
class MainSqlMaintenancePermissions extends MaintenancePermissionsAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->maintenance_permission_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 
    function r_status_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->maintenance_permission_status}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
        
    } 

    // function r_required_version($innerJoin, $condition):String{
    //     $table_name = $this->table_name;
    //     $column = "{$this->table_name}.{$this->permission_required_version}";
    //     /////
    //     return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    // } 
}
?>