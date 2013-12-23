<?php
define ( "COOKIEJAR", tempnam ( ini_get ( "upload_tmp_dir" ), "cookie" ) );
//定义COOKIES存放的路径,要有操作的权限
define ( "TIMEOUT", 1000 );
//超时设定
class YAHOO {
	private function login($username, $password) {
		//第一步：模拟抓取登录页面的数据,并记下cookies
		$cookies = array ();
		$matches = array ();
		//获取表单
		$login_url = "https:
            //login.yahoo.com/config/login?.src=fpctx&.intl=us&.done=http%3A%2F%2Fwww.yahoo.com%2F";
		$ch = curl_init ( $login_url );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$contents = curl_exec ( $ch );
		curl_close ( $ch );
		//构造参数
		$name = array ('tries', 'src', 'md5', 'hash', 'js', 'last', 'promo', 'intl', 'bypass', 'partner', 'u', 'v', 'challenge', 'yplus', 'emailCode', 'pkg', 'stepid', 'ev', 'hasMsgr', 'chkP', 'done', 'pd', 'p
            ad', 'aad' );
		$postfiles = array ();
		$matches = array ();
		foreach ( $name as $v ) {
			preg_match ( '/<input\s*type="hidden"\s*name=".' . $v . '"\s*value="(.*?)"\s*>/i', $contents, $matches );
			if (! empty ( $matches )) {
				$postfiles ['.' . $v] = $matches [1];
				$matches = array ();
			}
			if ($v == 'pd') {
				$postfiles ['.' . $v] = urlencode ( @$postfiles ['.' . $v] );
			}
		
		}
		$postfiles ['pad'] = 5;
		$postfiles ['aad'] = 6;
		$postfiles ['login'] = urlencode ( $username );
		$postfiles ['passwd'] = $password;
		$postfiles ['.persistent'] = 'y';
		$postfiles ['save'] = '';
		$postfiles ['.done'] = urlencode ( @$postfiles ['.done'] );
		//$postfiles['.pd'] = urlencode($postfiles['.pd']);
		$postargs = '';
		foreach ( $postfiles as $k => $v ) {
			$postargs .= $k . '=' . $v . '&';
		}
		$postargs = substr ( $postargs, 0, - 1 );
		$request = "https://login.yahoo.com/config/login?";
		//开始登录
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $request );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postargs );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, TIMEOUT );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$contents = curl_exec ( $ch );
		curl_close ( $ch );
		if (stripos ( $contents, 'submit' ) != FALSE) {
			return 0;
		}
		return 1;
	
	}
	//获取邮箱通讯录-地址
	public function getAddressList($username, $password) {
		if (! $this->login ( $username, $password )) {
			return 0;
		}
		//开始进入模拟抓取
		//get mail list from the page information username && emailaddress
		$url = "http://address.mail.yahoo.com/";
		$data = array ();
		if (! $data = $this->hanlde_date ( $url, $names, $emails )) {
			return FALSE;
		}
		return $data;
	}
	function hanlde_date($url, &$names, &$emails) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, COOKIEJAR );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, TIMEOUT );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$contents = curl_exec ( $ch );
		curl_close ( $ch );
		$temparr = array ();
		preg_match_all ( '/InitialContacts\s*=\s*(.*?);/i', $contents, $temparr );
		preg_match_all ( '/"email":"(.*?)"/i', $temparr [1] [0], $temparr1 );
		//print_R($temparr1);exit;
		return $temparr1 [1];
	
		//匹配出JSON对象数组
	}

}
?>