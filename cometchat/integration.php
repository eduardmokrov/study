<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */
$cms = "wordpress";
define('SET_SESSION_NAME','');			// Session name
define('SWITCH_ENABLED','0');
define('INCLUDE_JQUERY','1');
define('FORCE_MAGIC_QUOTES','1');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

if(!file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-config.php')) {
	echo "Please check if CometChat is installed in the correct directory.<br /> The 'cometchat' folder should be placed at <WORDPRESS_HOME_DIRECTORY>/cometchat";
	exit;
}
include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-config.php');

// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW

define('DB_SERVER',			DB_HOST					);
define('DB_PORT',			"3306"					);
define('DB_USERNAME',			DB_USER					);

$table_prefix = $table_prefix;									// Table prefix(if any)
$db_usertable = 'users';							// Users or members information table name
$db_usertable_userid = 'ID';						// UserID field in the users or members table
$db_usertable_name = 'display_name';					// Name containing field in the users or members table
$db_avatartable = ' ';
$db_avatartable = "left join ".$table_prefix."usermeta on ".$table_prefix.$db_usertable.".".$db_usertable_userid."=".$table_prefix."usermeta.user_id and ".$table_prefix."usermeta.meta_key = 'wsl_current_user_image' ";
$db_avatarfield = " coalesce(concat(".$table_prefix.$db_usertable.".".$db_usertable_userid.",'|',".$table_prefix.$db_usertable.".user_email,'|',".$table_prefix."usermeta.meta_value),concat(".$table_prefix.$db_usertable.".".$db_usertable_userid.",'|',".$table_prefix.$db_usertable.".user_email))";
$db_linkfield = ' '.$table_prefix.$db_usertable.'.'.$db_usertable_userid.' ';

/*COMETCHAT'S INTEGRATION CLASS USED FOR SITE AUTHENTICATION */

class Integration{

	function __construct(){
		if(!defined('TABLE_PREFIX')){
			$this->defineFromGlobal('table_prefix');
			$this->defineFromGlobal('db_usertable');
			$this->defineFromGlobal('db_usertable_userid');
			$this->defineFromGlobal('db_usertable_name');
			$this->defineFromGlobal('db_avatartable');
			$this->defineFromGlobal('db_avatarfield');
			$this->defineFromGlobal('db_linkfield');
		}
	}

	function defineFromGlobal($key){
		if(isset($GLOBALS[$key])){
			define(strtoupper($key), $GLOBALS[$key]);
			unset($GLOBALS[$key]);
		}
	}



	function getUserID() {
		$userid = 0;

		if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
			$_REQUEST['basedata'] = $_SESSION['basedata'];
		}

		if (!empty($_REQUEST['basedata'])) {

			if (function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
				$key = "";
				if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
					$key = KEY_A.KEY_B.KEY_C;
				}
				$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($_REQUEST['basedata'])), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
				if (intval($uid) > 0) {
					$userid = $uid;
				}
			} else {
				$userid = $_REQUEST['basedata'];
			}
		}

		if (isset($_COOKIE[LOGGED_IN_COOKIE]) && (empty($userid) || $userid == "null")) {
			$username = explode("|", $_COOKIE[LOGGED_IN_COOKIE]);
			$sql = ("SELECT ID FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE user_login = '".mysqli_real_escape_string($GLOBALS['dbh'],$username[0])."'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$userid = $row['ID'];
		}

		if (!isset($_SESSION['cometchat']['cookieval'])) {
			$sql = ("SELECT option_value FROM ".TABLE_PREFIX."options WHERE option_name = 'siteurl'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$_SESSION['cometchat']['cookieval'] = 'wordpress_logged_in_'.md5($row['option_value']);
		}

		if (isset($_COOKIE[$_SESSION['cometchat']['cookieval']]) && (empty($userid) || $userid == "null")) {
			$username = explode("|", $_COOKIE[$_SESSION['cometchat']['cookieval']]);
			$sql = ("SELECT ID FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE user_login = '".mysqli_real_escape_string($GLOBALS['dbh'],$username[0])."'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$userid = $row['ID'];
		}

		$userid = intval($userid);
		return $userid;
	}

	function chatLogin($userName,$userPass) {

		$userid = 0;
		global $guestsMode;

		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-includes'.DIRECTORY_SEPARATOR.'class-phpass.php');
		$hasher = new PasswordHash(8, false);
		if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
			$sql = ("SELECT * FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE user_email = '".mysqli_real_escape_string($GLOBALS['dbh'],$userName)."'");
		} else {
			$sql = ("SELECT * FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE user_login = '".mysqli_real_escape_string($GLOBALS['dbh'],$userName)."'");
		}
		$result = mysqli_query($GLOBALS['dbh'],$sql);
		$row = mysqli_fetch_assoc( $result );
		$check = $hasher->CheckPassword($userPass, $row['user_pass']);
		if ($check) {
			$userid = $row['ID'];
			$sql = ("SELECT option_value FROM ".TABLE_PREFIX."options WHERE option_name = '_transient_plugin_slugs'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$option_value = $row['option_value'];
			$option_value = unserialize($option_value);
			$cc_plugin = 'cometchat/cometchat.php';
			if(in_array($cc_plugin, $option_value)){
				$sql = ("SELECT option_value FROM ".TABLE_PREFIX."options WHERE option_name = 'active_plugins'");
				$result = mysqli_query($GLOBALS['dbh'],$sql);
				$row = mysqli_fetch_assoc($result);
				$active_plugins= $row['option_value'];
				$active_plugins = unserialize($active_plugins);
				$cc_plugin = 'cometchat/cometchat.php';
				if(in_array($cc_plugin, $active_plugins)){
					$sql = ("SELECT meta_value FROM ".TABLE_PREFIX."usermeta WHERE user_id = '".$userid."' AND meta_key = 'wp_capabilities'");
					$result = mysqli_query($GLOBALS['dbh'],$sql);
					$row = mysqli_fetch_assoc($result);
					$usergroup = $row['meta_value'];
					$usergrp = unserialize($usergroup);
					$usergrp = array_keys($usergrp);
					$usergrp = $usergrp[0];
					$sql = ("SELECT option_value FROM ".TABLE_PREFIX."options WHERE option_name = '".$usergrp."'");
					$result = mysqli_query($GLOBALS['dbh'],$sql);
					$row = mysqli_fetch_assoc($result);
					$opt_value = $row['option_value'];
					if($opt_value == 'true'){
						return 0;
					}
				}else{
					return 0;
				}
			}
		}

		if(!empty($userName) && !empty($_REQUEST['social_details'])) {
			$social_details = json_decode($_REQUEST['social_details']);
			$userid = socialLogin($social_details);
		}
		if(!empty($_REQUEST['guest_login']) && $userPass == "CC^CONTROL_GUEST" && $guestsMode == 1){
			$userid = getGuestID($userName);
		}
		if(!empty($userid) && isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp'){
			$sql = ("insert into cometchat_status (userid,isdevice) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','1') on duplicate key update isdevice = '1'");
			mysqli_query($GLOBALS['dbh'], $sql);
		}
		if ($userid && function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
			$key = "";
			if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
				$key = KEY_A.KEY_B.KEY_C;
			}
			$userid = rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key)))));
		}

		return $userid;
	}

	function getFriendsList($userid,$time) {
		global $hideOffline;
		$offlinecondition = '';
		if ($hideOffline) {
			$offlinecondition = "where ((cometchat_status.lastactivity > (".mysqli_real_escape_string($GLOBALS['dbh'],$time)."-".((ONLINE_TIMEOUT)*2).")) OR cometchat_status.isdevice = 1) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline')";
		}
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".user_nicename link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." ".$offlinecondition." order by username asc");

		return $sql;
	}

	function getFriendsIds($userid) {

		$sql = ("select ".TABLE_PREFIX."friends.friend_user_id friendid from ".TABLE_PREFIX."friends where ".TABLE_PREFIX."friends.initiator_user_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and is_confirmed = 1 union select ".TABLE_PREFIX."friends.initiator_user_id friendid from ".TABLE_PREFIX."friends where ".TABLE_PREFIX."friends.friend_user_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and is_confirmed = 1");

		return $sql;
	}

	function getUserDetails($userid) {
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".user_nicename link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

		return $sql;
	}

	function getUserDesc($userid) {
		$user_desc=get_the_author_meta('description', $userid);

		return $user_desc;
	}

	function getActivechatboxdetails($userids) {
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username,  ".TABLE_PREFIX.DB_USERTABLE.".user_nicename link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." IN (".$userids.")");

		return $sql;
	}

	function getUserStatus($userid) {
		$sql = ("select cometchat_status.message, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status from cometchat_status where userid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
		return $sql;
	}

	function fetchLink($link) {
		$cc_url = (defined('CC_SITE_URL') ? CC_SITE_URL : BASE_URL);
		return $cc_url.'../members/'.$link;
	}

	function getAvatar($data) {
		if(!empty($data)) {
			$data = explode('|',$data);
			$id = $data[0];
			if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-content'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'avatars' .DIRECTORY_SEPARATOR. $id)) {
				$files = "";
				if ($handle = opendir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-content'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'avatars' .DIRECTORY_SEPARATOR. $id)) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if(substr($file, -11, 7) == "bpthumb" ) {
								$files .= $file;
							}
						}
					}
					closedir($handle);
				}
				if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'wp-content'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'avatars' .DIRECTORY_SEPARATOR. $id .DIRECTORY_SEPARATOR. $files)) {
					$cc_url = (defined('CC_SITE_URL') ? CC_SITE_URL : BASE_URL);
					return $cc_url.'../wp-content/uploads/avatars/'.$id.'/'.$files;
				}
			}else if(!empty($data[2])){
				return $data[2];
			}else{
				return '//www.gravatar.com/avatar/'.md5($data[1]).'?d=wavatar&s=80';
			}
		}
		else {
			return BASE_URL.'images/noavatar.png';
		}
	}

	function getTimeStamp() {
		return time();
	}

	function processTime($time) {
		return $time;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/* HOOKS */

	function hooks_message($userid,$to,$unsanitizedmessage,$dir) {

	}

	function hooks_forcefriends() {

	}

	function hooks_updateLastActivity($userid) {

	}

	function hooks_statusupdate($userid,$statusmessage) {

	}

	function hooks_activityupdate($userid,$status) {

	}

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'license.php');
$x = "\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
