<?php
function ajax_user_exists() {
	global $Users, $auth;
	if (isset($_REQUEST['username'])) {
		$username = param_string($_REQUEST, 'username');
		_require (DOC_ROOT . '/lib/services/blacklist.php');
		$chk_uname = Blacklist::get_purewords ( $username );
		if (Blacklist::has_blackword ( $username ) || Blacklist::has_reserved_word ( $username ) || strlength($username) != strlength($chk_uname)) {
			echo json_encode(array('result' => "false"));
			return;
		}
		if ($Users->fetch_one ( array ('username' => $username, 'user_id__ne' => $auth->id ) ) === false) {
				echo json_encode(array('result' => "true"));
				return;
		}
	}
	if (isset ($_REQUEST['email'])) {
		$email = param_string($_REQUEST, 'email');
		$mail_user = $Users->fetch_one( array ('email' => $email, 'user_id__ne' => $auth->id ));
		if (!$mail_user) {
			echo json_encode(array('result' => "true"));
			return;
		}
	}
	if (isset($_REQUEST['nickname'])) {
		$nickname = trim(param_string($_REQUEST, 'nickname'));
		_require (DOC_ROOT . '/lib/services/blacklist.php');
		$chk_nickname = Blacklist::get_purewords($nickname);
		if (Blacklist::has_blackword ( $nickname ) || Blacklist::has_reserved_word ( $nickname ) || strlength($nickname) != strlength($chk_nickname)) {
			echo json_encode(array('result' => "false"));
			return;
		}
		if ($Users->fetch_one ( array ('nickname' => $nickname, 'user_id__ne' => $auth->id ) ) === false) {
				echo json_encode(array('result' => "true"));
				return;
		}
	}
	echo json_encode(array('result' => "false"));
	return;
}

function ajax_nickname_exists() {
	global $Users, $auth;
	if ($_SERVER ['REQUEST_METHOD'] == 'POST' && check_formhash ()) {
		if (isset ( $_POST ['nickname'] )) {
			$nickname = trim(param_string ( $_POST, 'nickname' ));
			$exist_nickname = $Users->fetch_one ( array ('nickname' => $nickname, 'user_id__ne' => $auth->id) );
			if (!$exist_nickname) {
                    echo json_encode ( "true" );
    				return;
			}
		}
	}
	echo json_encode ( "false" );
	return;
}