<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/static/main_sql.php');
class Anonymous_StaticSql extends MainSqlStatic
{

    function read_path_icon_app_sql($key): string
    {
        $innerJoin = "";
        $condition = "{$this->table_name}.$this->key = $key";
        return 
        "(SELECT CONCAT({$this->r_domain_sql()},{$this->r_value_sql($innerJoin, $condition)}))as path_icon";
        ;
    }

}
?>