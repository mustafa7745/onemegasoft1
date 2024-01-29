<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/verification_codes/main_sql.php');

class Whatsapp_VerificationCodesSql extends MainSqlVerificationCodes
{

    function read_row_sql($verification_code_id): string
    {
        $innerJoin = $this->INNER_JOIN();
        $condition = "$this->verification_code_id= $verification_code_id";
        /////
        return $this->r_row_sql($innerJoin, $condition);
    }

    function delete_row_sql($verification_code_id): string
    {
        $table = $this->table_name;
        $condition = "$this->verification_code_id = $verification_code_id";
        /////
        return delete_sql($table, $condition);
    }




}
?>