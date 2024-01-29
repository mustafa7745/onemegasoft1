<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/attribute.php');
class Whatsapp_LevelPermissionsSql extends MainSqlLevelPermissions{
    
    function read_id_sql($level_permission_name): string
    {
        $innerJoin = "";
        $condition = "$this->level_permission_name = $level_permission_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>