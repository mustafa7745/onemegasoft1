<?php
class FilterPostedData
{
    public $data1;
    public $data2;
    public $data3;

    function data1($data1)
    {
        $this->data1 = $data1;
    }
    function data2($data1, $data2)
    {
        $this->data1 = $data1;
        $this->data2 = $data2;
    }
    function data3($data1, $data2, $data3)
    {
        $this->data1 = $data1;
        $this->data2 = $data2;
        $this->data3 = $data3;
    }
    // public data11(){

    // }
    function checkAppPackageName(): string
    {
        $name = "app_package_name";
        $checked = "com.onemegasoft.";
        if (
            !isset($this->data1[$name]) ||
            empty($this->data1[$name]) ||
            strlen($this->data1[$name]) > 30 ||
            !str_starts_with($this->data1[$name], $checked)
        ) {
            return fun()->PARAMETER_INVALID();
        }
        $value = $this->data1[$name];
        $after = substr($value, strlen($checked), strlen($value));
        if (!ctype_alpha($after)) {
            return fun()->PARAMETER_INVALID();
        }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkAppSha(): string
    {
        $name = "sha";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->APP_SHA_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
        // echo ;
        // if (strlen($value) != 95) {
        //     return fun()->APP_SHA_MUST_BE_FORMATTED();
        // }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun()->APP_SHA_MUST_BE_FORMATTED();
            }
        }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 

    function checkAppVersion(): string
    {
        $name = "app_version";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->APP_VERSION_MUST_BE_NUMBER();
        }
        $value = $this->data1[$name];
        if (strlen($value) > 3) {
            return fun()->APP_VERSION_MUST_BE_NUMBER();
        }
        if (!is_numeric($value)) {
            return fun()->APP_VERSION_MUST_BE_NUMBER();
        }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceId(): string
    {
        $name = "device_id";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->DEVICE_ID_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
        // echo strlen($value);
        if (strlen($value) > 50) {
            return fun()->DEVICE_ID_MUST_BE_FORMATTED();
        }
        $array = array('\'', "'", '"', ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun()->DEVICE_ID_MUST_BE_FORMATTED();
            }
        }
        // return fun()->DEVICE_ID_MUST_BE_FORMATTED();
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceTypeName(): string
    {
        $name = "device_type_name";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->PARAMETER_INVALID();
        }
        $value = $this->data1[$name];
        $array = array('android', 'ios', "browser");
        if (!in_array($value, $array)) {
            return fun()->DEVICE_TYPE_UNKNOWN();
        }

        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceInfo(): string
    {
        $name = "device_info";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->JSON_FORMAT_INVALID("DEVCIE_INFO");
        }
        // print_r($this->data1[$name]);
        $info = json_encode($this->data1[$name]);
        // print_r($info);
        if (!fun()->json_validate($info)) {
            return fun()->JSON_FORMAT_INVALID("DEVCIE_INFO");
        }
        $value = $info;
        // echo strlen($value);
        if (strlen($value) > 20) {
            return fun()->DEVICE_INFO_MUST_BE_FORMATTED();
        }
        $array = array('\'', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun()->DEVICE_INFO_MUST_BE_FORMATTED();
                ;
            }
        }
        // print_r($value);
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceAppToken(): string
    {
        $name = "app_device_token";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
        if (strlen($value) > 170) {
            // echo "dd";
            return fun()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
        }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
            }
        }

        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkUserPhone(): string
    {
        // print_r($this->data2);
        $name = "user_phone";
        if (!isset($this->data2[$name]) || empty($this->data2[$name])) {
            return fun()->USER_PHONE_MUST_BE_FORMATTED();
        }
        $value = $this->data2[$name];
        if (!is_numeric($value)) {

            return fun()->USER_PHONE_MUST_BE_FORMATTED();
        }
        $array = array("967");
        for ($i = 0; $i < count($array); $i++) {
            if (!str_starts_with($value, $array[$i])) {
                return fun()->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
        if (str_starts_with($value, "967")) {
            if (strlen($value) != 12) {
                return fun()->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkUserPassword(): string
    {
        $name = "user_password";
        if (!isset($this->data2[$name]) || empty($this->data2[$name])) {
            return fun()->PARAMETER_INVALID();
        }
        $value = $this->data2[$name];
        // if (strlen($value) != 5) {
        //     // echo "dd";
        //     return $fun->USER_PASSWORD_INVAILD();
        // }
        // if (preg_match("/[^A-Za-z0-9]/", $value)) {
        //     return $fun->USER_PASSWORD_INVAILD();
        // }
        // if (!preg_match("/[0-9]/", $value)) {
        //     return $fun->USER_PASSWORD_INVAILD();
        // }
        // if (!preg_match("/[A-Za-z]/", $value)) {
        //     return $fun->USER_PASSWORD_INVAILD();
        // }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    // 
    function checkTag(): string
    {
        $name = "tag";
        if (!isset($this->data3[$name]) || empty($this->data3[$name])) {
            return fun()->TAG_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkFrom(): string
    {
        $name = "from";
        if (!isset($this->data3[$name])) {
            return fun()->FROM_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        if (!is_numeric($value)) {
            return fun()->FROM_MUST_BE_NUMBER();
        }
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkName(): string
    {
        $name = "name";
        if (!isset($this->data3[$name])) {
            return fun()->FROM_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        
        // $value = addslashes($value);

       
        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkIds()
    {
        $name = "ids";
        if (!isset($this->data3[$name])) {
            return fun()->IDS_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        $v1 = fun()->CONVERT_IDS_TO_LIST(json_encode($value));
        $c1 = json_decode($v1, true);
        // print_r($c1 );
        if (!$c1["result"]) {
            return $v1;
        }
        return fun()->SUCCESS_WITH_DATA($c1["data"]);
    }
    // 
    function checkId()
    {
        $name = "id";
        if (!isset($this->data3[$name])) {
            return fun()->ID_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];

        return fun()->SUCCESS_WITH_DATA($value);
    }
    // 
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


    function filterAppVersion(Fun $fun): string
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

    function filterDeviceId(Fun $fun): string
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
    function filterDeviceInfo(Fun $fun): string
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
    function filterDeviceToken(Fun $fun): string
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
    function filterDeviceTypeName(Fun $fun): string
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
        if (str_starts_with($value, "967")) {
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
        if (preg_match("/[^A-Za-z0-9]/", $value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }
        if (!preg_match("/[0-9]/", $value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }
        if (!preg_match("/[A-Za-z]/", $value)) {
            return $fun->USER_PASSWORD_INVAILD();
        }


        return $fun->SUCCESS_NO_DATA();
    }

    function filterID($name1, Fun $fun): string
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
