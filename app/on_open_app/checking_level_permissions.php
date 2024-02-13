<?php

class CheckingLevelPermissions
{
    private $permission_name;

    function check_all($data, $app_version, $permission_name)
    {
        $this->permission_name = $permission_name;
        if (isset($data["user_id"]) and $data["user_id"] != null) {
            $v1 = $this->check_user($data, $app_version, $this->permission_name);
            $c1 = json_decode($v1, true);
            if ($c1["result"]) {
                // array_splice($this->app_data, 21);
                return fun()->SUCCESS_WITH_DATA($data);
            }
            return $v1;
        }


        $v1 = $this->check_anonymous($data, $app_version, $permission_name);
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            array_splice($data, 21);
            return fun()->SUCCESS_WITH_DATA($data);
        }
        return $v1;
    }

    function check_anonymous($data, $app_version, $permission_name)
    {
        // print_r($data["permission_group_id"]);
        // print_r($permission_name);
        $this->permission_name = $permission_name;
        $v1 = $this->check_permission($data, $app_version);
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            return fun()->SUCCESS_WITH_DATA($data);
        }
        return $v1;
    }
    function check_user($data, $app_version, $permission_name)
    {
        // print_r($permission_name);
        $this->permission_name = $permission_name;
        $v1 = $this->check_permission($data, $app_version);
        $c1 = json_decode($v1, true);
        if ($c1["result"]) {
            $v1 = $this->check_users_level($data);
            $c1 = json_decode($v1, true);
            if ($c1["result"]) {
                return fun()->SUCCESS_WITH_DATA($data);
            }
            return $v1;
        }
        return $v1;
    }

    private function check_permission($data, $app_version)
    {
        if ($data["group_id"] != null) {
            if ($data["permission_group_id"] != null) {
                if (!$data["permission_ium"]) {
                    if (!$data["permission_iru"]) {
                        return $this->check_apps_level($data);
                    }
                    // print_r($data["app_version"]);
                    if ($data["app_version"] <= $app_version) {
                        return $this->check_apps_level($data);
                    }
                    return fun()->PERMISSION_REQUIRED_UPDATE($this->permission_name);
                }
                return fun()->PERMISSION_UNDER_MAINTANANCE($this->permission_name);
            }
            return fun()->NOT_FOUND_IN_THIS_GROUP_PERMISSIONS($this->permission_name);
        }
        return fun()->APP_NOT_HAVE_GROUP();

    }

    private function check_apps_level($data)
    {
        if ($data["permission_is_have_blocked_all_l_apps"] != null) {
            if ($data["permission_is_have_a_blocked_a_l_apps"] != null) {
                return $this->check_ips_level($data);
            }
            if ($data["permission_is_have_allow_l_apps"] != null) {
                return $this->check_ips_level($data);
            }
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_APP($this->permission_name);
        }
        //
        if ($data["permission_is_have_blocked_l_apps"] != null) {
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_APP($this->permission_name);
        }
        return $this->check_ips_level($data);
    }

    private function check_ips_level($data)
    {
        if ($data["permission_is_have_blocked_all_l_ips"] != null) {
            // print_r("ff");
            if ($data["permission_is_have_a_blocked_a_l_ips"] != null) {
                return $this->check_devices_level($data);
            }
            if ($data["permission_is_have_allow_l_ips"] != null) {
                return $this->check_devices_level($data);
            }
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_IP($this->permission_name);
        }
        if ($data["permission_is_have_blocked_l_ips"] != null) {
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_IP($this->permission_name);
        }
        return $this->check_devices_level($data);
    }

    private function check_devices_level($data)
    {
        if ($data["permission_is_have_blocked_all_l_devices"] != null) {
            //    print_r("ff");
            if ($data["permission_is_have_a_blocked_a_l_devices"] != null) {
                return $this->check_devices_sessions_level($data);
            }
            if ($data["permission_is_have_allow_l_devices"] != null) {
                return $this->check_devices_sessions_level($data);
            }
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVICE($this->permission_name);
        }
        if ($data["permission_is_have_blocked_l_devices"] != null) {
            // print_r("ff");
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVICE($this->permission_name);
        }
        return $this->check_devices_sessions_level($data);
    }
    private function check_devices_sessions_level($data)
    {
        // print_r("df");
        if ($data["permission_is_have_blocked_all_l_devices_sessions"] != null) {
            //    print_r("ff");
            if ($data["permission_is_have_a_blocked_a_l_devices_sessions"] != null) {
                return fun()->SUCCESS_WITH_DATA($data);
            }
            if ($data["permission_is_have_allow_l_devices_sessions"] != null) {
                return fun()->SUCCESS_WITH_DATA($data);
            }
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVICE($this->permission_name);
        }
        if ($data["permission_is_have_blocked_l_devices_sessions"] != null) {
            // print_r("ff");
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_DEVICE($this->permission_name);
        }
        return fun()->SUCCESS_WITH_DATA($data);
    }

    private function check_users_level($data)
    {
        // print_r("df");
        if ($data["permission_is_have_blocked_all_l_users"] != null) {
            //    print_r("ff");
            if ($data["permission_is_have_a_blocked_a_l_users"] != null) {
                return fun()->SUCCESS_WITH_DATA($data);
            }
            if ($data["permission_is_have_allow_l_users"] != null) {
                return fun()->SUCCESS_WITH_DATA($data);
            }
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_USER($this->permission_name);
        }
        if ($data["permission_is_have_blocked_l_users"] != null) {
            // print_r("ff");
            return fun()->PERMISSION_IS_BLOCKED_FROM_USE_IN_THIS_USER($this->permission_name);
        }
        return fun()->SUCCESS_WITH_DATA($data);
    }
}
