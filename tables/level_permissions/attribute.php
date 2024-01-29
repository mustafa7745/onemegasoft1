<?php
class LevelPermissionsAttribute{

public $name = "level_permission";
public $table_name = "level_permissions";
public $level_permission_id = "level_permission_id";
public $level_permission_name = "level_permission_name";

////


public $json;
function initJson()
{
    $this->json = function ($data, $i) {
        return $this->jsonF($data, $i);
    };
}
/////json function
function jsonF ($data, $i) {
    return json_encode(
        array( 
            "$this->level_permission_id" => $data[$i]["$this->level_permission_id"],
            "$this->level_permission_name" => $data[$i]["$this->level_permission_name"],
        )
    );
}

 /////Native Inner join
 function NATIVE_INNER_JOIN(): string
 {
     $inner = NATIVE_INNER_JOIN($this->table_name, $this->level_permission_id);
     return $inner;
 }
 /////Inner join
 function INNER_JOIN(): string
 {
    return "";
 }



}
?>