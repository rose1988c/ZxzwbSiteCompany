<?php
_require(DOC_ROOT . '/lib/services/users.php');

function dispatcher_action_prefix() {
	return 'manage_';
}

function manage_login() {

	global $auth, $msg, $tpl;
	
	if (!empty($_POST['username'])) {
	    
		$username    = param_string($_POST, 'username');
		$password    = param_value($_POST, 'password');
		$remember_me = param_int($_POST, 'remember_me');

		try {
			$auth->login($username, $password, $remember_me);
		} catch (Exception $e) {
			// 中文用户名时，数据库会出错
			throw $e->getMessage();
		}
		
		if ($auth->is_manage()) {
			$usermng = mcc_get_user_by_username($_POST['username']);
			$url = urls::manage();
			 
			if (isset($_SESSION['redirect_to'])) {
				$url = $_SESSION['redirect_to'];
				unset($_SESSION['redirect_to']);
			} else if (isset($_REQUEST['from'])) {
				$url = $_REQUEST['from'];
			}

			if (strpos($url, '/manage/logout/') !== false) {
				redirect(urls::manage_user(false, '/users/'));
			}
			
			redirect($url);
		} else {
			$msg->add_error('对不起，用户名或密码不正确，请重试');
		}
		
	} else {
		$msg->add_error('对不起，用户名或密码不正确，请重试');
	}
	
	
	$tpl->render('manage/login.tpl.php', array(
			'title' 		  => '后台管理 | 登录',
			'notopinc' => true
	), false);
}


function manage_logout() {
	global $auth, $tpl, $msg;
	$auth->logout();

	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
		$params['path'], $params['domain'],
		$params['secure'], $params['httponly']
		);
	}


	// Finally, destroy the session.
	@session_destroy();
	$msg->add_msg('您已成功退出! ');

	if (isset($_REQUEST['from'])) {
		redirect(urldecode($_REQUEST['from']));
	}

	$tpl->render('manage/login.tpl.php', null, false);
}


function manage_changepass() {

	global $auth, $tpl, $msg;

	$auth->require_manage();

	$form = new ChangePasswordForm($_POST);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (check_formhash() && $form->is_valid()) {
			$auth->change_password($form->passwordnew);
			$msg->add_msg('成功修改密码');
		}
	}

	$tpl->render('manage/changepass.tpl.php', array(
        'title'   => '修改密码',
        'form'    => $form
	), 'manage/layout.tpl.php');

}

class ChangePasswordForm extends Form {
	function clean_password($key, $value) {
		$this->validate_blank($value, $key, '原密码');
		if (!$this->has_error($key)) {
			global $auth;
			$user = $auth->user;
			if ($user->password !== Auth::create_hashed_password($value)) {
				$this->add_error($key, "原密码不正确");
			}
		}
	}

	function clean_passwordnew($key, $value) {
		$this->validate_length($value, $key, 6, 32, '密码');
	}

	function clean_passwordcomfig($key, $value) {
		$this->validate_blank($value, $key, '确认密码');
		if (!$this->has_error($key))
		$this->validate_passwords('passwordcomfig', $this->passwordnew, $value);
	}
}/*}}}*/

?>
