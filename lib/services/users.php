<?php
function mcc_get_user($user_id, $required = false) {
	global $Users;
	
	$user = false;
	
	if (is_numeric ( $user_id )) {
		$user = mcc_get_user_by_id ( $user_id, $required );
	}
	
	if (is_email ( $user_id )) {
		$user = mcc_get_user_by_email ( $user_id, $required );
	}
	
	if (!$user && $user_id != '') {
		$user = mcc_get_user_by_username ( $user_id, $required );
	}
	
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
		
	return $user;
}

function mcc_get_user_by_id($user_id, $required = false) {
	global $Users;
	
	$user = $Users->load ( $user_id );
	
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_user_by_username($username, $required = false) {
	global $Users;
	
	$user = $Users->fetch_one ( array ('username' => $username ) );
	
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_user_by_nickname($nickname, $required = false) {
	global $Users;
	$user = $Users->fetch_one ( array ('nickname' => $nickname ) );
	
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_forget_user($criteria, $required = false) {
	global $Users;
	$user = $Users->fetch_one ( array (array ('email' => $criteria ), 'or', array ('username' => $criteria ) ) );
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_user_by_email($email, $required = false) {
	global $Users;
	
	$user = $Users->fetch_one ( array ('email' => $email ) );
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_user_by_phone_number($phone_number, $required = false) {
	global $Users;
	if (!is_numeric($phone_number)) {
		if ($required) 
			throw new Exception ( '用户不存在', 404 );
		return false;
	}
	$user = $Users->fetch_one ( array ('phone_number' => $phone_number ) );
	if ($required && $user === false)
		throw new Exception ( '用户不存在', 404 );
	
	return $user;
}

function mcc_get_users_by_nickname($nickname, $id_only = false) {
	global $Users;
	
	$query = array ('nickname' => $nickname );
	
	return $Users->fetch ( $query, $id_only );
}

function mcc_get_user_profile($user = false) {
	
	global $UserProfile, $auth;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	
	$profile = $UserProfile->load ( $user_id );
	if ($profile == false && $user_id > 0) {
		$profile = $UserProfile->new_object ( array (
							'user_id' 				=> $user_id, 
							'vip_show_stock_module' => '1', 
							'vip_discount'			=> '0.8', 
					) 
		);
		$profile->insert ();
	}
	
	return $profile;
}

function mcc_get_user_accounts($criteria = false, $page = false, $per_page = false) {
	global $auth, $UserAccount;
	
	$query = array ('order_by' => 'last_updated desc', 'page' => $page, 'per_page' => $per_page );
	
	if ($criteria !== false) {
		$query = array_merge ( $query, $criteria );
	}
	
	return $UserAccount->fetch ( $query );
}


function mcc_get_user_logins($criteria = false, $page = false, $per_page = false) {
	global $UserLogins;
	
	$query = array ('order_by' => 'login_at desc', 'page' => $page, 'per_page' => $per_page );
	
	if ($criteria !== false) {
		$query = array_merge ( $query, $criteria );
	}
	
	return $UserLogins->fetch ( $query );
}

function mcc_get_user_login($criteria = false) {
	global $UserLogins;
	
	$query = array ('order_by' => 'login_at desc');
	
	if ($criteria !== false) {
		$query = array_merge ( $query, $criteria );
	}
	
	return $UserLogins->fetch_one ( $query );
}

function mcc_get_user_account($user = false) {
	
	global $auth, $UserAccount;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	
	$user_account = $UserAccount->load ( $user_id );
	if ($user_account == false) {
		$created_at = time ();
		$user_account = $UserAccount->new_object ( array ('user_id' => $user_id, 'created_at' => $created_at, 'last_updated' => $created_at ) );
		$user_account->insert ();
	}
	return $user_account;
}

function mcc_update_user_scores($user, $scores) {
	global $auth, $UserAccount;
	
	$user_id = is_object ( $user ) ? $user->user_id : $user;
	if (is_numeric ( $scores )) {
		$user_account = mcc_get_user_account ( $user );
		$user_account->scores = $user_account->scores + $scores;
		if ($user_account->scores < 0) return false; 
		$user_account->update ();

		return $user_account;
	}
	return false;
}

function mcc_setting_user_profile($user, $investment_content) {
	
	global $UserProfile, $auth;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	
	$profile = $UserProfile->load ( $user_id );
	if ($profile !== false) {
		
		$profile->investment_monitor = $investment_content;
		$profile->update ();
		
		return $profile;
	} else {
		$profile = $UserProfile->new_object ( array ('user_id' => $user_id, 'investment_monitor' => $investment_content ) );
		$profile->insert ();
		
		return $profile;
	}

}

function mcc_signup_user($data) {
	global $Users, $UserAccount, $auth;
	
	$created_at = time ();
	$user = $Users->new_object ( $data );
	$user->created_at = $created_at;
	$user->password = $auth->create_hashed_password ( $data ['password'] );
	$user->insert ();
	
	return $user;
}

function  mcc_init_user_data($user) {
	global $Users, $UserAccount, $auth;
	
	//创建用户账户
	$user_account = $UserAccount->load($user->user_id);
	if($user_account == false) {
		$created_at = time ();
		$user_account = $UserAccount->new_object ( array ('user_id' => $user->user_id, 'created_at' => $created_at, 'last_updated' => $created_at ) );
		$user_account->insert ();
	}
}

function mcc_add_user($data) {
	global $Users, $UserProfile, $auth;
	$user = $Users->new_object ( $data );
	$user->created_at = time ();
	$user->password = $auth->create_hashed_password ( $data ['password'] );
	$user->nickname = $data ['nickname'];
	$user->roles = $data ['role'];
	$user->insert ();
	return $user;
}

function mcc_change_password($user, $password) {
	
	if (! is_object ( $user ))
		$user = mcc_get_user ( $user );
	
	if ($user !== false) {
		$user->password = $password;
		$user->update ();
		return $user;
	}
	return false;
}

function mcc_lock_user($user, $note) {
    global $auth;
	if (! is_object ( $user ))
		$user = mcc_get_user ( $user );
		
	if ($user !== false) {
		$user->roles = 'disabled';
		$user->update ();
		
		$auth->kickuser($user);
		
		return $user;
	}
	return false;
}
function mcc_unlock_user($user, $note) {
	
	if (! is_object ( $user ))
		$user = mcc_get_user ( $user );
		
	if ($user !== false) {
		$user->roles = 'ok';
		$user->update ();
		return $user;
	}
	return false;
}

function mcc_remove_user($user) {
	if ($user !== false) {
		$user->delete ();
	}
}

function mcc_get_roles($role) {
	$roles = array ();
	switch ($role) {
		case USER_ADMIN :
			$roles = array (USER_DISABLED, USER_OK, USER_ACE, USER_ADVISER, USER_ANALYST, USER_UNVERIFIY, USER_MINGREN, USER_CS, USER_MANAGER );
			break;
		case USER_MANAGER :
			$roles = array (USER_DISABLED, USER_OK, USER_ACE, USER_ADVISER, USER_ANALYST, USER_UNVERIFIY, USER_MINGREN, USER_CS );
			break;
		case USER_CS :
			$roles = array (USER_DISABLED, USER_OK, USER_ACE, USER_ADVISER, USER_ANALYST, USER_UNVERIFIY, USER_MINGREN );
			break;
	}
	
	return $roles;
}

function mcc_get_users($criteria = false, $page = 1, $per_page = 20, $id_only = false) {
	global $Users;
	
	$query = array ('order_by' => 'created_at desc', 'page' => $page, 'per_page' => $per_page );
	
	if ($criteria !== false) {
		if (array_key_exists ( 'roles', $criteria )) {
			if (is_array ( $criteria ['roles'] )) {
				$query [] = $criteria ['roles'];
				unset ( $criteria ['roles'] );
			}
		}
		$query = array_merge ( $query, $criteria );
	}
	$result = $Users->fetch ( $query, $id_only );
	
	return $result;
}

function mcc_count_users($criteria = false, $page = false, $per_page = false) {
	global $Users;
	
	$query = array ('page' => $page, 'per_page' => $per_page );
	
	if ($criteria !== false) {
		if (array_key_exists ( 'roles', $criteria )) {
			if (is_array ( $criteria ['roles'] )) {
				$query [] = $criteria ['roles'];
				unset ( $criteria ['roles'] );
			}
		}
		$query = array_merge ( $query, $criteria );
	}
	
	return $Users->count( $query );
}

function mcc_search_people($criteria, $page, $per_page) {
	global $Users;
	
	_require (DOC_ROOT . '/lib/services/search.php');
	
	$result = mcc_search ( $criteria, $page, $per_page, 'people' );
	$docs = $result ['data'];
	
	$users = array ();
	if ($docs !== false) {
		foreach ( $docs as $doc ) {
			$users [] = $Users->load ( $doc->id );
		}
		$users = array_filter ( $users );
	}
	$result ['data'] = $users;
	
	return $result;
}

//======用户隐私设置========
function mcc_get_user_privacy_settings($user_id) {
	global $UserPrivacySettings;
	
	$user = mcc_get_user ( $user_id );
	if (! $user) {
		return false;
	
	} else {
		$user_privacy_settings = $UserPrivacySettings->load ( $user->user_id );
		if (! $user_privacy_settings) {
			return false;
		}
		
		return $user_privacy_settings;
	}
}

function mcc_user_create_privacy_settings($data) {
	
	global $UserPrivacySettings, $auth;
	$user_privacy_settings = $UserPrivacySettings->new_object ( $data );
	
	$user_privacy_settings->user_id = $auth->id;
	$user_privacy_settings->simulated_stock_transactions = $data ['simulated_stock_transactions'];
	$user_privacy_settings->add_friend = $data ['add_friend'];
	$user_privacy_settings->add_optional_share = $data ['add_optional_share'];
	$user_privacy_settings->publish_bowen_topic = $data ['publish_bowen_topic'];
	$user_privacy_settings->add_join_group = $data ['add_join_group'];
	$user_privacy_settings->last_change_time = time ();
	
	$user_privacy_settings->insert ();
	
	return $user_privacy_settings;
}

function mcc_user_privacy_settings_update($user, $user_privacy_settings) {
	global $UserPrivacySettings;
	
	$user_id = is_object ( $user ) ? $user->user_id : $user;
	if (is_object ( $user_privacy_settings )) {
		$privacy = mcc_get_user_privacy_settings ( $user_id );
		if (! $privacy) {
			return false;
		
		} else {
			$privacy->simulated_stock_transactions = $user_privacy_settings->simulated_stock_transactions;
			$privacy->add_friend = $user_privacy_settings->add_friend;
			$privacy->add_optional_share = $user_privacy_settings->add_optional_share;
			$privacy->publish_bowen_topic = $user_privacy_settings->publish_bowen_topic;
			$privacy->add_join_group = $user_privacy_settings->add_join_group;
			$privacy->last_change_time = time ();
			
			$privacy->update ();
			
			return true;
		}
	
	} else {
		return false;
	}

}

function mcc_send_verify_email($user) {
	global $UserTokens;
	
	$token = $UserTokens->new_object ( array ('user_id' => $user->user_id, 'token' => md5 ( uniqid ( mt_rand (), true ) ), 'login_ip' => get_remote_addr ( true ), 'created_at' => time (), 'expire_date' => time () + 3600 * 24 * 30, 'token_type' => 'verify' ) );
	
	$token->insert ();
	
	$t = urlencode ( base64_encode ( "$user->user_id|$token->token|$user->email" ) );
	$url = urls::absolute ( '/i/verify/' ) . "?t=$t";
	$subject = "{$user->username}, 欢迎加入资本魔方";
	
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$content .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$content .= '<head>';
	$content .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$content .= '<meta name="robots" content="all" />';
	$content .= '<meta name="Copyright" content="www.7878.com" />';
	$content .= '<meta name="keywords" content="" />';
	$content .= '<title>资本魔方 - 注册邮箱认证</title>';
	$content .= '</head>';
	$content .= '<body>';
	$content .= '<div style="font-family:Arial, Helvetica, sans-serif; float:left; margin:10px; width:680px; background:#f63;">';
	$content .= '<div style="float:left; margin:10px; padding:0 10px; width:640px; border:1px solid #ddd; background:white;">';
	$content .= '<h2 style="display:block;padding-bottom:20px; border-bottom:1px solid #ccc; font-size:1.5em; font-weight:bold;width:640px; background:url(http://www.7878.com/img/logo.gif) top right no-repeat;margin-bottom:0.83em;margin-left:0;margin-right:0;margin-top:0.83em;">';
	$content .= '资本魔方注册邮箱认证';
	$content .= '</h2>';
	$content .= '<div style="margin:30px 20px;font-size:14px;">';
	$content .= '<h4 style="display:block;font-weight:bold;margin-bottom:1.33em;margin-left:0;margin-right:0;margin-top:1.33em;font-size: 16px;">';
	$content .= $user->username . '，您好!';
	$content .= '</h4>';
	$content .= '<p style="text-indent:2em; line-height:28px;">';
	$content .= '只要点击下面的链接，完成邮箱验证，你就可以使用资本魔方的所有服务啦！';
	$content .= '</p>';
	$content .= '<p style="text-indent:2em; line-height:28px;word-break:break-all;word-wrap:break-word;">';
	$content .= '<a href="' . $url . '"  target="_blank">' . $url . '</a>';
	$content .= '</p>';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '(如点击链接无法进入，请复制到浏览器地址栏中打开)';
	$content .= '</p>';
	$content .= '</div>';
	$content .= '<div style="margin:0 20px 0 20px;">';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '本邮件由系统自动发出，请勿回复。';
	$content .= '</p>';
	$content .= '</div> ';
	$content .= '<div style="padding:10px 0; border-top:1px solid #eee; color:#ccc; font-size:12px;">资本魔方 www.7878.com</div>';
	$content .= '</div>';
	$content .= '</div>';
	$content .= '</body>';
	$content .= '</html>';
	
	_require (DOC_ROOT . '/lib/services/message_queue.php');
	mcc_mq_publish_sendmail_message ( '资本魔方<support@7878.com>', $user->email, $subject, $content );
}

function mcc_reset_verify_email($user) {
	global $UserTokens;
	
	$token = $UserTokens->new_object ( array ('user_id' => $user->user_id, 'token' => md5 ( uniqid ( mt_rand (), true ) ), 'login_ip' => get_remote_addr ( true ), 'created_at' => time (), 'expire_date' => time () + 3600 * 24 * 30, 'token_type' => 'reset_email' ) );
	
	$token->insert ();
	
	$t = urlencode ( base64_encode ( "$user->user_id|$token->token|$user->email" ) );
	$url = urls::absolute ( '/i/verify/' ) . "?t=$t";
	$subject = "资本魔方邮箱验证";
	
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$content .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$content .= '<head>';
	$content .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$content .= '<meta name="robots" content="all" />';
	$content .= '<meta name="Copyright" content="www.7878.com" />';
	$content .= '<meta name="keywords" content="" />';
	$content .= '<title>资本魔方 - 邮箱验证</title>';
	$content .= '</head>';
	$content .= '<body>';
	$content .= '<div style="font-family:Arial, Helvetica, sans-serif; float:left; margin:10px; width:680px; background:#f63;">';
	$content .= '<div style="float:left; margin:10px; padding:0 10px; width:640px; border:1px solid #ddd; background:white;">';
	$content .= '<h2 style="display:block;padding-bottom:20px; border-bottom:1px solid #ccc; font-size:1.5em; font-weight:bold;width:640px; background:url(http://www.7878.com/img/logo.gif) top right no-repeat;margin-bottom:0.83em;margin-left:0;margin-right:0;margin-top:0.83em;">';
	$content .= '资本魔方邮箱验证';
	$content .= '</h2>';
	$content .= '<div style="margin:30px 20px;font-size:14px;">';
	$content .= '<h4 style="display:block;font-weight:bold;margin-bottom:1.33em;margin-left:0;margin-right:0;margin-top:1.33em;font-size: 16px;">';
	$content .= $user->username . '，您好!';
	$content .= '</h4>';
	$content .= '<p style="text-indent:2em; line-height:28px;">';
	$content .= '只要点击下面的链接，完成邮箱验证，你就可以拥有资本魔方的所有服务啦！';
	$content .= '</p>';
	$content .= '<p style="text-indent:2em; line-height:28px;word-break:break-all;word-wrap:break-word;">';
	$content .= '<a href="' . $url . '"  target="_blank">' . $url . '</a>';
	$content .= '</p>';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '(如点击链接无法进入，请复制到浏览器地址栏中打开)';
	$content .= '</p>';
	$content .= '</div>';
	$content .= '<div style="margin:0 20px 0 20px;">';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '本邮件由系统自动发出，请勿回复。';
	$content .= '</p>';
	$content .= '</div> ';
	$content .= '<div style="padding:10px 0; border-top:1px solid #eee; color:#ccc; font-size:12px;">资本魔方 www.7878.com</div>';
	$content .= '</div>';
	$content .= '</div>';
	$content .= '</body>';
	$content .= '</html>';
	
	_require (DOC_ROOT . '/lib/services/message_queue.php');
	mcc_mq_publish_sendmail_message ( '资本魔方 <support@7878.com>', $user->email, $subject, $content );
}

function mcc_send_reset_email($user) {
	global $UserTokens;
	
	$token = $UserTokens->new_object ( array ('user_id' => $user->user_id, 'token' => md5 ( uniqid ( mt_rand (), true ) ), 'ip' => get_remote_addr ( true ), 'created_at' => time (), 'expire_date' => time () + 3600 * 24 * 1, 'token_type' => 'reset' ) );
	
	$token->insert ();
	
	$t = urlencode ( base64_encode ( "$user->email|$token->token" ) );
	$url = urls::absolute ( "/i/reset/$t/" );
	$subject = "资本魔方密码重置";
	
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$content .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$content .= '<head>';
	$content .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$content .= '<meta name="robots" content="all" />';
	$content .= '<meta name="Copyright" content="www.7878.com" />';
	$content .= '<meta name="keywords" content="" />';
	$content .= '<title>资本魔方 - 密码重置</title>';
	$content .= '</head>';
	$content .= '<body>';
	$content .= '<div style="font-family:Arial, Helvetica, sans-serif; float:left; margin:10px; width:680px; background:#f63;">';
	$content .= '<div style="float:left; margin:10px; padding:0 10px; width:640px; border:1px solid #ddd; background:white;">';
	$content .= '<h2 style="display:block;padding-bottom:20px; border-bottom:1px solid #ccc; font-size:1.5em; font-weight:bold;width:640px; background:url(http://www.7878.com/img/logo.gif) top right no-repeat;margin-bottom:0.83em;margin-left:0;margin-right:0;margin-top:0.83em;">';
	$content .= '资本魔方用户密码重置';
	$content .= '</h2>';
	$content .= '<div style="margin:30px 20px;font-size:14px;">';
	$content .= '<h4 style="display:block;font-weight:bold;margin-bottom:1.33em;margin-left:0;margin-right:0;margin-top:1.33em;font-size: 16px;">';
	$content .= $user->username . '，您好!';
	$content .= '</h4>';
	$content .= '<p style="text-indent:2em; line-height:28px;">';
	$content .= '请点击以下链接修改您的密码(以下地址一天后失效，请尽快修改)';
	$content .= '</p>';
	$content .= '<p style="text-indent:2em; line-height:28px;word-break:break-all;word-wrap:break-word;">';
	$content .= '<a href="' . $url . '"  target="_blank">' . $url . '</a>';
	$content .= '</p>';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '(如点击链接无法进入，请复制到浏览器地址栏中打开)';
	$content .= '</p>';
	$content .= '</div>';
	$content .= '<div style="margin:0 20px 0 20px;">';
	$content .= '<p style="text-indent:2.5em; line-height:15px; font-size:12px; color:#999999;">';
	$content .= '本邮件由系统自动发出，请勿回复。';
	$content .= '</p>';
	$content .= '</div> ';
	$content .= '<div style="padding:10px 0; border-top:1px solid #eee; color:#ccc; font-size:12px;">资本魔方 www.7878.com</div>';
	$content .= '</div>';
	$content .= '</div>';
	$content .= '</body>';
	$content .= '</html>';
	_require (DOC_ROOT . '/lib/services/message_queue.php');
	mcc_mq_publish_sendmail_message ( '资本魔方<support@7878.com>', $user->email, $subject, $content );
}

function mcc_send_reset_phone($user){
	_require (DOC_ROOT . '/lib/services/mobile_verification.php');		

	$mobile = $user->phone_number;
	//避免用户恶意进行手机验证
	$has_code = mcc_get_mobile_verification ( $user );
	
	if (is_object($has_code) && $has_code->type == MOBILEVERIFICATION_TYPE_VERIFY) {
	    $has_code->delete();
	} else if (is_object($has_code) && $has_code->type == MOBILEVERIFICATION_TYPE_RESET){
		if(date("Ymd", time()) != date("Ymd", $has_code->last_update)) {
            $has_code->delete();
        }
	}
	
	if (is_object($has_code) && $has_code->type == MOBILEVERIFICATION_TYPE_RESET) {
		$status = $has_code->status;
		$last_update = $has_code->last_update;
		$now = time ();
		$time_diff = $now - $last_update;
		if ($time_diff >= 0) {
			$delay_time = STAY_INTERVAL;
			if ($status % 3 == 0) {
				$delay_time = PUNISHMENT_BASE_INTERVAL;
			}
			$last_update = $last_update + $delay_time;
			
			//生成随机码
			$key = _get_mobile_code ( 4 );
			$has_code->last_update = $last_update;
			$has_code->key = $key;
			$has_code->phone_number = $mobile;
			$has_code->type = MOBILEVERIFICATION_TYPE_RESET;
			$has_code->update ();
			
			//发送短信请求
			_require (DOC_ROOT . '/lib/services/message_tpl.php');
			_require (DOC_ROOT . '/lib/services/message_queue.php');
			$condition = array ('data' => array ($mobile), 'users' => array (), 'msg' => mcc_tpl_user_reset_verify($user->nickname, $key));
			
			mcc_mq_publish_sendmsgs_message ( 'phone', $condition );
			
			return true;
		}
		
		return false;
	} else {
		
		//生成随机码
		$key = mcc_create_mobile_verification ( $user, $mobile, MOBILEVERIFICATION_TYPE_RESET );
		
		//发送短信请求
		_require (DOC_ROOT . '/lib/services/message_tpl.php');
		_require (DOC_ROOT . '/lib/services/message_queue.php');
		$condition = array ('data' => array ($mobile), 'users' => array (), 'msg' => mcc_tpl_user_reset_verify($user->nickname, $key));
		
		mcc_mq_publish_sendmsgs_message ( 'phone', $condition );
		
		return true;
	}
    
}

function mcc_user_stat_sort($user1, $user2) {
	if ($user1->stat !== false && $user2->stat !== false) {
		$what1 = $user1->stat->what;
		$what2 = $user2->stat->what;
		
		if ($user1->stat->{$what1} == $user2->stat->{$what2})
			return 0;
		return ($user1->stat->{$what1} > $user2->stat->{$what2}) ? - 1 : 1;
	}
}

/************UserStatus****************/

if (!defined('TASK_ALL_FINISHED')) {
//任务类型
define ( 'TASK_ALL_FINISHED', 't_000' ); //全部完成几个
define ( 'TASK_UPLOAD_BUDDYICON', 't_001' ); //上传头像
define ( 'TASK_EMAIL_CERTIFICATE', 't_002' ); //验证邮箱
define ( 'TASK_BIND_MOBILE', 't_003' ); //绑定手机
define ( 'TASK_INVITE_FRIEND', 't_004' ); //邀请好友
define ( 'TASK_STOCK_ACTION', 't_005' ); //模拟炒股
define ( 'TASK_CREATE_STOCK_LEGEND', 't_006' ); //发牛股传说
define ( 'TASK_INVESTMENT_TEST', 't_007' ); //自测投资风格
define ( 'TASK_BIND_WEIBO', 't_008' ); //绑定微博

//任务奖励积分
define ( 'AWARD_TASK_UPLOAD_BUDDYICON', '10' ); //上传头像
define ( 'AWARD_TASK_EMAIL_CERTIFICATE', '20' ); //验证邮箱
define ( 'AWARD_TASK_BIND_MOBILE', '20' ); //绑定手机
define ( 'AWARD_TASK_INVITE_FRIEND', '10' ); //邀请好友
define ( 'AWARD_TASK_INVESTMENT_TEST', '20' ); //自测投资风格
define ( 'AWARD_TASK_BIND_WEIBO', '50' ); //绑定微博
}
function mcc_load_user_status($user = false, $key) {
	global $UserStatus, $auth;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	$user_status = $UserStatus->load ( array ($user_id, $key ) );
	
	return $user_status;
}

function mcc_get_count_user_status ($user, $criteria = false) {
    global $UserStatus;

    $user_id = is_object($user) ? $user->user_id : $user;
    $query = array(
        'user_id'	=>	$user_id
    );
    if ($criteria != false) {
        $query = array_merge($query, $criteria);
    }

    return $UserStatus->count($query);

}

function mcc_create_user_status($user = false, $key, $status = 1) {
	global $UserStatus, $auth;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	$user_status = $UserStatus->new_object ( array ('user_id' => $user_id, 'key' => $key, 'status' => $status, 'last_update' => time () ) );
	$user_status->insert ();
	
	return $user_status;
}

function mcc_increase_user_total_tasks($user = false) {
	global $UserStatus, $auth;
	
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	$user_status = mcc_load_user_status ( $user_id, TASK_ALL_FINISHED );
	if ($user_status !== false) {
		$user_status->status = $user_status->status + 1;
		
		$tasks = BaseUtils::$TASK_ARRAY;
		$count_tasks = count ( $tasks );
		if ($user_status->status > $count_tasks) {
			$user_status->status = $count_tasks;
		}
		$user_status->update ();
	} else {
		mcc_create_user_status ( $user_id, TASK_ALL_FINISHED );
	}
	
	return $user_status;
}

function mcc_has_finished_all_tasks($user = false) {
	global $UserStatus, $auth;
	if ($auth->id == 0) return false;
	$user_id = $user == false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	$user_status = mcc_load_user_status ( $user_id, TASK_ALL_FINISHED );
	if ($user_status !== false) {
		$tasks = BaseUtils::$TASK_ARRAY;
		$count_tasks = count ( $tasks );
		
		$hascount = mcc_get_count_user_status($user_id);
		$hascount = $hascount - 1;
		if ($user_status->status != $hascount) {
			$user_status->status = $hascount;
			$user_status->update ();
		}
	
		if ($count_tasks <= $hascount) {
			return true;
		}
		
	} else {
		mcc_create_user_status($user_id, TASK_ALL_FINISHED, 0);
	}
	
	return false;
}

function mcc_update_user($user_id, $data) {
	global $Users;
	$user = mcc_get_user ( $user_id );
	if (is_array ( $data )) {
		foreach ( $data as $key => $value ) {
			$user->{$key} = $value;
		}
		$user->update ();
	}
	return $user;
}

function mcc_update_mcc_update_user_profile($data, $user_profile = false) {
    
    if ($user_profile  === false){
	    $user_profile = mcc_get_user_profile ();
    }
	if (is_array ( $data )) {
		foreach ( $data as $key => $value ) {
			$user_profile->{$key} = $value;
		}
		$user_profile->update ();
	}
	return $user_profile;
}

/**
 * 得到vip折扣后的价格
 * 
 * cyw
 * Jul 10, 2012 9:42:32 AM    
 * @throws Exception
 */
function mcc_get_vip_discount_price($mpay, $user = false, $profile = false){
    global $auth;
    
	//VIP Discount
    $auth->require_login();
    if ($user === false) {
        $user = $auth->user;
    }
    if ($profile === false) {
    	$profile = mcc_get_user_profile($user->user_id);
    }
    $is_vip_card = mcc_get_user_is_vip($user);
    if( $is_vip_card ){
    	return number_format($mpay * $profile->vip_discount, 2, '.', '');
    }
	return $mpay;
}

/**
 * 
 * 判断用户是否为有效VIP
 * @param unknown_type $user
 */
function mcc_get_user_is_vip( $user = false ){
	global $auth;
	if( $user === false ){
		if( !($auth->is_logged_in()) ){
			return false;
		}
		$user = $auth->user;
	}
	if( !is_object($user) ){
		$user = mcc_get_user($user);
	}
	//VIP判断
	$profile = mcc_get_user_profile($user->user_id);
	$vipfalg = UserRolesUtils::is_vip_card($user->roles);
	if ($vipfalg && $profile->vip_end_at > time()) {
	    return true;
	}
	//体验卡判断
	_require (DOC_ROOT . '/lib/services/card.php');
	$iseptime = mcc_has_card_ep($user);
    if ($iseptime > 0 ) {
    	return true;
    }
    return false;
}

/**
 * 注册 - 默认关注 - 圈子&&名人  加入比赛
 * 
 * cyw
 * Jun 28, 2012 3:51:03 PM
 */
function mcc_regisert_follow_group_and_people ($user, $autoaddgroup = false){
    
    if (!is_object($user)){
        return ;
    }
    
    $reg_user_id = $user->user_id;
    
    
	_require (DOC_ROOT . '/lib/services/user_follower.php');
    
    //关注 高手 && 圈子
	$tomaster_ids = array(
	    33929,//黄一龙
        15143,//愚人光哥
        17153,//ts披着牛皮的熊
        10773,//路西法
        10403,//陶一读盘
        235045,//从股论金
        14017,//茫茫大士
        16861,//心魔
        15109,//铁牛
        173147,//昵称：无股
        50879,//昵称：warum
        110503,//昵称：h2306299
        183703,//昵称：冰雪6826
        154089,//昵称：荆德林
        221705,//昵称：诸葛圣手
        
	);
	
	//圈子
	$tomaster_groups = GroupUtils::$REGISTERWITHGROUPS;
	
	shuffle($tomaster_groups);
	$tomaster_groups = array_slice($tomaster_groups, 0,3);
	
	$match_ids = array(
	    267,//参加“资本魔方模拟炒股练习场”合作赛
	);
	
	
	if (is_array($tomaster_ids) && count($tomaster_ids) > 0 ){
	    foreach ($tomaster_ids as $user_id) {
    	    $tobe_follow_user = mcc_get_user($user_id);
            if($tobe_follow_user == false) {
                continue ;
            }
        	if($tobe_follow_user->user_id == $reg_user_id) {
    	        continue ;
        	}
            //判断我是否已经关注过他
            $has_followed = mcc_has_followed($user, $tobe_follow_user);
            if($has_followed) {
               continue ;
            }
            mcc_create_user_follow($user, $tobe_follow_user);
            
        	//记录关注的用户
    		_require (DOC_ROOT . '/lib/services/redis.php');
    		$redis = get_system_redis ( REDIS_SYSTEM_KEY_USER );
    		$key = REDIS_SYSTEM_KEY_USER . ":" . $reg_user_id . ':last_to_follow'; 
    		$redis->zrem($key, $tobe_follow_user->user_id);
    		$redis->zadd($key, time(), $tobe_follow_user->user_id);
	    }
	}
	
    _require (DOC_ROOT . '/lib/services/group.php');
    _require (DOC_ROOT . '/lib/services/group_member.php');
    _require (DOC_ROOT . '/lib/services/group_invite.php');
    
	if (!$autoaddgroup && is_array($tomaster_groups) && count($tomaster_groups) > 0 ){
        foreach ($tomaster_groups as $group_id) {
            
        	$to_follow_group = mcc_get_group ( $group_id );
        	
            if($to_follow_group == false) {
                    continue ;
            }
            
            //判断当前用户所是否被加入黑名单
            $is_group_user = mcc_get_group_user($group_id, $reg_user_id);
            if(is_object($is_group_user) && $is_group_user->roles == GROUP_ROLE_BLACK){  
                continue;  
            }
        	$append_roles = array (array ('roles' => GROUP_ROLE_ADMIN ), 'or', array ('roles' => GROUP_ROLE_MEMBER ) );
        	$count_group_append = mcc_count_user_group ( $reg_user_id, array ('roles' => $append_roles, 'group_type' => GROUP_TYPE_NORMAL, 'group_status' => GROUP_STATUS_NORMAL ) );
        			
        	if ($count_group_append > GROUP_MAX_JOIN) {
        		continue ;
        	}
        	
            mcc_join_group ( $to_follow_group, $reg_user_id );
        	mcc_remove_group_invite ( $to_follow_group->group_id, $reg_user_id );
	    }
	}
	
	//--
	
	//match
	_require (DOC_ROOT . '/lib/services/match.php');
	_require (DOC_ROOT . '/lib/services/match_player.php');
	if (is_array($match_ids) && count($match_ids) > 0 ){
        foreach ($match_ids as $match_id) {
            
                $match = mcc_get_match($match_id, false);
                
                if (is_object($match)){
                
    				$data = array (	'user_id' 	=> $reg_user_id, 
    								'match_id' 	=> $match_id, 
    								'mobile' 	=> '', 
    								'email' 	=> '', 
    								'truename' 	=> $user->nickname,
    								'user_roles'=> $user->roles,
    								'role'		=> MATCH_PLAYER_ROLE_NORMAL
    				);
    				mcc_create_match_player ( $data );
    				if( $match->object_type == MATCH_OBJECT_TYPE_NORMAL )
    				{
    					mcc_delete_match_player_verfy ( $reg_user_id, $match->match_id );
    					mcc_create_match_player_account ( $match->match_id, $reg_user_id, $match->init_money );
    				}
    				$m_group = mcc_get_group($match->group_id);
    				if($m_group != false) {
    					mcc_join_group($m_group, $reg_user_id);
    				}
                }
            
        }
    }
    
}

?>
