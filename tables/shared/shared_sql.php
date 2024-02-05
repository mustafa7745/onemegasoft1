<?php

function read_limit_sql($table_name, $innerJoin, $orederdBy, $orederdType, $offset, $limit): string
{
    return "(SELECT * FROM $table_name $innerJoin) ORDER BY $orederdBy $orederdType LIMIT $offset,$limit";
}

function NATIVE_INNER_JOIN($table_name, $id): string
{
    return "INNER JOIN {$table_name} ON {$table_name}.{$id}";
}
function FORIGN_KEY_ID_INNER_JOIN($nativeInnerJoin, $table_name, $id): string
{
    $inner = "$nativeInnerJoin = {$table_name}.{$id}";
    return $inner;
}

function read_by_condition_sql($table_name, $columns, $innerJoin, $condition): string
{
    $sql = "(SELECT $columns FROM $table_name $innerJoin WHERE $condition)";
    // print_r($sql);
    return $sql;
}



function read_one_column_sql($table_name, $column, $innerJoin, $condition): string
{
    $sql = "(SELECT {$table_name}.{$column} FROM $table_name $innerJoin WHERE $condition)";
    return $sql;
}

function shared_insert_sql($table_name, $columns, $values): string
{
    $sql = "INSERT INTO `$table_name` $columns VALUES $values";
    return $sql;
}

function shared_update_sql($table_name, $set_query, $condition): string
{
    $sql = "UPDATE `$table_name` $set_query WHERE $condition";
    return $sql;
}
function delete_sql($table_name, $condition): string
{
    $sql = "DELETE FROM `$table_name` WHERE $condition";
    return $sql;
}




?>