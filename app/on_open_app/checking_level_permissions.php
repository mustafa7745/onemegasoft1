<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/app/on_open_app/checking_level_permissions.php');
class CheckingLevelPermissions
{
    private $permission_name;
    private $app_version;

    function check_all(ResultData $data, $app_version, $permission_name): ResultData
    {
        $this->permission_name = $permission_name;
        $this->app_version = $app_version;
        if ($data->issetUserId() and $data->getUserId() != null) {
            return $this->check_user($data, $this->permission_name);
        }
        
        return $this->check_anonymous($data, $permission_name);
    }

    private function check_anonymous(ResultData $data, $permission_name)
    {
        return $this->check_permission($data);
    }
    private function check_user(ResultData $data, $permission_name)
    {
        $resultData = $this->check_permission($data);
        if ($resultData->result) {
            return $this->check_users_level($data);
        }
        return $resultData;

    }

    private function check_permission(ResultData $data): ResultData
    {
        if ($data->getGroupId() != null) {
            if ($data->getPermissionGroupId() != null) {
                if (!$data->getPermissionIUM()) {
                    if (!$data->getPermissionIRU()) {
                        return $this->check_apps_level($data);
                    }
                    // print_r($data);
                    // print_r($data["app_version"]);
                    if ($data->getAppVersion() <= $this->app_version) {
                        return $this->check_apps_level($data);
                    }
                    return fun1()->PERMISSION_REQUIRED_UPDATE($this->permission_name);
                }
                return fun1()->PERMISSION_UNDER_MAINTANANCE($this->permission_name);
            }
            return fun1()->NOT_FOUND_IN_THIS_GROUP_PERMISSIONS($this->permission_name);
        }
        return fun1()->APP_NOT_HAVE_GROUP();

    }

    private function check_apps_level(ResultData $data): ResultData
    {
        $place = "APP";

        if ($data->getPermissionIsHaveBlockedAllLevelApps() != null) {
            if ($data->getPermissionIsHaveAllowBlockAllLevelApps() != null) {
                return $this->check_ips_level($data);
            }
            if ($data->getPermissionIsHaveAllowLevelApps() != null) {
                return $this->check_ips_level($data);
            }
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        //
        if ($data->getPermissionIsHaveBlockedLevelApps() != null) {
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        return $this->check_ips_level($data);
    }

    private function check_ips_level(ResultData $data): ResultData
    {
        $place = "IP";
        if ($data->getPermissionIsHaveBlockedAllLevelIps() != null) {
            // print_r("ff");
            if ($data->getPermissionIsHaveAllowBlockAllLevelIps() != null) {
                return $this->check_devices_level($data);
            }
            if ($data->getPermissionIsHaveAllowLevelIps() != null) {
                return $this->check_devices_level($data);
            }
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        if ($data->getPermissionIsHaveBlockedLevelIps() != null) {
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        return $this->check_devices_level($data);
    }

    private function check_devices_level(ResultData $data): ResultData
    {
        $place = "DEVICE";
        if ($data->getPermissionIsHaveBlockedAllLevelDevices() != null) {
            //    print_r("ff");
            if ($data->getPermissionIsHaveAllowBlockAllLevelDevices() != null) {
                return $this->check_devices_sessions_level($data);
            }
            if ($data->getPermissionIsHaveAllowLevelDevices() != null) {
                return $this->check_devices_sessions_level($data);
            }
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        if ($data->getPermissionIsHaveBlockedLevelDevices() != null) {
            // print_r("ff");
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        return $this->check_devices_sessions_level($data);
    }
    private function check_devices_sessions_level(ResultData $data): ResultData
    {
        $place = "DEVICE_SESSION";
        // print_r("df");
        if ($data->getPermissionIsHaveBlockedAllLevelDevicesSession() != null) {
            //    print_r("ff");
            if ($data->getPermissionIsHaveAllowBlockAllLevelDevicesSessions() != null) {
                return $data;
            }
            if ($data->getPermissionIsHaveAllowLevelDevicesSessions() != null) {
                return $data;
            }
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        if ($data->getPermissionIsHaveBlockedLevelDevicesSessions() != null) {
            // print_r("ff");
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        return $data;
    }

    private function check_users_level(ResultData $data): ResultData
    {
        $place = "USER";
        // print_r("df");
        if ($data->getPermissionIsHaveBlockedAllLevelUsers() != null) {
            //    print_r("ff");
            if ($data->getPermissionIsHaveAllowBlockAllLevelUsers() != null) {
                return $data;
            }
            if ($data->getPermissionIsHaveAllowLevelUsers() != null) {
                return $data;
            }
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        if ($data->getPermissionIsHaveBlockedLevelUsers() != null) {
            // print_r("ff");
            return fun1()->PERMISSION_IS_BLOCKED_FROM_USE_IN($this->permission_name, $place);
        }
        return $data;
    }
}
