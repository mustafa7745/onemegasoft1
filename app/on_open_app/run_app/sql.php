<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/apps_groups/anonymous/sql.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_types/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_groups/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/ips/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/devices_sessions_ips/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/maintenance_permissions/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/block_types/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/permissions_menu/anonymous/sql.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/level_permissions/anonymous/sql.php');



class CheckingAppSql
{
  public $permission_name = "RUN_APP";
  // 
  private $anonymous_apps_sql;
  private $anonymous_apps_groups_sql;
  private $anonymous_devices_types_sql;
  private $anonymous_permissions_sql;
  private $anonymous_permissions_groups_sql;
  private $anonymous_devices_sql;
  private $anonymous_devices_sessions_sql;
  private $anonymous_ips_sql;
  private $anonymous_devices_sessions_ips_sql;
  private $anonymous_maintenance_permissions_sql;
  private $anonymous_block_types_sql;
  private $anonymous_permissions_menu_sql;
  private $anonymous_level_permissions_sql;
  // 
  function __construct()
  {
    $this->anonymous_apps_sql = new Anonymous_AppsSql();
    $this->anonymous_apps_groups_sql = new Anonymous_AppsGroupsSql();
    $this->anonymous_devices_types_sql = new Anonymous_DevicesTypesSql();
    $this->anonymous_permissions_sql = new Anonymous_PermissionsSql();
    $this->anonymous_permissions_groups_sql = new Anonymous_PermissionsGroupsSql();
    $this->anonymous_devices_sql = new Anonymous_DevicesSql();
    $this->anonymous_ips_sql = new Anonymous_IpsSql();
    $this->anonymous_devices_sessions_sql = new Anonymous_DevicesSessionsSql();
    $this->anonymous_devices_sessions_ips_sql = new Anonymous_DevicesSessionsIpsSql();
    $this->anonymous_maintenance_permissions_sql = new Anonymous_MaintenancePermissionsSql();
    $this->anonymous_block_types_sql = new Anonymous_BlockTypesSql();
    $this->anonymous_permissions_menu_sql = new Anonymous_PermissionsMenuSql();
    $this->anonymous_level_permissions_sql = new Anonymous_LevelPermissionsSql();
  }
  public $block_id;
  public $allow_id;
  public $block_all_id;
  public $permission_id;
  public $app_id;
  public $device_session_id;


  //before login
  function check_app($app_package_name, $app_sha256, $p_device_id): string
  {
    // echo getenv("REMOTE_ADDR");
    $this->app_id = $this->anonymous_apps_sql->read_id_sql($app_package_name, $app_sha256);
    $device_type_id = $this->anonymous_apps_sql->read_device_type_id_sql($app_package_name);
    $device_type_name = $this->anonymous_devices_types_sql->read_name_sql($device_type_id);
    $group_id = $this->anonymous_apps_groups_sql->read_group_id_sql($this->app_id);
    $app_version = $this->anonymous_apps_sql->read_version_sql($app_package_name);
    // 
    // print_r($group_id);
    // To check if run app exist in app group
    $this->permission_id = $this->anonymous_permissions_sql->read_id_sql("'$this->permission_name'");
    $permission_group_id = $this->anonymous_permissions_groups_sql->read_id_sql($this->permission_id, $group_id);
    //
    $this->block_id = $this->anonymous_block_types_sql->read_id_sql("'block'");
    $this->allow_id = $this->anonymous_block_types_sql->read_id_sql("'allow'");
    $this->block_all_id = $this->anonymous_block_types_sql->read_id_sql("'block_all'");
    $under_maintenance_id = $this->anonymous_block_types_sql->read_id_sql("'under_maintenance'");
    $require_update_id = $this->anonymous_block_types_sql->read_id_sql("'require_update'");
    // 
    $permission_ium = $this->anonymous_maintenance_permissions_sql->read_status_sql($this->permission_id, $under_maintenance_id, $this->app_id);
    $permission_iru = $this->anonymous_maintenance_permissions_sql->read_status_sql($this->permission_id, $require_update_id, $this->app_id);
    //
    $device_id = $this->anonymous_devices_sql->read_id_sql($p_device_id);
    $device_info = $this->anonymous_devices_sql->read_info_sql($p_device_id);
    //
    //
    $ip = getenv("REMOTE_ADDR");
    $r_ip = $this->anonymous_ips_sql->read_ip_sql();
    // 
    $this->device_session_id = $this->anonymous_devices_sessions_sql->read_id_sql($device_id, $this->app_id);
    $device_session_status = $this->anonymous_devices_sessions_sql->read_status_sql($device_id, $this->app_id);
    $device_app_token = $this->anonymous_devices_sessions_sql->read_token_sql($device_id, $this->app_id);
    //
    $device_session_ip_id = $this->anonymous_devices_sessions_ips_sql->read_id_sql($this->device_session_id, "'$ip'");
    // 
    // Permission Level
    $level_apps_id = $this->anonymous_level_permissions_sql->read_id_sql("'APPS'");
    $level_ips_id = $this->anonymous_level_permissions_sql->read_id_sql("'IPS'");
    $level_devices_id = $this->anonymous_level_permissions_sql->read_id_sql("'Devices'");
    $level_devices_sessions_id = $this->anonymous_level_permissions_sql->read_id_sql("'DEVICES_SESSIONS'");

    // 
    $permission_is_have_blocked_all_l_apps = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, $this->block_all_id, $level_apps_id, $this->app_id);
    $permission_is_have_blocked_all_l_ips = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, $this->block_all_id, $level_ips_id, $this->app_id);
    $permission_is_have_blocked_all_l_devices = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, $this->block_all_id, $level_devices_id, $this->app_id);
    $permission_is_have_blocked_all_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, $this->block_all_id, $level_devices_sessions_id, $this->app_id);
    // 
    $permission_is_have_blocked_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_id, $level_apps_id, $this->app_id, $this->app_id);
    $permission_is_have_blocked_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_id, $level_ips_id, "'$ip'", $this->app_id);
    $permission_is_have_blocked_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_id, $level_devices_id, $device_id, $this->app_id);
    $permission_is_have_blocked_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_id, $level_devices_sessions_id, $this->device_session_id, $this->app_id);
    // 
    $permission_is_have_allow_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->allow_id, $level_apps_id, $this->app_id, $this->app_id);
    $permission_is_have_allow_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->allow_id, $level_ips_id, "'$ip'", $this->app_id);
    $permission_is_have_allow_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->allow_id, $level_devices_id, $device_id, $this->app_id);
    $permission_is_have_allow_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->allow_id, $level_devices_sessions_id, $this->device_session_id, $this->app_id);
    // 
    $permission_is_have_a_blocked_a_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_all_id, $level_apps_id, $this->app_id, $this->app_id);
    $permission_is_have_a_blocked_a_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_all_id, $level_ips_id, "'$ip'", $this->app_id);
    $permission_is_have_a_blocked_a_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_all_id, $level_devices_id, $device_id, $this->app_id);
    $permission_is_have_a_blocked_a_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_all_id, $level_devices_sessions_id, $this->device_session_id, $this->app_id);

    $sql = "SELECT 
        ($this->app_id) as app_id,
        ($group_id) as group_id,
        ($device_type_name) as device_type_name,
        ($device_type_id) as device_type_id,
        ($app_version) as app_version,
        --
        ($device_id) as device_id,
        ($device_info) as device_info,
        -- 
        ($this->device_session_id) as device_session_id,
        ($device_session_status) as device_session_status,
        ($device_app_token) as device_app_token,
        -- 
        ($r_ip) as ip,
        -- 
        ($device_session_ip_id) as device_session_ip_id,
        -- 
        ($this->block_id) as block_id,
        ($this->allow_id) as allow_id,
        ($this->block_all_id) as block_all_id,
        ($under_maintenance_id) as under_maintenance_id,
        ($require_update_id) as require_update_id,
        -- 
        ($level_apps_id) as level_apps_id,
        ($level_devices_id) as level_devices_id,
        ($level_ips_id) as level_ips_id,
        ($level_devices_sessions_id) as level_devices_sessions_id,
        --
        ($permission_ium) as permission_ium,
        ($permission_iru) as permission_iru,
        -- 
        ($permission_group_id) as permission_group_id,
        --
        ($permission_is_have_blocked_all_l_apps) as permission_is_have_blocked_all_l_apps,
        ($permission_is_have_blocked_all_l_ips) as permission_is_have_blocked_all_l_ips,
        ($permission_is_have_blocked_all_l_devices) as permission_is_have_blocked_all_l_devices,
        ($permission_is_have_blocked_all_l_devices_sessions) as permission_is_have_blocked_all_l_devices_sessions,
        -- 
        ($permission_is_have_blocked_l_apps) as permission_is_have_blocked_l_apps,
        ($permission_is_have_blocked_l_ips) as permission_is_have_blocked_l_ips,
        ($permission_is_have_blocked_l_devices) as permission_is_have_blocked_l_devices,
        ($permission_is_have_blocked_l_devices_sessions) as permission_is_have_blocked_l_devices_sessions,
        -- 
        ($permission_is_have_allow_l_apps) as permission_is_have_allow_l_apps,
        ($permission_is_have_allow_l_ips) as permission_is_have_allow_l_ips,
        ($permission_is_have_allow_l_devices) as permission_is_have_allow_l_devices,
        ($permission_is_have_allow_l_devices_sessions) as permission_is_have_allow_l_devices_sessions,
        -- 
        ($permission_is_have_a_blocked_a_l_apps) as permission_is_have_a_blocked_a_l_apps,
        ($permission_is_have_a_blocked_a_l_ips) as permission_is_have_a_blocked_a_l_ips,
        ($permission_is_have_a_blocked_a_l_devices) as permission_is_have_a_blocked_a_l_devices,
        ($permission_is_have_a_blocked_a_l_devices_sessions) as permission_is_have_a_blocked_a_l_devices_sessions
        ";
    return $sql;
  }

  function check_user($user_phone, $user_password): string
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/anonymous/sql.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users_sessions/anonymous/sql.php');

    $anonymous_users_sql = new Anonymous_UsersSql();
    $anonymous_users_sessions_sql = new Anonymous_UsersSessionsSql();
    $user_id = $anonymous_users_sql->read_id_sql("'$user_phone'", "'$user_password'");
    $user_session_id = $anonymous_users_sessions_sql->read_id_sql($user_id,$this->device_session_id);
    $level_users_id = $this->anonymous_level_permissions_sql->read_id_sql("'USERS'");

    $permission_is_have_blocked_all_l_users = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, $this->block_all_id, $level_users_id, $this->app_id);
    //  
    $permission_is_have_blocked_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_id, $level_users_id, $user_id, $this->app_id);
    // 
    $permission_is_have_allow_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->allow_id, $level_users_id, $user_id, $this->app_id);
    // 
    $permission_is_have_a_blocked_a_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, $this->block_all_id, $level_users_id, $user_id, $this->app_id);

    // echo $user_session_id;
    $sql = ", ($user_id) as user_id,
    ($user_session_id) as user_session_id,
    ($level_users_id) as level_users_id,
    ($permission_is_have_blocked_all_l_users) as permission_is_have_blocked_all_l_users,
    ($permission_is_have_blocked_l_users) as permission_is_have_blocked_l_users,
    ($permission_is_have_allow_l_users) as permission_is_have_allow_l_users,
    ($permission_is_have_a_blocked_a_l_users) as permission_is_have_a_blocked_a_l_users

    ";
    return $sql;
  }
}
