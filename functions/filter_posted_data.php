<?php
class FilterPostedData
{
    function filterAppPackageName(Fun $fun): string
    {
        $name = "app_package_name";
      
        $checked = "com.onemegasoft.";
        if (
            !isset($_POST[$name]) ||
            empty($_POST[$name]) ||
            strlen($_POST[$name]) > 30 ||
            !str_starts_with($_POST[$name], $checked)
        ) {
            return $fun->PARAMETER_INVALID();
        } 
         $value = $_POST[$name];
        $after = substr($value, strlen($checked), strlen($value));
        if (!ctype_alpha($after)) {
            return $fun->PARAMETER_INVALID();
        }
        // echo ;


        return $fun->SUCCESS_NO_DATA();

    }
    function filterAppSha(Fun $fun): string
    {
        $name = "sha";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        // echo ;
        if (strlen($value) != 95) {
            return $fun->APP_SHA_MUST_BE_FORMATTED();
        }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return $fun->APP_SHA_MUST_BE_FORMATTED();
            }
        }


        return $fun->SUCCESS_NO_DATA();

    }


    function filterAppVersion( Fun $fun): string
    {
        $name = "app_version";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        if (strlen($value) > 3) {
            return $fun->APP_VERSION_MUST_BE_NUMBER();
        }
        if (!is_numeric($value)) {
            return $fun->APP_VERSION_MUST_BE_NUMBER();
        }
        return $fun->SUCCESS_NO_DATA();

    }

    function filterDeviceId( Fun $fun): string
    {
        $name = "device_id";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        // echo strlen($value);
        if (strlen($value) > 30) {
            return $fun->APP_VERSION_MUST_BE_NUMBER();
        }
        $array = array('\'', "'", '"', ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return $fun->DEVICE_ID_MUST_BE_FORMATTED();

            }
        }
        return $fun->SUCCESS_NO_DATA();

    }
    function filterDeviceInfo( Fun $fun): string
    {
        $name = "device_info";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        // echo strlen($value);
        if (strlen($value) > 20) {
            return $fun->DEVICE_INFO_MUST_BE_FORMATTED();
        }
        $array = array('\'', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return $fun->DEVICE_INFO_MUST_BE_FORMATTED();
                ;
            }
        }

        if (!is_string($value) || !is_array(json_decode($value, true))) {
            return $fun->DEVICE_INFO_MUST_BE_FORMATTED();
        }
        return $fun->SUCCESS_NO_DATA();

    }
    function filterDeviceToken( Fun $fun): string
    {
        $name = "app_device_token";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        if (strlen($value) > 170) {
            // echo "dd";
            return $fun->DEVICE_INFO_MUST_BE_FORMATTED();
        }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return $fun->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
            }
        }

        return $fun->SUCCESS_NO_DATA();
    }
    function filterDeviceTypeName( Fun $fun): string
    {
        $name = "device_type_name";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        $array = array('android', 'ios', "browser");
        if (!in_array($value, $array)) {
            return $fun->DEVICE_TYPE_UNKNOWN();
        }

        return $fun->SUCCESS_NO_DATA();
    }
    ////////////////
    function filterUserPhone(Fun $fun): string
    {
        $name = "user_phone";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        if (!is_numeric($value)) {
            
            return $fun->USER_PHONE_MUST_BE_FORMATTED();
        }
        $array = array("967");
        for ($i = 0; $i < count($array); $i++) {
            if (!str_starts_with($value, $array[$i])) {
                return $fun->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
        if (str_starts_with($value,"967")) {
            if (strlen($value) != 12) {
                return $fun->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
      
      
        return $fun->SUCCESS_NO_DATA();

    }
    function filterUserPassword(Fun $fun): string
    {
        $name = "user_password";
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        if (strlen($value) != 5) {
            // echo "dd";
            return $fun->USER_PASSWORD_INVAILD();
        }
        if (preg_match("/[^A-Za-z0-9]/",$value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }
        if (!preg_match("/[0-9]/",$value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }
        if (!preg_match("/[A-Za-z]/",$value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }
      
      
        return $fun->SUCCESS_NO_DATA();

    }

    function filterID($name1,Fun $fun): string
    {
        $name = $name1;
        if (!isset($_POST[$name]) || empty($_POST[$name])) {
            return $fun->PARAMETER_INVALID();
        }
        $value = $_POST[$name];
        if (strlen($value) != 23) {
            // echo "dd";
            return $fun->ID_MUST_BE_FORMATTED();
        }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return $fun->ID_MUST_BE_FORMATTED();
            }
        }
      
      
        return $fun->SUCCESS_NO_DATA();

    }

}

?>