<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/block_types/main_sql.php');
class Anonymous_BlockTypesSql extends MainSqlBlockTypes{
    
    function read_id_sql($block_type_name): string
    {
        // return "(SELECT $this->device_app_session_id FROM $this->table_name WHERE $this->device_id = $device_id and $this->app_id = $app_id)";
        $innerJoin = "";
        $condition = "$this->block_type_name = $block_type_name";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
}
?>