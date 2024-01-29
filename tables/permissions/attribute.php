<?php
class PermissionsAttribute{

public $name = "permission";
public $table_name = "permissions";
public $permission_id = "permission_id";
public $permission_name = "permission_name";


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
            "$this->permission_id" => $data[$i]["$this->permission_id"],
            "$this->permission_name" => $data[$i]["$this->permission_name"],
        )
    );
}

 /////Native Inner join
 function NATIVE_INNER_JOIN(): string
 {
     $inner = NATIVE_INNER_JOIN($this->table_name, $this->permission_id);
     return $inner;
 }
 /////Inner join
 function INNER_JOIN(): string
 {
    return "";
 }



}
?>