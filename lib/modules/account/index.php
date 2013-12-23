<?php
_require (DOC_ROOT . '/lib/services/users.php');

function about(){
	global $auth, $tpl;

	//pagecache_start(100);

	$tpl->render('account/about.tpl.php', array(
            'title'     			=>	'关于',
	        'form'                  => false,
            'site_current_nav'      => __FUNCTION__
    ), 'layout.tpl.php');

    //pagecache_end();
}

function account_join(){
	global $auth, $tpl;

	if ($auth->is_logged_in ()){
	    redirect(urls::absolute('/'));
	}

	$form = new SignupForm( $_POST );

	if ($_SERVER ['REQUEST_METHOD'] == 'POST' && $form->is_valid()) {

	    //连续注册
		$signups = isset($_COOKIE["signups"]) ? $_COOKIE["signups"] : 0;

		if($signups > 0 && !config_get('devmode')) {
			$form = new SignTimeForm ( $_POST );
		}

		$_SESSION ['authcode'] = '';

		// form validation
		if (check_formhash () && $form->is_valid ()) {

			// 清理表单数据
			$data = $form->get_cleaned_data ();

			$user = false;

			// 注册用户，暂不初始化用户数据
			$user = mcc_signup_user ( $data );

			setcookie("signups", $signups+1, time()+60*60*12);

			if ($user != false) {
				$auth->impersonate ( $user->user_id );
				return redirect('/');
			}
		}
	}


	$tpl->render('account/join.tpl.php', array(
            'title'     			=>	'注册帐号',
	        'form'                  => $form
    ), 'layout.tpl.php');
}

function account_login(){
	global $auth, $msg, $tpl, $Users;

	// Kick out user if already logged in.
	if ($auth->is_logged_in ()){
	    redirect(urls::absolute('/'));
	}

	$uri = $_SERVER ['REQUEST_URI'];
	$url = urls::absolute('/');

	// Try to log in...
	if (! empty ( $_POST ['username'] )) {
		$login_type = trim(param_string ( $_POST, 'login_type' ));
		$_SESSION ['login_type'] = $login_type;

		$username = trim(param_string ( $_POST, 'username' ));
		$password = param_value ( $_POST, 'password' );
		$remember_me = param_int ( $_POST, 'remember_me' );
		$msg_name = $username;

		//手机登录
		$username_passed = false;
		if($login_type == '1') {
    		if(is_phone_number ( $username )){
    		    //phone number login
    			$user = $Users->fetch_one ( array ('phone_number' => $username ) );
    			if ($user !== false) {
    				$username = $user->username;
    				$username_passed = true;
    			}
    		}
		} else {
		    //用户名或邮箱登录
    		$user = false;
			if (preg_match ( '/^([_a-z0-9+-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $username )) {
				// email login
				$user = $Users->fetch_one(array('email' => $username));
			}
			if (!$user) {
				$user = $Users->fetch_one(array('username' => $username));
			}
		    if ($user !== false) {
    			$username = $user->username;
    			$username_passed = true;
    		}
		}

		try {
		    if($username_passed) {

    		    //发微信监控
    		    _require (DOC_ROOT . '/lib/services/openapi/weixin.php');
    		    $weixin = new WeiXin();
    		    $weixin->send_weixin($username . '登录了。');

			    $auth->login ( $username, $password, $remember_me );

		    }
		} catch ( Exception $e ) {}

		if ($auth->is_logged_in ()) {
			redirect($url);
		} else {
		    $error_msg = '对不起，用户名或密码不正确，请重试';
		    $error_msg = $login_type == '1' ? '对不起，手机号或密码不正确，请重试' : $error_msg;
		    $msg->add_error ( $error_msg );
			$msg->add_message($msg_name);

			$redirect_url = $_SERVER ['REQUEST_URI'];
			redirect($redirect_url);
		}
	}

	$username = isset ( $_POST ['username'] ) ? $_POST ['username'] : '';
	$username = htmlspecialchars ( $username );

	$login_type = isset ( $_SESSION ['login_type'] ) ? $_SESSION ['login_type'] : '0';
	unset($_SESSION['login_type']);

	$tpl->render('account/login.tpl.php', array(
            'title'     			=>	'登录',
    ), 'layout.tpl.php');
}

/**
 * 弹框登录
 *
 * cyw
 * 2013-3-14 下午03:48:22
 */
function account_mlogin(){
	global $auth, $msg, $tpl, $Users;

	if ($auth->is_logged_in ()){
	    redirect(urls::absolute('/'));
	}

	$uri = $_SERVER ['REQUEST_URI'];
	$url = urls::absolute('/');

	if (! empty ( $_POST ['username'] )) {

		$login_type = trim(param_string ( $_POST, 'login_type' ));
		$_SESSION ['login_type'] = $login_type;

		$username = trim(param_string ( $_POST, 'username' ));
		$password = param_value ( $_POST, 'password' );
		$remember_me = param_int ( $_POST, 'remember_me' );
		$msg_name = $username;

		$url = isset($_POST['from']) && !empty($_POST['from']) ? urldecode(urldecode(param_string ( $_POST, 'from' ))) : $url;

		//手机登录
		$username_passed = false;
		if($login_type == '1') {
    		if(is_phone_number ( $username )){
    		    //phone number login
    			$user = $Users->fetch_one ( array ('phone_number' => $username ) );
    			if ($user !== false) {
    				$username = $user->username;
    				$username_passed = true;
    			}
    		}
		} else {
		    //用户名或邮箱登录
    		$user = false;
			if (preg_match ( '/^([_a-z0-9+-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $username )) {
				// email login
				$user = $Users->fetch_one(array('email' => $username));
			}
			if (!$user) {
				$user = $Users->fetch_one(array('username' => $username));
			}
		    if ($user !== false) {
    			$username = $user->username;
    			$username_passed = true;
    		}
		}

		try {
		    if($username_passed) {
			    $auth->login ( $username, $password, $remember_me );
		    }
		} catch ( Exception $e ) {
			// 中文用户名时，数据库会出错
			die ( 'oops' );
		}

		if ($auth->is_logged_in ()) {
			redirect($url);
		} else {
		    $error_msg = '对不起，用户名或密码不正确，请重试';
		    $error_msg = $login_type == '1' ? '对不起，手机号或密码不正确，请重试' : $error_msg;
		    $msg->add_error ( $error_msg );
			$msg->add_message($msg_name);

			//$redirect_url = $_SERVER ['REQUEST_URI'];
			redirect('/login/');
		}
	}

	$username = isset ( $_POST ['username'] ) ? $_POST ['username'] : '';
	$username = htmlspecialchars ( $username );

	$login_type = isset ( $_SESSION ['login_type'] ) ? $_SESSION ['login_type'] : '0';
	unset($_SESSION['login_type']);

	$tpl->render('account/mlogin.tpl.php', array(
            'title'     			=>	'登录',
    ), false);
}

function account_logout(){
	global $auth, $tpl, $msg;
	$auth->logout ();
	redirect(urls::absolute('/'));
	//redirect ( WEB_ROOT . '/' );
}



class SignupForm extends Form {
	function clean_username($key, $value) {
		$value = clean_string ( trim ( $value ) );
		$this->validate_blank ( $value, $key, '用户名' );
		if(get_string_length($value) < 4 || get_string_length($value) > 16){
			$this->add_error ( $key, "用户名长度应在4到16个字符之间" );
		}
		if( strpos(strtolower($value), "qq") !== false || strpos(strtolower($value), "ｑｑ") !== false )
		{
			$str = str_replace(array("ｑｑ", "ＱＱ"), "qq", strtolower($value));
			$str = str_replace(array(":", "："), "", $str);
			$pos = strpos($str, "qq");
			$str1 = substr($str, $pos + 2, 5);
			$str2 = substr($str, 0, $pos);
			if( (strlen($str1) == strlen((int)$str1) && strlen($str1) >= 5) || (strlen($str2) == strlen((int)$str2) && strlen($str2) >= 5) )
			{
				$this->add_error ( $key, "用户名 {$value} 已经存在" );
			}
		}
		// 检查用户名是否已经存在
		if (! $this->has_error ( $key )) {
			$this->validate_regex ( $value, '/[\x80-\xff_a-zA-Z0-9\-]/', $key, '用户名中不能含有特殊字符和空格' );
			_require (DOC_ROOT . '/lib/services/blacklist.php');
			$chk_value = Blacklist::get_purewords ( $value );

			if (Blacklist::has_blackword ( $value ) || Blacklist::has_reserved_word ( $value ) || strlength($value) != strlength($chk_value)) {
				$this->add_error ( $key, "用户名 {$value} 已经存在" );
			}
			if (! $this->has_error ( $key )) {
				global $Users;
				if ($Users->fetch_one ( array ('username' => $value ) )) {
					$this->add_error ( $key, "用户名 {$value} 已经存在" );
				}
			}
		}
	}

	function clean_nickname($key, $value) {
		$value = clean_string ( trim ( $value ) );
		$this->validate_blank ( $value, $key, '昵称' );
		if(get_string_length($value) < 4 || get_string_length($value) > 16){
			$this->add_error ( $key, "用户昵称长度应在4到16个字符之间" );
		}

		if( strpos(strtolower($value), "qq") !== false || strpos(strtolower($value), "ｑｑ") !== false )
		{
			$str = str_replace(array("ｑｑ", "ＱＱ"), "qq", strtolower($value));
			$str = str_replace(array(":", "："), "", $str);
			$pos = strpos($str, "qq");
			$str1 = substr($str, $pos + 2, 5);
			$str2 = substr($str, 0, $pos);
			if( (strlen($str1) == strlen((int)$str1) && strlen($str1) >= 5) || (strlen($str2) == strlen((int)$str2) && strlen($str2) >= 5) )
			{
				$this->add_error ( $key, "昵称 {$value} 已经存在" );
			}
		}
		// 过滤敏感字
		_require (DOC_ROOT . '/lib/services/blacklist.php');
		$chk_value = Blacklist::get_purewords ( $value );
		if (Blacklist::has_blackword ( $value ) || Blacklist::has_reserved_word ( $value ) || strlength($value) != strlength($chk_value)) {
			$this->add_error ( $key, "昵称不能包含敏感字." );
			$this->cleaned [$key] = $value;
			return false;
		}
		if (Blacklist::has_reserved_word ( $value )) {
			$this->add_error ( $key, "昵称 {$value} 已经存在." );
			$this->cleaned [$key] = $value;
			return false;
		}
		// 检查用户名是否已经存在
		if (! $this->has_error ( $key )) {
			$this->validate_regex ( $value, '/[\x80-\xff_a-zA-Z0-9\-]/', $key, '用户昵称中不能含有特殊字符和空格' );
			if (! $this->has_error ( $key )) {
				global $Users;
				if ($Users->fetch_one ( array ('nickname' => $value ) )) {
					$this->add_error ( $key, "昵称 {$value} 已经存在" );
				}
			}
		}
	}

	function clean_password($key, $value) {
		$this->validate_blank ( $value, $key, '密码' );
		if (! $this->has_error ( $key )) {
			$this->validate_length ( $value, $key, 6, 32, '密码' );
		}
	}

	function clean_password2($key, $value) {
		$this->validate_blank ( $value, $key, '确认密码' );
		if (! $this->has_error ( $key ))
			$this->validate_passwords ( 'password', $this->password, $value );
	}
}

class SignTimeForm extends Form {
	function clean_password2($key, $value) {
		$this->add_error ( $key, "请不要连续注册,IP已锁定。" );
	}
}