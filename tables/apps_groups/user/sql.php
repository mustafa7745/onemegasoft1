<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps_groups/main_sql.php');
class User_AppsGroupsSql extends MainSqlAppsGroups{
    
    function read_by_group_id_sql($group_id): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->table_name.$this->group_id = $group_id";
        /////
        return $this->r_sql($innerJoin, $condition);
    }
}
?>