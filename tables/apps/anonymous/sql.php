<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/main_sql.php');

class Anonymous_AppsSql extends MainSqlApps
{
    function read_id_sql($app_package_name, $app_sha256): string
    {
        $innerJoin = "";
        $condition = "$this->app_package_name = $app_package_name and $this->app_sha256 = $app_sha256";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_id_sql($innerJoin, $condition);
    }
    function read_device_type_id_sql($app_package_name): string
    {
        $innerJoin = "";
        $condition = "$this->app_package_name = $app_package_name";
        /////
        return $this->r_device_type_id_sql($innerJoin, $condition);
    }
    function read_group_id_sql($app_package_name): string
    {
        $innerJoin = "";
        $condition = "$this->app_package_name = $app_package_name";
        /////
        return $this->r_group_id_sql($innerJoin, $condition);
    }
    function read_version_sql($app_package_name): string
    {
        $innerJoin = "";
        $condition = "$this->app_package_name = $app_package_name";
        /////
        return $this->r_version_sql($innerJoin, $condition);
    }
}
?>