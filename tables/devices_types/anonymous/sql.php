<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_types/main_sql.php');
class Anonymous_DevicesTypesSql extends MainSqlDevicesTypes
{

    function read_name_sql($device_type_id): string
    {
        $innerJoin = "";
        $condition = "$this->device_type_id = $device_type_id";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_name_sql($innerJoin, $condition);
    }

}
?>