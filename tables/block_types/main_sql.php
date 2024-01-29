<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/block_types/attribute.php');
class MainSqlBlockTypes extends BlockTypesAttribute
{
    function r_id_sql($innerJoin, $condition):String{
        $table_name = $this->table_name;
        $column = "{$this->table_name}.{$this->block_type_id}";
        /////
        return read_by_condition_sql($table_name, $column, $innerJoin, $condition);
    } 
}
?>