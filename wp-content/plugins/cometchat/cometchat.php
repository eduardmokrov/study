<?php

  /**
  * Plugin Name: cometchat
  * Description: Enable audio/video/text chat on your WordPress site in minutes and increase user activity exponentially!
  * Version: 1.0.0
  * Author: CometChat
  * Author URI: http://www.cometchat.com/
  */
  $set_iframe_size = "<script type=\"text/javascript\">
    function cc_iFrameSize(){
      var cc_frame = document.getElementById(\"admin_iframe\");
      var scroll_offset = window.scrollY;
      cc_frame.style.height = '';
      cc_frame.style.height = cc_frame.contentDocument.body.scrollHeight+\"px\";
      cc_frame.style.width = cc_frame.contentDocument.body.scrollWidth+\"px\";
      document.body.scrollTop = scroll_offset;
    }
    </script>";

  include_once(ABSPATH.'wp-admin/includes/plugin.php');
  function add_menu_item() {
    add_menu_page( 'CometChat', 'CometChat', 'manage_options', 'cometchat/cometchatinstall.php', '', plugins_url( 'cometchat/newcometchat.png' ), '2.24' );
  }

  function cometchat_friend_ajax() {
    if(isset($_POST['usergroups'])){
      global $wp_roles;

      $roles = array_keys($wp_roles->get_names());
      $usergroups = $_POST['usergroups'];
      print_r($usergroups);

      $disable_cometchat = array_intersect($roles, $usergroups);
      $enable_cometchat = array_diff($roles, $usergroups);
      //Disable CometChat for selected users
      if(!empty($disable_cometchat)){
        foreach ($disable_cometchat as $key => $value) {
          $role = get_role($value);
          $role->add_cap( 'enable_cometchat',false );
          update_option( $value , 'true', '', 'no');
        }
      }
      //Disable CometChat for selected users
      if(!empty($enable_cometchat)){
        foreach ($enable_cometchat as $key => $value) {
          $role = get_role($value);
          $role->add_cap( 'enable_cometchat',true );
          update_option( $value , 'false', '', 'no');
        }
      }
    }else{
      global $wp_roles;
      $roles = array_keys($wp_roles->get_names());
      foreach ($roles as $value) {
         $role = get_role($value);
         $role->add_cap( 'enable_cometchat',true );
         update_option( $value , 'false', '', 'no');
      }
    }
    if(isset($_POST['hide_bar'])){
      if($_POST['hide_bar'] == 'true'){
        update_option( 'hide_bar' , 'true', '', 'no');
      }else{
      update_option( 'hide_bar', 'false', '', 'no');
      }
    }
    if(isset($_POST['inbox_sync'])){
      if($_POST['inbox_sync'] == 'inbox_sync'){
        update_option( $_POST['inbox_sync'] , 'true', '', 'no');
      }else{
      update_option( 'inbox_sync', 'false', '', 'no');
      }
    }
  die();
  }

  function add_ccbar(){
    if(file_exists(ABSPATH.'cometchat/license.php')){
      if(get_option('hide_bar') == 'true'){
        return;
      }
      if(current_user_can('enable_cometchat')){
        $site_url = get_site_url();
        echo "<link type=\"text/css\" href=\"".$site_url."/cometchat/cometchatcss.php\" rel=\"stylesheet\" charset=\"utf-8\" />
        <script type=\"text/javascript\" src= \"".$site_url."/cometchat/cometchatjs.php\" charset=\"utf-8\"></script>";
      }
    }
  }

  function add_customjs(){
    global $set_iframe_size;
    echo $set_iframe_size;
  }

  function remove_cometchat_database() {
    global $wpdb;

    global $wp_roles;
    $roles = array_keys($wp_roles->get_names());
    foreach ($roles as $key => $value) {
        delete_option($value);
    }
    delete_option('inbox_sync');
    delete_option('hide_bar');
    $path = ABSPATH.'cometchat/';
    function rrmdir_recursive($dir) {
      if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
          if ($object != "." && $object != "..") {
            if (filetype($dir."/".$object) == "dir"){
                rrmdir_recursive($dir."/".$object);
            }else{
                unlink($dir."/".$object);
            }
          }
        }
        reset($objects);
        rmdir($dir);
      }
    }
    rrmdir_recursive($path);
    $sql = $wpdb->get_results("SELECT CONCAT( 'DROP TABLE IF EXISTS ', GROUP_CONCAT(table_name) , '' ) AS statement FROM information_schema.tables WHERE table_schema = '$wpdb->dbname' and table_name like 'cometchat%'");
    $wpdb->query($sql[0]->statement);
  }

  function register_settings() {
      global $wp_roles;
      $roles = array_keys($wp_roles->get_names());
      foreach ($roles as $key => $value) {
          $role = get_role($value);
          $role->add_cap( 'enable_cometchat',true );
      }
      add_option('inbox_sync','true','','no');
      add_option('hide_bar','false','','no');
  }

  function insert_buddypress_message_first( BP_Messages_Message $message){
    if(get_option('inbox_sync') == 'true'){
      global $wpdb;
      $from = bp_loggedin_user_id();
      $msg = $_POST['content'];
      $sent = time();
      $recipients = $message->recipients;
       foreach ($recipients as $key => $value) {
        if($recipients[$key]->user_id != $from){
          $to = $recipients[$key]->user_id;
          $sql = ("INSERT INTO cometchat(`from`,`to`,`message`,`sent`,`read`,`direction`) VALUES ('".$from."','".$to."','".$msg."','".$sent."',1,0)");
          $wpdb->query($sql);
        }
      }
    }
    add_option('inbox_sync','true','','no');
  }

	register_activation_hook( __FILE__, 'register_settings');
  	add_action('admin_menu', 'add_menu_item');

  	add_action('wp_head', 'add_ccbar');
  	add_action('admin_enqueue_scripts','add_customjs');
  	add_action( 'wp_ajax_cometchat_friend_ajax', 'cometchat_friend_ajax');
  	register_uninstall_hook( __FILE__, 'remove_cometchat_database' );
  	add_action( 'messages_message_after_save', 'insert_buddypress_message_first');
?>