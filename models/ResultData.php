<?php

class ResultData
{
    public bool $result;
    public int $code;
    public $data;

    public function __construct($result, $data, $code = 0)
    {
        $this->result = $result;
        $this->code = $code;
        $this->data = $data;
    }

    function getUserId()
    {
        return $this->data[0]['user_id'];
    }
    function issetUserId(): bool
    {
        if (isset($this->data[0]['user_id'])) {
            return true;
        }
        return false;
    }
    function issetUserSessionId(): bool
    {
        if (isset($this->data[0]['user_session_id'])) {
            return true;
        }
        return false;
    }

    function getAppId()
    {
        return $this->data[0]['app_id'];
    }
    function getGroupId()
    {
        return $this->data[0]['group_id'];
    }
    function getDeviceTypeName()
    {
        return $this->data[0]['device_type_name'];
    }
    function getDeviceTypeId()
    {
        return $this->data[0]['device_type_id'];
    }
    function getAppVersion()
    {
        return $this->data[0]['app_version'];
    }
    function getDeviceId()
    {
        return $this->data[0]['device_id'];
    }
    function getIp()
    {
        return $this->data[0]['ip'];
    }
    function setDeviceId($data)
    {
        $this->data[0]['device_id'] = $data;
    }
    function getDeviceInfo()
    {
        return $this->data[0]['device_info'];
    }
    function setDeviceInfo($data)
    {
     $this->data[0]['device_info'] = $data;
    }
    function setUserSessionId($data)
    {
     $this->data[0]['user_session_id'] = $data;
    }
    function setIp($data)
    {
     $this->data[0]['ip'] = $data;
    }
    function getDeviceSessionId()
    {
        return $this->data[0]['device_session_id'];
    }
    function getDeviceSessionIpId()
    {
        return $this->data[0]['device_session_ip_id'];
    }
    function getDeviceAppToken()
    {
        return $this->data[0]['device_app_token'];
    }
    function setDeviceSessionId($data)
    {
     $this->data[0]['device_session_id'] = $data;
    }
    function setDeviceSessionIpId($data)
    {
     $this->data[0]['device_session_ip_id'] = $data;
    }
    function setDeviceSessionStatus($data)
    {
     $this->data[0]['device_session_status'] = $data;
    }
    function setDeviceAppToken($data)
    {
     $this->data[0]['device_app_token'] = $data;
    }
    
    
    function getBlockId()
    {
        return $this->data[0]['block_id'];
    }
    function getAllowId()
    {
        return $this->data[0]['allow_id'];
    }
    function getBlockAllId()
    {
        return $this->data[0]['block_all_id'];
    }
    function getUnderMaintenanceId()
    {
        return $this->data[0]['under_maintenance_id'];
    }
    function getRequrieUpdateId()
    {
        return $this->data[0]['require_update_id'];
    }
    function getLevelAppsId()
    {
        return $this->data[0]['level_apps_id'];
    }
    function getLevelDevicesId()
    {
        return $this->data[0]['level_devices_id'];
    }
    function getLevelIpsId()
    {
        return $this->data[0]['level_ips_id'];
    }
    function getLevelDevicesSessionId()
    {
        return $this->data[0]['level_devices_sessions_id'];
    }
    function getPermissionGroupId()
    {
        return $this->data[0]['permission_group_id'];
    }

    // ////////////
    function getPermissionIUM()
    {
        return $this->data[0]['permission_ium'];
    }
    function getPermissionIRU()
    {
        return $this->data[0]['permission_iru'];
    }
    // ////////////
    function getPermissionIsHaveBlockedAllLevelApps()
    {
        return $this->data[0]['permission_is_have_blocked_all_l_apps'];
    }
    function getPermissionIsHaveBlockedAllLevelIps()
    {
        return $this->data[0]['permission_is_have_blocked_all_l_ips'];
    }
    function getPermissionIsHaveBlockedAllLevelDevices()
    {
        return $this->data[0]['permission_is_have_blocked_all_l_devices'];
    }
    function getPermissionIsHaveBlockedAllLevelDevicesSession()
    {
        return $this->data[0]['permission_is_have_blocked_all_l_devices_sessions'];
    }
    function getPermissionIsHaveBlockedAllLevelUsers()
    {
        return $this->data[0]['permission_is_have_blocked_all_l_users'];
    }
    // ///////////////
    function getPermissionIsHaveBlockedLevelApps()
    {
        return $this->data[0]['permission_is_have_blocked_l_apps'];
    }
    function getPermissionIsHaveBlockedLevelIps()
    {
        return $this->data[0]['permission_is_have_blocked_l_ips'];
    }
    function getPermissionIsHaveBlockedLevelDevices()
    {
        return $this->data[0]['permission_is_have_blocked_l_devices'];
    }
    function getPermissionIsHaveBlockedLevelDevicesSessions()
    {
        return $this->data[0]['permission_is_have_blocked_l_devices_sessions'];
    }
    function getPermissionIsHaveBlockedLevelUsers()
    {
        return $this->data[0]['permission_is_have_blocked_l_users'];
    }
    // ////////////////
    function getPermissionIsHaveAllowLevelApps()
    {
        return $this->data[0]['permission_is_have_allow_l_apps'];
    }
    function getPermissionIsHaveAllowLevelIps()
    {
        return $this->data[0]['permission_is_have_allow_l_ips'];
    }
    function getPermissionIsHaveAllowLevelDevices()
    {
        return $this->data[0]['permission_is_have_allow_l_devices'];
    }
    function getPermissionIsHaveAllowLevelDevicesSessions()
    {
        return $this->data[0]['permission_is_have_allow_l_devices_sessions'];
    }
    function getPermissionIsHaveAllowLevelUsers()
    {
        return $this->data[0]['permission_is_have_allow_l_users'];
    }
    // ////////////////////////////
    function getPermissionIsHaveAllowBlockAllLevelApps()
    {
        return $this->data[0]['permission_is_have_a_blocked_a_l_apps'];
    }
    function getPermissionIsHaveAllowBlockAllLevelIps()
    {
        return $this->data[0]['permission_is_have_a_blocked_a_l_ips'];
    }
    function getPermissionIsHaveAllowBlockAllLevelDevices()
    {
        return $this->data[0]['permission_is_have_a_blocked_a_l_devices'];
    }
    function getPermissionIsHaveAllowBlockAllLevelDevicesSessions()
    {
        return $this->data[0]['permission_is_have_a_blocked_a_l_devices_sessions'];
    }
    function getPermissionIsHaveAllowBlockAllLevelUsers()
    {
        return $this->data[0]['permission_is_have_a_blocked_a_l_users'];
    }
}
