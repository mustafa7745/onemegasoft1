<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/onemegasoft1/api/shared/fun_va_post.php");
require_once(getPath() . "app/on_login/groups/executer.php");
function getGroups($shared_data): Groups
{
    return new Groups($shared_data);
}

?>