<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/main_sql.php');
class Anonymous_IpsSql extends MainSqlIps
{

    function read_ip_sql(): string
    {
        $ip = getenv("REMOTE_ADDR");
        $innerJoin = "";
        $condition = "$this->ip = '$ip'";
        /////
        return $this->r_ip_sql($innerJoin, $condition);
    }
    function insert_sql($ip): string
    {
        // return "INSERT INTO $this->table_name (`$this->device_id`,`$this->device_info`) VALUES ($device_id,$device_info)";
        $table_name = $this->table_name;
        $columns = "(`$this->ip`)";
        $values = "($ip)";
        // print_r(shared_insert_sql($table_name, $columns, $values));
        return shared_insert_sql($table_name, $columns, $values);
    }

}
?>