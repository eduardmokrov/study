<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$addonfolder = str_replace(DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php','', __FILE__);
$addonarray = explode(DIRECTORY_SEPARATOR, $addonfolder);
$addonname = end($addonarray);
$addontype = rtrim(prev($addonarray),'s');

/* LANGUAGE */

${$addonname.'_language'}['chat_with']				 = setLanguageValue('chat_with','Chat with',$lang,$addontype,$addonname);
${$addonname.'_language'}['select_user'] 			 = setLanguageValue('select_user','Who would you like to chat with?',$lang,$addontype,$addonname);
${$addonname.'_language'}['email'] 					 = setLanguageValue('email','Email:',$lang,$addontype,$addonname);
${$addonname.'_language'}['password']				 = setLanguageValue('password','Password:',$lang,$addontype,$addonname);
${$addonname.'_language'}['chat']					 = setLanguageValue('chat',' Chat',$lang,$addontype,$addonname);
${$addonname.'_language'}['facebook']				 = setLanguageValue('facebook','Facebook',$lang,$addontype,$addonname);
${$addonname.'_language'}['signin_to']				 = setLanguageValue('signin_to','Signin to ',$lang,$addontype,$addonname);
${$addonname.'_language'}['processing_login']		 = setLanguageValue('processing_login','Processing login...',$lang,$addontype,$addonname);
${$addonname.'_language'}['facebook_logout']		 = setLanguageValue('facebook_logout','Logout from Facebook',$lang,$addontype,$addonname);
${$addonname.'_language'}['incorrect_login_details'] = setLanguageValue('incorrect_login_details','Incorrect login details. Please try again.',$lang,$addontype,$addonname);
${$addonname.'_language'}['site_users']				 = setLanguageValue('site_users','Site Users',$lang,$addontype,$addonname);
${$addonname.'_language'}['facebook_friends']		 = setLanguageValue('facebook_friends','Facebook Friends',$lang,$addontype,$addonname);
${$addonname.'_language'}['friends']				 = setLanguageValue('friends',' Friends',$lang,$addontype,$addonname);
${$addonname.'_language'}['logout_from']			 = setLanguageValue('logout_from','Logout from ',$lang,$addontype,$addonname);
${$addonname.'_language'}['no_users_online']		 = setLanguageValue('no_users_online','No users online at the moment.',$lang,$addontype,$addonname);
${$addonname.'_language'}['chat_title']				 = setLanguageValue('chat_title',' Chat',$lang,$addontype,$addonname);
${$addonname.'_language'}['gtalk']					 = setLanguageValue('gtalk',' Gtalk',$lang,$addontype,$addonname);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

${$addonname.'_key_mapping'} = array(
	'0'		=>	'chat_with',
	'1'		=>	'select_user',
	'2'		=>	'email',
	'3'		=>	'password',
	'4'		=>	'chat',
	'5'		=>	'facebook',
	'6'		=>	'signin_to',
	'7'		=>	'processing_login',
	'8'		=>	'facebook_logout',
	'9'		=>	'incorrect_login_details',
	'10'	=>	'site_users',
	'11'	=>	'facebook_friends',
	'12'	=>	'friends',
	'13'	=>	'logout_from',
	'14'	=>	'no_users_online',
	'15'	=>	'chat_title',
	'16'	=>	'gtalk'
);

${$addonname.'_language'} = mapLanguageKeys(${$addonname.'_language'},${$addonname.'_key_mapping'},$addontype,$addonname);