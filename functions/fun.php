<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/database_connection/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/wrong.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/success.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/filter_posted_data.php");
class Fun
{
  public $wrong;
  public $success;
  public $db;
  public $filter_posted_data;

  function __construct()
  {
    $this->db = new DB();
    $this->wrong = new Wrong();
    $this->success = new Success();
    $this->filter_posted_data = new FilterPostedData();
  }

  function isExecuted($arr): bool
  {
    if (count($arr) > 0) {
      for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] == 0)
          return false;
      }
      return true;
    } else {
      return false;
    }
  }
  function isSetValues0(): string
  {
    // // print_r("t");
    // foreach ($posted_data as $key => $value) {
    //   if (!in_array($key, $variable_array)) {
    //     return $this->PARAMETER_INVALID();
    //   }
    // }

    /////
    // echo "dd";
    $v1 = $this->filter_posted_data->filterAppPackageName($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    // echo "dd";
    // print_r("t");
    //////
    $v1 = $this->filter_posted_data->filterAppVersion($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    /////
    $v1 = $this->filter_posted_data->filterAppSha($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    // print_r("t");
    /////
    $v1 = $this->filter_posted_data->filterDeviceId($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    /////
    $v1 = $this->filter_posted_data->filterDeviceInfo($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }

    /////
    $v1 = $this->filter_posted_data->filterDeviceToken($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    /////
    $v1 = $this->filter_posted_data->filterDeviceTypeName($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    /////
    return $this->SUCCESS_NO_DATA();
  }
  function isSetValues1(): string
  {
    $v1 = $this->isSetValues0();
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    $v1 = $this->filter_posted_data->filterUserPhone($this);
    $c1 = json_decode($v1);
    if (!$c1->result) {
      return $v1;
    }
    /////
    // $v1 = $this->filter_posted_data->filterUserPassword($this);
    // $c1 = json_decode($v1);
    // if (!$c1->result) {
    //   return $v1;
    // }
    return $this->SUCCESS_NO_DATA();
  }

  function isSetValues($variable_array, $posted_data): bool
  {

    if (count($posted_data) == count($variable_array)) {
      foreach ($posted_data as $key => $value) {

        $i = 0;
        if (!in_array($key, $variable_array)) {
          // print_r($key);
          return false;
        }

        $i++;
      }
      return true;
    } else
      return false;
  }




  function exec_sql($sql_array): string
  {
    // $sql_array = array_map('utf8_encode',$sql_array);

    try {
      $errors = array();
      $array_effected = array();
      $this->db->conn->query("START TRANSACTION");
      for ($i = 0; $i < count($sql_array); $i++) {
        // print_r($sql_array[$i]);
        $this->db->conn->query($sql_array[$i]);
        mysqli_error($this->db->conn) != "" ? array_push($errors, mysqli_error($this->db->conn)) : null;
        array_push($array_effected, mysqli_affected_rows($this->db->conn));
      }

      if ($this->isExecuted($array_effected) && count($errors) == 0) {
        $this->db->conn->commit();
        return $this->SUCCESS_NO_DATA();
      } else {
        $this->db->conn->rollback();
        if (!$this->isExecuted($array_effected))
          return $this->DATA_NOT_EFFECTED();
        elseif (count($errors) > 0) {
          return $this->process_sql_errors($errors);
        } else
          return $this->UNKOWN_ERROR();
      }
    } catch (Exception $e) {
      $this->db->conn->rollback();
      return $this->EXP_SQL();
    }
  }


  function process_sql_errors($errors)
  {
    foreach ($errors as $key => $value) {
      if (str_contains($value, "Duplicate entry")) {
        return $this->DATA_EXIST_BEFORE();
      }
      if (str_contains($value, "Subquery returns more than 1")) {
        return $this->SUBQUERY_MORE_ONE();
      }
    }
    return $this->ERROR_SQL();
  }

  function exec_one_sql($sql)
  {
    try {
      // print_r("ddd");
      return $this->db->conn->query($sql);
    } catch (Exception $e) {
      // print_r("fadfs");
      return $this->EXP_SQL();
    }
  }

  // 1) ==>  CONN SQL
  function DATA_NOT_EFFECTED(): string
  {
    $ar = "لم يتم تعديل البيانات";
    $en = "DATA_NOT_EFFECTED";
    return $this->wrong->wrong_response->response(1001, $ar, $en);
  }
  function ERROR_SQL(): string
  {
    $ar = "خطأ في الاوامر";
    $en = "ERROR_SQL";
    return $this->wrong->wrong_response->response(1002, $ar, $en);
  }
  function UNKOWN_ERROR(): string
  {
    $ar = "خطأ  غير معروف";
    $en = "UNKOWN_ERROR";
    return $this->wrong->wrong_response->response(1003, $ar, $en);
  }
  function EXP_SQL(): string
  {
    $ar = "خطأ Ex";
    $en = "EXP_SQL";
    return $this->wrong->wrong_response->response(1004, $ar, $en);
  }
  function PARAMETER_INVALID(): string
  {
    $ar = "البيانات غير مكتمله";
    $en = ($_POST);
    return $this->wrong->wrong_response->response(1005, $ar, $en);
  }
  function DATA_EXIST_BEFORE(): string
  {
    $ar = "البيانات موجودة مسبقا";
    $en = "DATA_EXIST_BEFORE";
    return $this->wrong->wrong_response->response(1006, $ar, $en);
  }
  function SUBQUERY_MORE_ONE(): string
  {
    $ar = "";
    $en = "SUBQUERY_MORE_ONE";
    return $this->wrong->wrong_response->response(1007, $ar, $en);
  }
  function DATA_MANUPALATION(): string
  {
    $ar = "DATA_MANUPALATION";
    $en = "DATA_MANUPALATION";
    return $this->wrong->wrong_response->response(1008, $ar, $en);
  }
  ///////////
  // 2) ==>  APP STATUS

  function APP_NOT_AUTHORIAED(): string
  {
    $ar = "هذا التطبيق غير مخول للاستخدام";
    $en = "APP_NOT_AUTHORIAED";
    return $this->wrong->wrong_response->response(1011, $ar, $en);
  }
  function APP_DISABLED(): string
  {
    $ar = "تم ايقاف التطبيق من الادارة";
    $en = "APP_DISABLED";
    return $this->wrong->wrong_response->response(1012, $ar, $en);
  }
  function APP_NOT_EXACTLY_AUTHORIAED(): string
  {
    $ar = "التطبيق غير مخول للاستخدام";
    $en = "APP_NOT_EXACTLY_AUTHORIAED";
    return $this->wrong->wrong_response->response(1013, $ar, $en);
  }
  function UNKWON_DEVICE_TYPE(): string
  {
    $ar = "UNKWON_DEVICE_TYPE";
    $en = "UNKWON_DEVICE_TYPE";
    return $this->wrong->wrong_response->response(1013.5, $ar, $en);
  }
  function APP_UNDER_MAINTENANCE(): string
  {
    $ar = "التطبيق في حالة صيانة و تحديث";
    $en = "APP_UNDER_MAINTENANCE";
    return $this->wrong->wrong_response->response(1014, $ar, $en);
  }
  function APP_REQUIRE_UPDATE(): string
  {
    $ar = "التطبيق يتطلب تحديث";
    $en = "APP_REQUIRE_UPDATE";
    return $this->wrong->wrong_response->response(1015, $ar, $en);
  }
  function APP_VERSION_MUST_BE_NUMBER(): string
  {
    $ar = "APP_VERSION_MUST_BE_NUMBER";
    $en = "APP_VERSION_MUST_BE_NUMBER";
    return $this->wrong->wrong_response->response(1016, $ar, $en);
  }
  function APP_SHA_MUST_BE_FORMATTED(): string
  {
    $ar = "APP_SHA_MUST_BE_FORMATTED";
    $en = "APP_SHA_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(1017, $ar, $en);
  }
  ///////////
  // 3) ==>  PROCESS STATUS

  function PERMISSION_REQUIRED_UPDATE($name): string
  {
    $ar = "هذا الاجراء ياطلب التحديث الى اخر اصدار";
    $en = "{$name}_REQUIRED_UPDATE";
    return $this->wrong->wrong_response->response(1021, $ar, $en);
  }
  function PERMISSION_UNDER_MAINTANANCE($name): string
  {
    $ar = "هذا الاجراء قيد الصيانة والتحديث";
    $en = "{$name}_UNDER_MAINTANANCE";
    return $this->wrong->wrong_response->response(1022, $ar, $en);
  }

  ///////////
  // 4) ==>  MOBILE DEVICE

  function DEVICE_DISABLED(): string
  {
    $ar = "تم ايقاف هذا الجهاز من الاستخدام";
    $en = "DEVICE_DISABLED";
    return $this->wrong->wrong_response->response(1031, $ar, $en);
  }
  function DEVICE_ID_MUST_BE_FORMATTED(): string
  {
    $ar = "DEVICE_ID_MUST_BE_FORMATTED";
    $en = "DEVICE_ID_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(1032, $ar, $en);
  }
  function DEVICE_INFO_MUST_BE_FORMATTED(): string
  {
    $ar = "DEVICE_INFO_MUST_BE_FORMATTED";
    $en = "DEVICE_INFO_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(1033, $ar, $en);
  }


  ///////////
  // 5) ==>  DEVICE TYPES
  function DEVICE_TYPE_UNKNOWN(): string
  {
    $ar = "DEVICE_TYPE_UNKNOWN";
    $en = "DEVICE_TYPE_UNKNOWN";
    return $this->wrong->wrong_response->response(1041, $ar, $en);
  }
  ///////////
  // 6) ==>  DEVICE APP SESSION

  function DEVICE_APP_SESSION_DISABLED(): string
  {
    $ar = "تم ايقاف هذا الجهاز من الاستخدام التطبيقي";
    $en = "DEVICE_SESSION_DISABLED";
    return $this->wrong->wrong_response->response(1051, $ar, $en);
  }
  function DEVICE_APP_TOKEN_MUST_BE_FORMATTED(): string
  {
    $ar = "DEVICE_TOKEN_MUST_BE_FORMATTED";
    $en = "DEVICE_TOKEN_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(1052, $ar, $en);
  }

  ///////////
  // 7) ==>  MOBILE DEVICE APP IP SESSION

  function DEVICE_APP_IP_SESSION_DISABLED(): string
  {
    $ar = "تم ايقاف هذا الجهاز من الاستخدام  الشبكي التطبيقي";
    $en = "DEVICE_SESSION_IP_DISABLED";
    return $this->wrong->wrong_response->response(1061, $ar, $en);
  }

  ///////////
  // 8) ==>  USERS
  function USER_PHONE_MUST_BE_FORMATTED(): string
  {
    $ar = "USER_PHONE_MUST_BE_FORMATTED";
    $en = "USER_PHONE_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(1071, $ar, $en);
  }

  function USER_PASSWORD_INVAILD(): string
  {
    $ar = "USER_PASSWORD_INVAILD";
    $en = "USER_PASSWORD_INVAILD";
    return $this->wrong->wrong_response->response(1072, $ar, $en);
  }
  ///////////
  // 8) ==>  VERIFICATION CODE
  function REQUEST_CODE_BLOCKED_FOR_TIME(): string
  {
    $ar = "REQUEST_CODE_BLOCKED_FOR_TIME";
    $en = "REQUEST_CODE_BLOCKED_FOR_TIME";
    return $this->wrong->wrong_response->response(1081, $ar, $en);
  }
  function POST_DATA_NOT_FOUND($num): string
  {
    $ar = "DATA".$num."_NOT_FOUND";
    $en = "DATA".$num."_NOT_FOUND";
    return $this->wrong->wrong_response->response(1081, $ar, $en);
  }

  function REQUEST_CODE_AFTER_TIME($data): string
  {
    $ar = $data;
    $en = "REQUEST_CODE_AFTER_5_TIME";
    return $this->wrong->wrong_response->response(1082, $ar, $en);
  }

  // 10000) ==>  USERS
  function ID_MUST_BE_FORMATTED(): string
  {
    $ar = "ID_MUST_BE_FORMATTED";
    $en = "ID_MUST_BE_FORMATTED";
    return $this->wrong->wrong_response->response(10001, $ar, $en);
  }

  function PERMISSIONS_UNDER_MAINTENANCE($name): string
  {
    $ar = "{$name}_UNDER_MAINTENANCE";
    $en = "{$name}_UNDER_MAINTENANCE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function PERMISSIONS_REQUIRE_UPDATE($name): string
  {
    $ar = "{$name}_REQUIRE_UPDATE";
    $en = "{$name}_REQUIRE_UPDATE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }

  function NOT_FOUND_IN_THIS_GROUP_PERMISSIONS($name): string
  {
    $ar = "{$name}_NOT_FOUND_IN_THIS_GROUP_PERMISSIONS";
    $en = "{$name}_NOT_FOUND_IN_THIS_GROUP_PERMISSIONS";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_APP($name): string
  {
    $ar = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_APP";
    $en = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_APP";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }

  function PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVICE($name): string
  {
    $ar = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVCIE";
    $en = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVCIE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_USER($name): string
  {
    $ar = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_USER";
    $en = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_USER";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_IP($name): string
  {
    $ar = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_IPS";
    $en = "{$name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_IPS";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }


  ///////////
  // 3) ==>  TELEGRAM PROCESS
  function USER_DISABLED_MANY_TIME_REQUEST(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 301, 'data' => "USER_DISABLED_MANY_TIME_REQUEST"));
  }

  ////////
  function USER_HAVE_PENDEING_MONEY_TRANSFER(): string
  {
    return json_encode(array('result' => false, 'code' => 301, 'data' => "USER_HAVE_PENDEING_MONEY_TRANSFER"));
  }


  function MONEY_TRANSFER_NOT_FOUND(): string
  {
    return $this->wrong->wrong_response->response(500, "هذه الحوالة غير موجودة  ", "MONEY_TRANSFER_NOT_FOUND");
  }
  function USER_BLOCKED_MANY_TIMES_ATTEMPS_LOGIN(): string
  {
    $ar = "تم ايقافك لمدة يوم من المحاولات الفاشلة";
    $en = "USER_BLOCKED_MANY_TIMES_ATTEMPS_LOGIN";
    return $this->wrong->wrong_response->response(1011, $ar, $en);
  }
  function USER_SESSION_NOT_FOUND_PLEASE_LOGIN_AGAIN(): string
  {
    $ar = "USER_SESSION_NOT_FOUND_PLEASE_LOGIN_AGAIN";
    $en = "USER_SESSION_NOT_FOUND_PLEASE_LOGIN_AGAIN";
    return $this->wrong->wrong_response->response(1070, $ar, $en);
  }

  function USER_SESSION_LOGGED_OUT(): string
  {
    $ar = "تم تسجيل خروجك يرجى التسجيل مرة اخرى";
    $en = "USER_SESSION_LOGGED_OUT";
    return $this->wrong->wrong_response->response(1070, $ar, $en);
  }
  function APP_LOGIN_REQUIRED_UPDATE(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "APP_LOGIN_REQUIRED_UPDATE"));
  }


  function USER_NOT_HAVE_APP(): string
  {
    $ar = "المستخدم ليس لديه تطبيق لمواصلة العملية";
    $en = "USER_NOT_HAVE_APP";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function DATA_NOT_FOUND(): string
  {
    $ar = "البيانات غير موجودة";
    $en = "DATA_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
    ////

    ////
  }
  function DATA_CANNOT_BE_PROCESSED_PROCESS_NAME_NOT_RIGISTER(): string
  {
    $ar = "DATA_CANNOT_BE_PROCESSED_PROCESS_NAME_NOT_RIGISTER";
    $en = "DATA_CANNOT_BE_PROCESSED_PROCESS_NAME_NOT_RIGISTER";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }


  function OPERATION_BLOCKED_FOR_THIS_USER(): string
  {
    $ar = "العملية تم ابقافها لهذا المستخدم";
    $en = "OPERATION_BLOCKED_FOR_THIS_USER";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function ACCESS_NOT_AUTHORIZED(): string
  {
    $ar = "ليس لديك صلاحية الوصول لهذا المورد";
    $en = "ACCESS_NOT_AUTHORIZED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function ADMIN_DISABLED(): string
  {
    $ar = "مستخدم الادارة تم ايقافه";
    $en = "ADMIN DISABLED";
    return $this->wrong->wrong_response->response(1008, $ar, $en);
  }

  function MANAGER_NOT_FOUND(): string
  {
    $ar = "مدير التطبيقات غير موجود";
    $en = "ADMIN MANAGER_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function MANAGER_DISABLED(): string
  {
    $ar = " مدير التطبيق تم ايقافه";
    $en = "MANAGER_DISABLED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function CHARGE_TYPE_NOT_SUPPORTED(): string
  {
    $ar = "طريقة الدفع غير متوفرة";
    $en = "CHARGE_TYPE_NOT_SUPPORTED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }

  function MONEY_TRANSFER_ACCEPTED(): string
  {
    $ar = "هذه الحوالة تم قبولها من قبل";
    $en = "MONEY_TRANSFER_ACCEPTED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function MONEY_TRANSFER_REJECTED(): string
  {
    $ar = "هذه الحوالة تم رفضها من قبل";
    $en = "MONEY_TRANSFER_REJECTED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function VALUE_MUST_BE_NUMBER(): string
  {
    $ar = "VALUE_MUST_BE_NUMBER";
    $en = "VALUE_MUST_BE_NUMBER";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function CLIENT_NOT_FOUND(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "CLIENT_NOT_FOUND"));
  }
  function CLIENT_DISABLED(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "CLIENT_DISABLED"));
  }
  function APP_LOGIN_UNDER_MAINTANANCE(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "APP_LOGIN_UNDER_MAINTANANCE"));
  }

  function PHONE_ERROR(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "PHONE_ERROR"));
  }
  function user_DISABLED(): string
  {
    $ar = "تم ايقاف هذا المستخدم";
    $en = "user_DISABLED";
    return $this->wrong->wrong_response->response(1060, $ar, $en);
  }
  function ADMIN_NOT_FOUND(): string
  {
    $ar = "مستخدم الادارة غير موجود";
    $en = "ADMIN_NOT_FOUND";
    return $this->wrong->wrong_response->response(1080, $ar, $en);
  }

  function TOP_ADMIN_NOT_FOUND(): string
  {
    $ar = "مستخدم الادارة العامة غير موجود";
    $en = "TOP_ADMIN_NOT_FOUND";
    return $this->wrong->wrong_response->response(1080, $ar, $en);
  }

  function TOP_ADMIN_DISABLED(): string
  {
    $ar = "مستخدم الادارة تم ايقافة";
    $en = "TOP_ADMIN_DISABLED";
    return $this->wrong->wrong_response->response(1080, $ar, $en);
  }

  function USER_PASSWORD_CHANGED(): string
  {
    $ar = "تم تغيير كلمة المرور يرجى التسجيل من جديد";
    $en = "USER_PASSWORD_CHANGED";
    return $this->wrong->wrong_response->response(1050, $ar, $en);
  }
  function APP_NAME_NOT_VALID(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "APP_NAME_NOT_VALID"));
  }
  function SUCCESS_NULL_DATA(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => true, 'code' => null, 'data' => null));
  }

  function USER_ALREADY_HAVE_APP(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "USER_ALREADY_HAVE_APP"));
  }
  function CLIENT_SESSION_LOGGED_OUT(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "CLIENT_SESSION_LOGGED_OUT"));
  }
  function CLIENT_SESSION_DISABLED(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "CLIENT_SESSION_DISABLED"));
  }
  function MANAGER_SESSION_LOGGED_OUT(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "MANAGER_SESSION_LOGGED_OUT"));
  }

  function MANAGER_SESSION_DISABLED(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 302, 'data' => "MANAGER_SESSION_DISABLED"));
  }

  function SUCCESS_NO_DATA(): string
  {
    // http_response_code(501);
    return $this->success->SUCCESS_NO_DATA();
    // >response(500,"هذه الحوالة تم رقضها من قبل","MONEY TRANSFER REJECTED");
  }
  function SUCCESS_WITH_DATA($data): string
  {
    // http_response_code(501);
    return $this->success->SUCCESS_WITH_DATA($data);
  }
  function SUCCESS_WITH_DATA_AND_COUNT($data): string
  {
    // http_response_code(501);
    return $this->success->SUCCESS_WITH_DATA($data);
  }
  function SUCCESS_WITH_DATA1($data): string
  {
    // print_r($data);
    // http_response_code(501);
    return json_encode(array('result' => true, 'code' => 2, 'data' => $data));
  }


  // function DEVICE_APP_SESSION_DISABLED(): string
  // {
  //   // http_response_code(501);
  //   return json_encode(array('result' => false, 'code' => 105, 'data' => 'DEVICE_APP_SESSION_DISABLED'));
  // }
  function USER_ALREADY_REGISTERD(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 105, 'data' => 'USER_ALREADY_REGISTERD'));
  }

  function USER_OR_PASSWORD_ERROR(): string
  {
    $ar = "البيانات خاطئة";
    $en = "USER_OR_PASSWORD_ERROR";
    return $this->wrong->wrong_response->response(1008, $ar, $en);
  }
  function DATA_MORE_THAN_ONE(): string
  {
    $ar = "DATA_MORE_THAN_ONE";
    $en = "DATA_MORE_THAN_ONE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }

  function DEVICE_NOT_HAVE_SESSION(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 105, 'data' => 'DEVICE_NOT_HAVE_SESSION'));
  }
  function USER_NOT_HAVE_SESSION(): string
  {
    // http_response_code(501);
    return json_encode(array('result' => false, 'code' => 105, 'data' => 'USER_NOT_HAVE_SESSION'));
  }
  function USER_SESSION_DISABLED(): string
  {
    $ar = "تم ايقاف جلسة المستخدم";
    $en = "USER_SESSION_DISABLED";
    return $this->wrong->wrong_response->response(1080, $ar, $en);
  }

  function JSON_FORMAT_INVALID($data = ""): string
  {
    $ar = "JSON_FORMAT_INVALID_".$data;
    $en = "JSON_FORMAT_INVALID_".$data;;
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function ID_INVALID(): string
  {
    $ar = "ID_INVALID";
    $en = "ID_INVALID";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function TAG_NOT_FOUND(): string
  {
    $ar = "TAG_NOT_FOUND";
    $en = "TAG_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function ID_NOT_FOUND(): string
  {
    $ar = "ID_NOT_FOUND";
    $en = "ID_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function READ_BY_NOT_FOUND(): string
  {
    $ar = "READ_BY_NOT_FOUND";
    $en = "READ_BY_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_TAG(): string
  {
    $ar = "UNKOWN_TAG";
    $en = "UNKOWN_TAG";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_ATTRIBUTE(): string
  {
    $ar = "UNKOWN_ATTRIBUTE";
    $en = "UNKOWN_ATTRIBUTE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_READ_BY(): string
  {
    $ar = "UNKOWN_READ_BY";
    $en = "UNKOWN_READ_BY";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }

  function SEARCH_INVALID(): string
  {
    $ar = "SEARCH_INVALID";
    $en = "SEARCH_INVALID";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }


  function UNKOWN_TYPE_ID(): string
  {
    $ar = "UNKOWN_TYPE_ID";
    $en = "UNKOWN_TYPE_ID";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_TYPE_SEARCH(): string
  {
    $ar = "UNKOWN_TYPE_SEARCH";
    $en = "UNKOWN_TYPE_SEARCH";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_SEARCH_BY(): string
  {
    $ar = "UNKOWN_SEARCH_BY";
    $en = "UNKOWN_SEARCH_BY";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_CAUSE(): string
  {
    $ar = "UNKOWN_CAUSE";
    $en = "UNKOWN_CAUSE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_FORMAT_SEARCH(): string
  {
    $ar = "UNKOWN_FORMAT_SEARCH";
    $en = "UNKOWN_FORMAT_SEARCH";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function UNKOWN_TYPE(): string
  {
    $ar = "UNKOWN_TYPE";
    $en = "UNKOWN_TYPE";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function IDS_NOT_FORMATTED(): string
  {
    $ar = "IDS_NOT_FORMATTED";
    $en = "IDS_NOT_FORMATTED";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function IDS_NOT_FOUND(): string
  {
    $ar = "IDS_NOT_FOUND";
    $en = "IDS_NOT_FOUND";
    return $this->wrong->wrong_response->response(00, $ar, $en);
  }
  function CONVERT_IDS_TO_LIST($ids_json): string
  {
    try {
      if (!$this->json_validate($ids_json)) {
        // echo "ff";
        return $this->JSON_FORMAT_INVALID();
      }
      $data = json_decode($ids_json, true);
      // if (!$data)
      //   return $this->JSON_FORMAT_INVALID();
      // $i = 1;
      // foreach ($data as $key => $value) {
      //   if ($key != $i)
      //     return $this->JSON_FORMAT_INVALID();
      //   $i++;
      // }
     

      $count = count($data);
      $r = "";
      foreach ($data as $key => $value) {
        $r .= "'$value'";
        if ($count != $key) {
          $r .= ",";
        }
      }
      $data = json_encode(array('count'=> $count,"ids"=>$r));
      return $this->SUCCESS_WITH_DATA($data);
    } catch (\Throwable $th) {
      return $this->JSON_FORMAT_INVALID();
    }
  }

  function CHECK_ID_JSON($id): string
  {
    // echo 'Current PHP version: ' . phpversion();
    if (!$this->json_validate($id)) {
      // echo "ff";
      return $this->ID_INVALID();
    }
    // echo "ff";
    $data = json_decode($id, true);
    
    if (!$data["type"]) {
      // echo "ff";
      return $this->ID_INVALID();
    }
    if (!$data["id"]) {
      // echo "ff";
      return $this->ID_INVALID();
    }
    // echo "ff";
    return $this->SUCCESS_WITH_DATA($id);
  }
  function CHECK_SEARCH_JSON($id): string
  {
    // echo 'Current PHP version: ' . phpversion();
    if (!$this->json_validate($id)) {
      // echo "ff";
      return $this->SEARCH_INVALID();
    }
    // echo "ff";
    $data = json_decode($id, true);
    
    if (!$data["search"]) {
      // echo "ff";
      return $this->SEARCH_INVALID();
    }
    if (!$data["searchBy"]) {
      // echo "ff";
      return $this->SEARCH_INVALID();
    }
    // echo "ff";
    return $this->SUCCESS_WITH_DATA($id);
  }
  function json_validate(string $string): bool {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}
}
