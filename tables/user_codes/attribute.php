<?php
class UserCodesAttribute
{
    public $name = "user_code";
    ////
    public $table_name = "user_codes";
    public $user_code = "user_code";
    public $user_id = "user_id";
    public $app_id = "app_id";
    public $mycode_id = "mycode_id";
    public $user_code_status = "user_code_status";
    public $user_code_created_at = "user_code_created_at";
    public $user_code_updated_at = "user_code_updated_at";
    /////
    public $users_attribute;
    public $apps_attribute;
    public $mycodes_attribute;
    function initForignKeys()
    {
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/attribute.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/mycodes/attribute.php');
        $this->mycodes_attribute = new MyCodesAttribute();
        $this->users_attribute = new UsersAttribute();
        $this->apps_attribute = new AppsAttribute();
    }
    /////
    public $json;
    function initJson()
    {
        $this->json = function ($data, $i) {
            return $this->jsonF($data, $i);
        };
    }
    /////json function
    function jsonF($data, $i)
    {
        // echo "df";
        $this->initForignKeys();
        return json_encode(
            array(
                "$this->user_code" => $data[$i]["$this->user_code"],
                "{$this->users_attribute->name}" => json_decode($this->users_attribute->jsonF($data, $i)),
                "{$this->apps_attribute->name}" => json_decode($this->apps_attribute->jsonF($data, $i)),
                "{$this->mycodes_attribute->name}" => json_decode($this->mycodes_attribute->jsonF($data, $i)),
                "$this->user_code_status" => $data[$i]["$this->user_code_status"],
                "$this->user_code_created_at" => $data[$i]["$this->user_code_created_at"],
                "$this->user_code_updated_at" => $data[$i]["$this->user_code_updated_at"],
            )
        );
    }

    /////Native Inner join
    function NATIVE_INNER_JOIN(): string
    {
        $inner = NATIVE_INNER_JOIN($this->table_name, $this->user_code);
        return $inner;
    }
    /////Inner join
    function INNER_JOIN(): string
    {
        $this->initForignKeys();
        $inner = FORIGN_KEY_ID_INNER_JOIN($this->mycodes_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->mycode_id)
            . " " .
            $this->mycodes_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->apps_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->app_id)
            . " " .
            $this->apps_attribute->INNER_JOIN()
            . " " .
            FORIGN_KEY_ID_INNER_JOIN($this->users_attribute->NATIVE_INNER_JOIN(), $this->table_name, $this->user_id)
            . " " .
            $this->users_attribute->INNER_JOIN();
        return $inner;
    }


}
?>