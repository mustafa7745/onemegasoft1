<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/onemegasoft1/api/shared/fun_va_post.php");
require_once(getPath() . "app/on_login/permissions/executer.php");
function getPermission($shared_data): Permissions
{
    return new Permissions($shared_data);
}

?>