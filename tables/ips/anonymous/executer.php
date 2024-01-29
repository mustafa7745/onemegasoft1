<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/anonymous/sql.php');
class Anonymous_IpsExecuter extends Anonymous_IpsSql
{

  function execute_insert_sql($ip,$sql2): string
  {
    $sql1 = $this->insert_sql("'$ip'");
    $sql_array = array($sql1,$sql2);

    return shared_execute_more_sql($sql_array);
  }
  
}
?>