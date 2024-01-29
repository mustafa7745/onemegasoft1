<?php 
function encrypt($key, $data) {
    $encryptionKey = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-gcm'));
    $encrypted = openssl_encrypt($data, 'aes-128-gcm', $encryptionKey, 0, $iv, $tag);
    return base64_encode($encrypted . '::' . $iv . '::' . $tag);
}

function decrypt($key, $data) {
    $encryptionKey = base64_decode($key);
    // print_r($encryptionKey);.
       $array = explode('::', base64_decode($data), 3);
       if (count($array) == 3) {
        $encryptedData = $array[0];
        $iv = $array[1];
        $tag = $array[2];
        return openssl_decrypt($encryptedData, 'aes-128-gcm', $encryptionKey, 0, $iv, $tag);
       }
       return "";
   
    
}
?>