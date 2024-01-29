<?php
class WrongResponse
{
    function response($code, $msg_ar, $msg_en): string
    {
        http_response_code(400);
        return json_encode(array('result' => false, 'code' => $code, 'message' => json_decode($this->message($msg_ar, $msg_en))));
    }
    private function message($msg_ar, $msg_en): string
    {
        return json_encode(array('ar' => $msg_ar, 'en' => $msg_en));
    }
}
?>