<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/database_connection/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/wrong.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/success.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/filter_posted_data.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/$root/functions/_wrong_response.php");
class Fun1
{
  public $wrong_response;
  public $success;
  public $db;
  public $filter_posted_data;

  function __construct()
  {
    $this->db = new DB();
    $this->wrong_response = new WrongResponse();
    $this->success = new Success();
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

  function exec_sql($sql_array): ResultData
  {
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

  function exec_read_one_sql($sql)
  {
    try {
      $v = $this->db->conn->query($sql);
      if ($v) {
        $myArray = array();
        while ($row = $v->fetch_assoc()) {
          $myArray[] = $row;
        }
        return $this->SUCCESS_WITH_DATA($myArray);
      }
      return $this->ERROR_SQL_NAME();

    } catch (Exception $e) {
      return $this->EXP_SQL();
    }
  }


  function json_validate(string $string): bool
  {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
  }

  function SUCCESS_NO_DATA(): ResultData
  {
    return $this->resultData(true, "");
  }
  function SUCCESS_WITH_DATA($data): ResultData
  {
    return $this->resultData(true, $data);
  }
  function EXP_SQL(): ResultData
  {
    $ar = "EXP_SQL";
    $en = "EXP_SQL";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function ERROR_SQL(): ResultData
  {
    $ar = "ERROR_SQL";
    $en = "ERROR_SQL";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function SUBQUERY_MORE_ONE(): ResultData
  {
    $ar = "SUBQUERY_MORE_ONE";
    $en = "SUBQUERY_MORE_ONE";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function DATA_EXIST_BEFORE(): ResultData
  {
    $ar = "DATA_EXIST_BEFORE";
    $en = "DATA_EXIST_BEFORE";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function DATA_NOT_EFFECTED(): ResultData
  {
    $ar = "DATA_NOT_EFFECTED";
    $en = "DATA_NOT_EFFECTED";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function UNKOWN_ERROR(): ResultData
  {
    $ar = "UNKOWN_ERROR";
    $en = "UNKOWN_ERROR";
    return $this->wrong_response->error_response($ar, $en, 300);
  }
  function ERROR_SQL_NAME(): ResultData
  {
    $ar = "خطأ في الاوامر";
    $en = mysqli_error($this->db->conn);
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function PERMISSION_IS_BLOCKED_FROM_USE_IN($permission_name, $place): ResultData
  {
    $ar = "{$permission_name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_{$place}";
    $en = "{$permission_name}_PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_{$place}";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function PERMISSION_UNDER_MAINTANANCE($name): ResultData
  {
    $ar = "{$name}_UNDER_MAINTENANCE";
    $en = "{$name}_UNDER_MAINTENANCE";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function PERMISSION_REQUIRED_UPDATE($name): ResultData
  {
    $ar = "{$name}_REQUIRE_UPDATE";
    $en = "{$name}_REQUIRE_UPDATE";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function NOT_FOUND_IN_THIS_GROUP_PERMISSIONS($name): ResultData
  {
    $ar = "{$name}_NOT_FOUND_IN_THIS_GROUP_PERMISSIONS";
    $en = "{$name}_NOT_FOUND_IN_THIS_GROUP_PERMISSIONS";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  
  function APP_NOT_HAVE_GROUP(): ResultData
  {
    $ar = "APP_NOT_HAVE_GROUP";
    $en = "APP_NOT_HAVE_GROUP";
    return $this->wrong_response->error_response($ar, $en, 1002);

  }
  function UNKWON_DEVICE_TYPE(): ResultData
  {
    $ar = "UNKWON_DEVICE_TYPE";
    $en = "UNKWON_DEVICE_TYPE";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function APP_NOT_AUTHORIAED(): ResultData
  {
    $ar = "APP_NOT_AUTHORIAED";
    $en = "APP_NOT_AUTHORIAED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function PACKAGE_NAME_NOT_FORMATTED(): ResultData
  {
    $ar = "PACKAGE_NAME_NOT_FORMATTED";
    $en = "PACKAGE_NAME_NOT_FORMATTED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function APP_SHA_MUST_BE_FORMATTED(): ResultData
  {
    $ar = "APP_SHA_MUST_BE_FORMATTED";
    $en = "APP_SHA_MUST_BE_FORMATTED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function APP_VERSION_MUST_BE_NUMBER(): ResultData
  {
    $ar = "APP_VERSION_MUST_BE_NUMBER";
    $en = "APP_VERSION_MUST_BE_NUMBER";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function DEVICE_ID_MUST_BE_FORMATTED(): ResultData
  {
    $ar = "DEVICE_ID_MUST_BE_FORMATTED";
    $en = "DEVICE_ID_MUST_BE_FORMATTED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function DEVICE_TYPE_UNKNOWN(): ResultData
  {
    $ar = "DEVICE_TYPE_UNKNOWN";
    $en = "DEVICE_TYPE_UNKNOWN";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function JSON_FORMAT_INVALID($data = ""): ResultData
  {
    $ar = "JSON_FORMAT_INVALID_".$data;
    $en = "JSON_FORMAT_INVALID_".$data;;
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function DEVICE_INFO_MUST_BE_FORMATTED(): ResultData
  {
    $ar = "DEVICE_INFO_MUST_BE_FORMATTED";
    $en = "DEVICE_INFO_MUST_BE_FORMATTED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function DEVICE_APP_TOKEN_MUST_BE_FORMATTED(): ResultData
  {
    $ar = "DEVICE_APP_TOKEN_MUST_BE_FORMATTED";
    $en = "DEVICE_APP_TOKEN_MUST_BE_FORMATTED";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function ERROR_WITH_DATA($data): ResultData
  {
   return new ResultData(false, $data, 00);
  }
  function POST_DATA_NOT_FOUND($num): ResultData
  {
    $ar = "DATA".$num."_NOT_FOUND";
    $en = "DATA".$num."_NOT_FOUND";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }
  function MORE_THAN_POST_DATA(): ResultData
  {
    $ar = "MORE_THAN_POST_DATA";
    $en = "MORE_THAN_POST_DATA";
    return $this->wrong_response->error_response($ar, $en, 1002);
  }

  function resultData($result, $data, $code = 0)
  {
    return new ResultData($result, $data, $code);
  }
}
