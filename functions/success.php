<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/_success_response.php");
class Success{

    public $success_response;
    function __construct()
    {
      $this->success_response = new SuccessResponse();
      
    }
    function SUCCESS_NO_DATA():String{
        return $this->success_response->response(NULL);
    }
    function SUCCESS_WITH_DATA($data):String{
      return $this->success_response->response($data);
  }
  function SUCCESS_WITH_DATA_AND_COUNT($data,$count):String{
    return $this->success_response->response($data);
}
}
?>
