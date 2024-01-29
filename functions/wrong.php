<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/_wrong_response.php");
class Wrong{

    public $wrong_response;
    function __construct()
    {
      $this->wrong_response = new WrongResponse();
      
    }
    function MONEY_TRANSFER_REJECTED():String{
        return $this->wrong_response->response(500,"هذه الحوالة تم رقضها من قبل","MONEY TRANSFER REJECTED");
        // return json_encode(array('result' => false, 'code' => 301, 'data' => "MONEY_TRANSFER_REJECTED"));
    }
}
?>
