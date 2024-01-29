<?php
class GroupsAttribute{

public $name = "group";
public $table_name = "groups";
public $group_id = "group_id";
public $group_name = "group_name";

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
            "$this->group_id" => $data[$i]["$this->group_id"],
            "$this->group_name" => $data[$i]["$this->group_name"],
        )
    );
}

 /////Native Inner join
 function NATIVE_INNER_JOIN(): string
 {
     $inner = NATIVE_INNER_JOIN($this->table_name, $this->group_id);
     return $inner;
 }
 /////Inner join
 function INNER_JOIN(): string
 {
    return "";
 }



}
?>