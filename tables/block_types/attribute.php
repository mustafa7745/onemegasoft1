<?php
class BlockTypesAttribute{

public $name = "block_type";
public $table_name = "block_types";
public $block_type_id = "block_type_id";
public $block_type_name = "block_type_name";

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
            "$this->block_type_id" => $data[$i]["$this->block_type_id"],
            "$this->block_type_name" => $data[$i]["$this->block_type_name"],
        )
    );
}

 /////Native Inner join
 function NATIVE_INNER_JOIN(): string
 {
     $inner = NATIVE_INNER_JOIN($this->table_name, $this->block_type_id);
     return $inner;
 }
 /////Inner join
 function INNER_JOIN(): string
 {
    return "";
 }



}
?>