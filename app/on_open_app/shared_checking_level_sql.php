<?php

class SharedCheckingLevelSql
{

  public $permission_name;
  private $anonymous_permissions_sql;
  private $anonymous_permissions_groups_sql;
  private $anonymous_maintenance_permissions_sql;
  private $anonymous_permissions_menu_sql;
  // 
  public $block_id;
  public $allow_id;
  public $block_all_id;
  public $permission_id;
  public $app_id;



  function __construct($permission_name)
  {
    $this->permission_name = $permission_name;
    $this->anonymous_permissions_sql = new Anonymous_PermissionsSql();
    $this->anonymous_permissions_groups_sql = new Anonymous_PermissionsGroupsSql();
    $this->anonymous_maintenance_permissions_sql = new Anonymous_MaintenancePermissionsSql();
    $this->anonymous_permissions_menu_sql = new Anonymous_PermissionsMenuSql();
  }


  //before login
  function check_permission($data): string
  {
    // echo $this->permission_name;
    // print_r($data);
    
    $this->app_id = $data["app_id"];
    // echo $this->app_id;
    $group_id = $data["group_id"];
    // To check if permission exist in app group
    $this->permission_id = $this->anonymous_permissions_sql->read_id_sql("'$this->permission_name'");
    $permission_group_id = $this->anonymous_permissions_groups_sql->read_id_sql($this->permission_id, "'$group_id'");
    //
    $this->block_id = $data["block_id"];
    $this->allow_id = $data["allow_id"];
    ;
    $this->block_all_id = $data["block_all_id"];
    ;
    $under_maintenance_id = $data["under_maintenance_id"];
    ;
    $require_update_id = $data["require_update_id"];
    $permission_ium = $this->anonymous_maintenance_permissions_sql->read_status_sql($this->permission_id, "'$under_maintenance_id'", "'$this->app_id'");
    $permission_iru = $this->anonymous_maintenance_permissions_sql->read_status_sql($this->permission_id, "'$require_update_id'", "'$this->app_id'");
    //
    $device_id = $data["device_id"];
    $device_session_id = $data["device_session_id"];
    // Permission Level
    $level_apps_id = $data["level_apps_id"];
    $level_devices_id = $data["level_devices_id"];
    $level_ips_id = $data["level_ips_id"];
    $level_devices_sessions_id = $data["level_devices_sessions_id"];
    //
    $ip = getenv("REMOTE_ADDR");
    // 
    $permission_is_have_blocked_all_l_apps = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, "'$this->block_all_id'", "'$level_apps_id'", "'$this->app_id'");
    $permission_is_have_blocked_all_l_ips = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, "'$this->block_all_id'", "'$level_ips_id'", "'$this->app_id'");
    $permission_is_have_blocked_all_l_devices = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, "'$this->block_all_id'", "'$level_devices_id'", "'$this->app_id'");
    $permission_is_have_blocked_all_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, "'$this->block_all_id'", "'$level_devices_sessions_id'", "'$this->app_id'");
    // 
    $permission_is_have_blocked_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$this->app_id'", "'$this->app_id'");
    $permission_is_have_blocked_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$ip'", "'$this->app_id'");
    $permission_is_have_blocked_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$device_id'", "'$this->app_id'");
    $permission_is_have_blocked_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_devices_sessions_id'", "'$device_session_id'", "'$this->app_id'");
    // 
    $permission_is_have_allow_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$this->app_id'", "'$this->app_id'");
    $permission_is_have_allow_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$ip'", "'$this->app_id'");
    $permission_is_have_allow_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", "'$level_apps_id'", "'$device_id'", "'$this->app_id'");
    $permission_is_have_allow_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->allow_id'", "'$level_devices_sessions_id'", "'$device_session_id'", "'$this->app_id'");

    // 
    $permission_is_have_a_blocked_a_l_apps = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_all_id'", "'$level_apps_id'", "'$this->app_id'", "'$this->app_id'");
    $permission_is_have_a_blocked_a_l_ips = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_all_id'", "'$level_apps_id'", "'$ip'", "'$this->app_id'");
    $permission_is_have_a_blocked_a_l_devices = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_all_id'", "'$level_apps_id'", "'$device_id'", "'$this->app_id'");
    $permission_is_have_a_blocked_a_l_devices_sessions = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_all_id'", "'$level_devices_sessions_id'", "'$device_session_id'", "'$this->app_id'");




    // $device_session_id = $this->anonymous_devices_sessions->read_id_sql($device_id,$this->app_id);



    // echo $permission_group_id;
    // print_r($device_app_ip_session_id);
    $sql = "SELECT 
        ($group_id) as group_id,
        ($permission_group_id) as permission_group_id,
        --
        ($permission_ium) as permission_ium,
        ($permission_iru) as permission_iru,
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
    // print_r($sql);
    return $sql;
  }

  function check_user($user_id,$user_phone, $user_password): string
  {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/onemegasoft1/tables/users/anonymous/sql.php');
    $anonymous_users_sql = new Anonymous_UsersSql();
    // 
    $anonymous_level_permissions_sql = new Anonymous_LevelPermissionsSql();
    $level_users_id = $anonymous_level_permissions_sql->read_id_sql("'USERS'");
    // echo $this->block_all_id;
    //  
    $permission_is_have_blocked_all_l_users = $this->anonymous_permissions_menu_sql->read_id1_sql($this->permission_id, "'$this->block_all_id'", $level_users_id, "'$this->app_id'");

    $permission_is_have_blocked_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_id'", $level_users_id, "'$user_id'", "'$this->app_id'");

    $permission_is_have_allow_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->allow_id'", $level_users_id, "'$user_id'", "'$this->app_id'");

    $permission_is_have_a_blocked_a_l_users = $this->anonymous_permissions_menu_sql->read_id2_sql($this->permission_id, "'$this->block_all_id'", $level_users_id, "'$user_id'", "'$this->app_id'");


    // echo $permission_is_have_blocked_all_l_users;
    $sql = ", ($user_id) as user_id,
    ($level_users_id) as level_users_id,
    ($permission_is_have_blocked_all_l_users) as permission_is_have_blocked_all_l_users,
    ($permission_is_have_blocked_l_users) as permission_is_have_blocked_l_users,
    ($permission_is_have_allow_l_users) as permission_is_have_allow_l_users,
    ($permission_is_have_a_blocked_a_l_users) as permission_is_have_a_blocked_a_l_users

    ";
    return $sql;
  }
}
?>