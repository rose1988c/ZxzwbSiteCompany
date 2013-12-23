<?php
/**
 * 
 * 模拟126邮箱登录进行身份验证，并获取联系人列表
 * @author sunwq
 *
 */
class http126 {
	public $username;
	public $password;
	
	private $cookie;
	private $auth = false;
	private $debug = false;
	
	/**
	 * 
	 * 初始化，设置cookie保存路径
	 */
	public function __construct() {
		$this->cookie = tempnam ( '.', '~' );
	}
	
	/**
	 * 
	 * 身份验证
	 * @param string $username
	 * @param string $password
	 */
	public function login($username, $password) {
		$this->username = $username;
		$this->password = $password;
		
		//第一步：初步登陆
		$url = "https://reg.163.com/logins.jsp?type=1&product=mail126&url=http://entry.mail.126.com/cgi/ntesdoor?hid%3D10010102%26lightweight%3D1%26verifycookie%3D1%26language%3D0%26style%3D-1";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, "username=" . $this->username . "@126.com&password=" . $this->password );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, $this->cookie );
		curl_setopt ( $ch, CURLOPT_HEADER, 1 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 120 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$content = curl_exec ( $ch );
		curl_close ( $ch );
		$this->_debug ( $content );
		
		//获取redirect_url跳转地址，通过正则在$str返回流中匹配该地址 
		preg_match ( "/replace\(\"(.*?)\"\)\;/", $content, $mtitle );
		$_url = isset ( $mtitle [1] ) ? $mtitle [1] : '';
		$this->_debug ( $_url );
		
		//第二步：再次跳转到到上面$_url 
		$ch = curl_init ( $_url );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 120 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, $this->cookie );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, $this->cookie );
		curl_setopt ( $ch, CURLOPT_HEADER, 1 );
		$content = curl_exec ( $ch );
		curl_close ( $ch );
		$this->_debug ( $content );
		
		if (strpos ( $content, "登录成功" ) === false) {
			return false;
		}
		$this->auth = true;
		return true;
	}
	/** 
	 * 获取邮箱通讯录-地址 
	 * @param $user 
	 * @param $password 
	 * @param $result 
	 * @return array 
	 */
	public function getAddressList() {
		if (! $this->auth) {
			return false;
		}
		$header = $this->_getheader ( $this->username );
		if (! $header ['sid']) {
			return false;
		}
		
		//开始进入模拟抓取 
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "http://" . $header ['host'] . "/a/s?sid=" . $header ['sid'] . "&func=global:sequential" );
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, $this->cookie );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ("Content-Type: application/xml" ) );
		$str = "<?xml version=\"1.0\"?><object><array name=\"items\"><object><string name=\"func\">pab:searchContacts</string><object name=\"var\"><array name=\"order\"><object><string name=\"field\">FN</string><boolean name=\"ignoreCase\">true</boolean></object></array></object></object><object><string name=\"func\">user:getSignatures</string></object><object><string name=\"func\">pab:getAllGroups</string></object></array></object>";
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $str );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, TIMEOUT );
		ob_start ();
		curl_exec ( $ch );
		$contents = ob_get_contents ();
		ob_end_clean ();
		curl_close ( $ch );
		//get mail list from the page information username && emailaddress 
		preg_match_all ( "/<string\s*name=\"EMAIL;PREF\">(.*)<\/string>/Umsi", $contents, $mails );
		preg_match_all ( "/<string\s*name=\"FN\">(.*)<\/string>/Umsi", $contents, $names );
		$users = array ();
		foreach ( $names [1] as $k => $user ) {
			//$user = iconv($user,'utf-8','gb2312'); 
			$users [$mails [1] [$k]] = $user;
		}
		unlink ( $this->cookie );
		return $users;
	}
	
	/**
	 * 
	 * 获取header、sid
	 */
	private function _getheader() {
		$url = "http://entry.mail.126.com/cgi/ntesdoor?username=" . $this->username . "@126.com&hid=10010102&lightweight=1&verifycookie=1&language=0&style=-1";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, $this->cookie ); //当前使用的cookie 
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, $this->cookie ); //服务器返回的新cookie 
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_HEADER, true );
		curl_setopt ( $ch, CURLOPT_NOBODY, true );
		$content = curl_exec ( $ch );
		curl_close ( $ch );
		$this->_debug ( $content );
		
		preg_match_all ( '/Location:\s*(.*?)\r\n/i', $content, $regs );
		$refer = $regs [1] [0];
		preg_match_all ( '/http\:\/\/(.*?)\//i', $refer, $regs );
		$host = $regs [1] [0];
		preg_match_all ( "/sid=(.*)/i", $refer, $regs );
		$sid = $regs [1] [0];
		return array ('sid' => $sid, 'refer' => $refer, 'host' => $host );
	}
	
	/**
	 * 
	 * 生成debug日志
	 * @param string $filename
	 * @param string $content
	 */
	private function _debug($content) {
		if ($this->debug) {
			$hd = fopen ( './126_debug', 'a' );
			fwrite ( $hd, $content );
			fwrite ( $hd, "\n\n---------------------------------------------------\n" );
			fclose ( $hd );
		}
	}
}
/*
$auth = new http126();
$auth->login('username', 'XXXXXX');
$re = $auth->getAddressList();
var_dump($re);
*/
?>