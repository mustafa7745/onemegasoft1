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
    function checkAppPackageName(): ResultData
    {
        $name = "app_package_name";
        $checked = "com.onemegasoft.";
        if (
            !isset($this->data1[$name]) ||
            empty($this->data1[$name]) ||
            strlen($this->data1[$name]) > 30 ||
            !str_starts_with($this->data1[$name], $checked)
        ) {
            return fun1()->PACKAGE_NAME_NOT_FORMATTED();
        }
        $value = $this->data1[$name];
        $after = substr($value, strlen($checked), strlen($value));
        if (!ctype_alpha($after)) {
            return fun1()->PACKAGE_NAME_NOT_FORMATTED();
        }
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkAppSha(): ResultData
    {
        $name = "sha";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->APP_SHA_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
      
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun1()->APP_SHA_MUST_BE_FORMATTED();
            }
        }
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceId(): ResultData
    {
        $name = "device_id";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->DEVICE_ID_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
        // echo strlen($value);
        if (strlen($value) > 50) {
            return fun1()->DEVICE_ID_MUST_BE_FORMATTED();
        }
        $array = array('\'', "'", '"', ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun1()->DEVICE_ID_MUST_BE_FORMATTED();
            }
        }
        // return fun()->DEVICE_ID_MUST_BE_FORMATTED();
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkAppVersion(): ResultData
    {
        $name = "app_version";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->APP_VERSION_MUST_BE_NUMBER();
        }
        $value = $this->data1[$name];
        if (strlen($value) > 3) {
            return fun1()->APP_VERSION_MUST_BE_NUMBER();
        }
        if (!is_numeric($value)) {
            return fun1()->APP_VERSION_MUST_BE_NUMBER();
        }
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    
    // 
    function checkDeviceTypeName(): ResultData
    {
        $name = "device_type_name";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->DEVICE_TYPE_UNKNOWN();
        }
        $value = $this->data1[$name];
        $array = array('android', 'ios', "browser");
        if (!in_array($value, $array)) {
            return fun1()->DEVICE_TYPE_UNKNOWN();
        }

        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceInfo(): ResultData
    {
        $name = "device_info";  
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->JSON_FORMAT_INVALID("DEVCIE_INFO");
        }
        // print_r($this->data1[$name]);
        $info = json_encode($this->data1[$name]);
        // print_r($info);
        if (!fun1()->json_validate($info)) {
            return fun1()->JSON_FORMAT_INVALID("DEVCIE_INFO");
        }
        $value = $info;
        // echo strlen($value);
        if (strlen($value) > 20) {
            return fun1()->DEVICE_INFO_MUST_BE_FORMATTED();
        }
        $array = array('\'', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun1()->DEVICE_INFO_MUST_BE_FORMATTED();
            }
        }
        // print_r($value);
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkDeviceAppToken(): ResultData
    {
        $name = "app_device_token";
        if (!isset($this->data1[$name]) || empty($this->data1[$name])) {
            return fun1()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
        }
        $value = $this->data1[$name];
        if (strlen($value) > 170) {
            // echo "dd";
            return fun1()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
        }
        $array = array('\'', '"', "'", ',', ';', '<', '>', '/', '*', '#', "=");
        for ($i = 0; $i < count($array); $i++) {
            if (str_contains($value, $array[$i])) {
                return fun1()->DEVICE_APP_TOKEN_MUST_BE_FORMATTED();
            }
        }

        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkUserPhone(): ResultData
    {
        // print_r($this->data2);
        $name = "user_phone";
        if (!isset($this->data2[$name]) || empty($this->data2[$name])) {
            return fun1()->USER_PHONE_MUST_BE_FORMATTED();
        }
        $value = $this->data2[$name];
        if (!is_numeric($value)) {

            return fun1()->USER_PHONE_MUST_BE_FORMATTED();
        }
        $array = array("967");
        for ($i = 0; $i < count($array); $i++) {
            if (!str_starts_with($value, $array[$i])) {
                return fun1()->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
        if (str_starts_with($value, "967")) {
            if (strlen($value) != 12) {
                return fun1()->USER_PHONE_MUST_BE_FORMATTED();
            }
        }
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkUserPassword(): ResultData
    {
        $name = "user_password";
        if (!isset($this->data2[$name]) || empty($this->data2[$name])) {
            return fun1()->USER_PASSWORD_MUST_BE_FORMATTED();
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
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    // 
    function checkTag(): ResultData
    {
        $name = "tag";
        if (!isset($this->data3[$name]) || empty($this->data3[$name])) {
            return fun1()->TAG_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkFrom(): ResultData
    {
        $name = "from";
        if (!isset($this->data3[$name])) {
            return fun1()->FROM_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        if (!is_numeric($value)) {
            return fun1()->FROM_MUST_BE_NUMBER();
        }
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkName(): ResultData
    {
        $name = "name";
        if (!isset($this->data3[$name])) {
            return fun1()->NAME_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        
        $value = addslashes($value);
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    function checkSearchBy(): ResultData
    {
        $name = "searchBy";
        if (!isset($this->data3[$name])) {
            return fun1()->SEARCH_BY_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        
        // $value = addslashes($value);
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkSearch(): ResultData
    {
        $name = "search";
        if (!isset($this->data3[$name])) {
            return fun1()->SEARCH_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];
        
        // $value = addslashes($value);
        return fun1()->SUCCESS_WITH_DATA($value);
    }
    // 
    function checkIds():ResultData
    {
        // print_r("ddd");
        $name = "ids";
        if (!isset($this->data3[$name])) {
            // print_r("ddd");
            return fun1()->IDS_EMPTY_OR_NOT_FOUND();
        }
        // print_r("ddd");
        $value = $this->data3[$name];
        return fun1()->CONVERT_IDS_TO_LIST(json_encode($value));
        
    }
    // 
    function checkId()
    {
        $name = "id";
        if (!isset($this->data3[$name])) {
            return fun1()->ID_EMPTY_OR_NOT_FOUND();
        }
        $value = $this->data3[$name];

        return fun1()->SUCCESS_WITH_DATA($value);
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
