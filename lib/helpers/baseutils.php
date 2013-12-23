<?php
    class BaseUtils{
    	public static $DEFAULT_NOTICE = '目前暂无公告';
        public static $PROFILE_GENDER = array(0 => '保密', 1 => '男', 2 => '女');
        public static $PEOPLE_GENDER = array(0 => '他', 1 => '他', 2 => '她');
        public static $REGISTER_MAILS = array(
            array('263','http://mail.263.net','263.net'),
            array('91天下','http://mail.91.com','91.com'),
            array('QQ','http://mail.qq.com',array('qq.com','vip.qq.com')),
	        array('TOM邮箱','http://mail.tom.com','tom.com'),
	        array('Hotmail','http://mail.live.com','hotmail.com'),
	        array('MSN','http://mail.live.com','msn.com'),
	        array('Gmail','http://www.gmail.com','gmail.com'),
	        array('搜狐','http://mail.sohu.com','sohu.com'),
	        array('网易126','http://mail.126.com','126.com'),
	        array('网易163','http://mail.163.com','163.com'),
	        array('网易VIP','http://vip.163.com','vip.163.com'),
	        array('新华网','http://mail.xinhuanet.com','xinhuanet.com'),
	        array('新浪','http://mail.sina.com.cn',array('sina.com','sina.cn','vip.sina.com','my3ai.sina.com')),
	        array('新浪2008','http://mail.2008.sina.com.cn/','2008.sina.com.cn'),
            array('雅虎','http://mail.cn.yahoo.com/',array('yahoo.com.cn','yahoo.cn')),
	        array('亿唐','http://mail.etang.com','etang.com'),
	        array('亿邮','http://mail.eyou.com','eyou.com'),
	        array('21cn','http://mail.21cn.com','21cn.com'),
        );
        
        public static $QUESTION_RESULT = array(
          1 =>  array(4,0),
          2 =>  array(4,0),
          3 =>  array(4,0),
          4 =>  array(1,0),
          5 =>  array(1,0),
          6 =>  array(5,0),
          7 =>  array(7,0),
          8 =>  array(1,0),
        );
        
        public static $ERROR_NUMBERS = array(
			1 => array('Not login.'),
			2 => array('Invalid Formhash.'),
			3 => array('Insufficient privilege.'),
			11 => array('Wrong username or password'),
			99 => array('Unknown error'),
			101 => array('Duplicate Process.'),
			201 => array('Empty.'),
			
        );
        
        public static $TASK_ARRAY = array(
                    TASK_UPLOAD_BUDDYICON, 
                    TASK_EMAIL_CERTIFICATE, 
                    TASK_BIND_MOBILE, 
                    TASK_INVITE_FRIEND, 
                    TASK_INVESTMENT_TEST,
                    TASK_BIND_WEIBO
        );
        
    }
?>