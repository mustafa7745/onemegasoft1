<?php
class SuccessResponse{

    function response($data):String{
        return json_encode(array('result' => true, 'data' => $data));
    }
    function response_with_count($data,$count):String{
        return json_encode(array('result' => true,'count'=>$count, 'data' => $data));
    }
}
?>