<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/main_sql.php');

class Anonymous_DevicesSql extends MainSqlDevices
{



    function insert_sql($device_id,$device_type_id, $device_info): string
    {
        // return "INSERT INTO $this->table_name (`$this->device_id`,`$this->device_info`) VALUES ($device_id,$device_info)";
        $table_name = $this->table_name;
        $columns = "(`$this->device_id`,`$this->device_info`,`$this->device_type_id`)";
        $values = "($device_id,$device_info,$device_type_id)";
        // print_r(shared_insert_sql($table_name, $columns, $values));
        return shared_insert_sql($table_name, $columns, $values);
    }

    function update_info_sql($device_info, $device_id)
    {
        // return "UPDATE `$this->table_name`SET $this->device_info = $device_info  WHERE $this->device_id = $device_id";

        $table_name = $this->table_name;
        $set_query = "SET $this->device_info = $device_info";
        $condition = "$this->device_id = $device_id";
        return shared_update_sql($table_name, $set_query, $condition);
    }

    function read_id_sql($device_id): string
    {
        $innerJoin = "";
        $condition = "$this->device_id = $device_id";
        /////
        return $this->r_id_sql($innerJoin, $condition);
    }
    function read_info_sql($device_id): string
    {
        $innerJoin = "";
        $condition = "$this->device_id = $device_id";
        /////
        return $this->r_info_sql($innerJoin, $condition);
    }
   

}
?>