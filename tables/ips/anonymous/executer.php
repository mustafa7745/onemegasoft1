<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/anonymous/sql.php');
class Anonymous_IpsExecuter extends Anonymous_IpsSql
{

  function execute_insert_sql($ip): ResultData
  {
    $sql1 = $this->insert_sql("'$ip'");
    return shared_execute_insert_server_sql($sql1);
  }
  
}
?>