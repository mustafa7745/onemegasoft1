<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps_groups/main_sql.php');

class Anonymous_AppsGroupsSql extends MainSqlAppsGroups
{
    function read_group_id_sql($app_id): string
    {
        $innerJoin = "";
        $condition = "$this->app_id = $app_id";
        /////
        // print_r($this->r_id_sql($innerJoin, $condition));
        return $this->r_group_id_sql($innerJoin, $condition);
    }
}
?>