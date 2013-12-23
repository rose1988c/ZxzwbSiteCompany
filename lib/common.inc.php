<?php
/**
 * 应用相关的全局函数/变量
 *
 * @author Bill
 * @version $Id$
 * @copyright Me, 12 November, 2009
 * @package default
 **/

/********************************************************************************************
 * 异常定义
 *******************************************************************************************/

class MccException extends Exception {
}
class UserUnveriflyException extends MccException {
}
class SecurityException extends MccException {
}
class NotFoundException extends MccException {
}
class AlreadyExistsException extends MccException {
}
class LimitReachedException extends MccException {
}
class NoGroupViewException extends MccException {
    
}
class AskPrivateException extends MccException {
}
class NoLegendViewException extends MccException {
}
class UserBlockedException extends MccException {
}
class ManagePermissionException extends MccException {
}
class ManageNotFoundException extends MccException {
}
class BaiDuNotFoundException extends MccException {
}
class MatchManagePermissionException extends MccException {
}

/********************************************************************************************
 * 常量定义
 *******************************************************************************************/

define('ONE_HOUR', 3600); //60 * 60
define('ONE_DAY', 86400); //60 * 60 * 24
define('ONE_MONTH', 2592000); //60 * 60 * 24 * 30

define ( 'API_VERSION', '1.3.8' );
define ( 'API_UPDATE_FORCE', false );
define ( 'API_UPDATE_URL', 'http://itunes.apple.com/cn/app/id428453186?mt=8');

define ( 'API_ANDROID_VERSION', '1.0.6');
define ( 'API_ANDROID_UPDATE_FORCE', false);
define ( 'API_ANDROID_UPDATE_URL', 'http://www.7878.com/bin/7878.com.apk'); 

define ( 'API_MATCH_VERSION', '1.0.1' );
define ( 'API_MATCH_UPDATE_FORCE', false );
define ( 'API_MATCH_UPDATE_URL', 'http://itunes.apple.com/cn/app/id578897162?mt=8');

define ( 'GAME_VERSION', '2.00' );

// 用户状态
define ( 'USER_UNVERIFIY', 'unverifly' ); // 未通过验证(只要邮箱验证 和 手机验证 其中的一个验证通过了 代表 通过验证)
define ( 'USER_OK', 'ok' );
define ( 'USER_ACE', 'ace' );
define ( 'USER_ADVISER', 'adviser' );
define ( 'USER_ANALYST', 'analyst' );
define ( 'USER_DISABLED', 'disabled' );
define ( 'USER_CS', 'cs' );
define ( 'USER_EDITOR', 'editor' );
define ( 'USER_MANAGER', 'manager' );
define ( 'USER_ADMIN', 'admin' );
define ( 'USER_MINGREN', 'mingren' );
define ( 'USER_TREASURER', 'treasurer' );
define ( 'USER_MARKING_EXT', 'marking_ext' );
define ( 'USER_MARKING_IN', 'marking_in' );
define ( 'USER_VIP', 'vip' );//资本魔方贵宾卡用户

define ( 'USER_STATUS_UNVERIFIY', 0 ); // 未通过邮件验证
define ( 'USER_STATUS_OK', 1 );
define ( 'USER_STATUS_DISABLED', 2 );

//用户验证状态
define ( 'USER_EMAIL_VERIFICATION_STATUS_NO', 0 ); // 未通过 邮件验证
define ( 'USER_EMAIL_VERIFICATION_STATUS_OK', 1 ); //通过邮箱验证
define ( 'USER_MOBILE_VERIFICATION_STATUS_NO', 0 ); // 未通过 手机验证
define ( 'USER_MOBILE_VERIFICATION_STATUS_OK', 1 ); //通过手机验证


define ( 'USER_TYPE_BASE', 0 );
define ( 'USER_TYPE_BIZ', 1 );

// 投资风格
define ( 'INVEST_STYLE_SPECULATE', 21 );
define ( 'INVEST_STYLE_INVEST', 10 );
define ( 'INVEST_STYLE_STOCKPILE', 0 );

define ( 'VERIFY_JOIN_NOTSET', 0 );
define ( 'VERIFY_JOIN_BLACK', 1 );
define ( 'VERIFY_JOIN_OK', 10 );
define ( 'VERIFY_JOIN_VIP', 20 );

// 消息状态
define ( 'MESSAGE_UNREAD', 0 );
define ( 'MESSAGE_READ', 1 );
define ( 'MESSAGE_DELETED', 2 );
define ( 'MESSAGE_SEND', 10 );
define ( 'MESSAGE_SAVE', 11 );

// 帖子状态
define ( 'POST_DRAFT', 0 );
define ( 'POST_PUBLISHED', 1 );
define ( 'POST_DELETED', 2 );

define ( 'NEWSFEED_DELETED', 99 );

//微信回复
define ( 'NEWSFEED_MP_WEIXIN_TYPE_TEXT',  'text');
define ( 'NEWSFEED_MP_WEIXIN_REPLY',  '1');

define ('REDIS_SYSTEM_KEY_USER', 'user');
define ('REDIS_SYSTEM_KEY_GROUP', 'group');
define ('REDIS_SYSTEM_KEY_STOCK', 'stock');
define ('REDIS_SYSTEM_KEY_STAT', 'stat');
define ('REDIS_SYSTEM_KEY_BLOG', 'blog');
define ('REDIS_SYSTEM_KEY_TOPIC', 'topic');
define ('REDIS_SYSTEM_KEY_LEGEND', 'legend');
define ('REDIS_SYSTEM_KEY', 'system');
define ('REDIS_SYSTEM_KEY_ASK', 'ask');
define ('REDIS_SYSTEM_KEY_STAR', 'star');
define ('REDIS_SYSTEM_KEY_FORECAST', 'forecast');
define ('REDIS_SYSTEM_KEY_MATCH', 'match');
define ('REDIS_SYSTEM_KEY_GAME', 'game');
define ('REDIS_SYSTEM_KEY_WEBCAST', 'webcast');
define ('REDIS_SYSTEM_KEY_VOD', 'vod');

define ( 'STOCK_INIT_MONEY', 500000 );

// 礼物状态
define ( 'GIFT_SEND_OPEN', 0 ); /*公开赠送*/
define ( 'GIFT_SEND_PRIVATE', 1 ); /*私下赠送*/
define ( 'GIFT_SEND_ANONYMOUS', 2 ); /*匿名赠送*/

define ( 'NEWSFEED_CLIENT_BROWSER', 0 );
define ( 'NEWSFEED_CLIENT_IPHONE', 1 );
define ( 'NEWSFEED_CLIENT_ANDROID', 2 );
define ( 'NEWSFEED_CLIENT_WINDOWSMOBILE', 3 );
define ( 'NEWSFEED_CLIENT_SYMBIAN', 4 );

define ( 'USER_STATUS_TRACK_INFORMED', 'inform_track' );

//status
//define('CONTENT_DRAFT', 1); //草稿
define('CONTENT_DELETED', 128); //已删除
define('CONTENT_FORBIDDEN', 127); //禁止
define('CONTENT_SUSPICIOUS1', 126); //相当可疑
define('CONTENT_SUSPICIOUS2', 125); //一般可疑, 普通用户可以看到
define('CONTENT_SUSPICIOUS3', 124); //白名单可疑

/********************************************************************************************
 * 表定义
 *******************************************************************************************/
$GLOBALS['ShardingNodes'] = new DBTable('ShardingNodes', 'sharding_nodes', array(
        'node_id'  => array('type' => 'long', 'primary' => true, 'auto_increment' => true),
        'shard_id' => array('type' => 'long'),
        'host'     => array('type' => 'string'),
        'db_name'  => array('type' => 'string'),
        'user'     => array('type' => 'string'),
        'password' => array('type' => 'string'),
    ));

$GLOBALS['SyncTasks'] = new DBTable('SyncTasks', 'mcc_sync_tasks', array(
        'task_id'     => array('type' => 'string', 'primary' => true),
        'task_type'   => array('type' => 'string'),
        'start_at'    => array('type' => 'datetime'),
        'finished_at' => array('type' => 'datetime', 'null' => true),
    ));
    
// 覆盖auth.php里的Users表定义
$GLOBALS['Users'] = new DBTable('Users', 'users', array(
        'user_id'      => array('type' => 'long', 'primary' => true, 'auto_increment' => true),
        'username'     => array('type' => 'string'),
        'password'     => array('type' => 'string'),
        'nickname'     => array('type' => 'string'),
        'email'        => array('type' => 'string'),
        'icon_bucket'  => array('type' => 'string', 'null' => true),
        'icon_key'     => array('type' => 'string', 'null' => true),
        'roles'        => array('type' => 'string'),
        'created_at'   => array('type' => 'datetime'),
        'user_type'    => array('type' => 'integer'),
        'status'       => array('type' => 'integer'),
        'phone_number' => array('type' => 'string'),
    ));

$GLOBALS['UserTokens'] = new DBTable('UserTokens', 'user_tokens', array(
        'user_id'     => array('type' => 'long', 'primary' => true),
        'token'       => array('type' => 'string', 'primary' => true),
        'login_ip'    => array('type' => 'long'),
        'created_at'  => array('type' => 'datetime'),
        'expire_date' => array('type' => 'datetime'),
        'token_type'  => array('type' => 'string', 'default' => 'auth'),
    ));

$GLOBALS['UserLogins'] = new DBTable('UserLogins', 'user_logins', array(
        'user_id'  => array('type' => 'long', 'primary' => true),
        'login_id' => array('type' => 'long', 'primary' => true, 'auto_increment' => true),
        'login_ip' => array('type' => 'long'),
        'login_at' => array('type' => 'datetime'),
    ));
    
//用户信息
$GLOBALS['UserProfile'] = new ShardedDBTable('UserProfile', 'mcc_user_profile', 'user_id', array(
        'user_id'                    => array('type' => 'long', 'primary' => true),
        'birth_date'                 => array('type' => 'string', 'null' => true),
        'province'                   => array('type' => 'string', 'null' => true),
        'city'                       => array('type' => 'string', 'null' => true),
        'gender'                     => array('type' => 'integer', 'null' => true),
        'space_name'                 => array('type' => 'string', 'null' => true),
        'investment_monitor'         => array('type' => 'string', 'null' => true),
        'phone_number'               => array('type' => 'string', 'null' => true),
        'stock_age'                  => array('type' => 'integer', 'null' => true),
        'investment_types'           => array('type' => 'string', 'null' => true),
        'firm_offer_fund'            => array('type' => 'integer', 'null' => true),
        'invest_type'                => array('type' => 'integer', 'null' => true, 'default' => '-1'),
        'profile'                    => array('type' => 'string'),
        'email_verification_status'  => array('type' => 'integer'),
        'mobile_verification_status' => array('type' => 'integer'),
        'home_style'                 => array('type' => 'long'),
        'weibo_skin'                 => array('type' => 'integer'),
        'vip_show_stock_module'      => array('type' => 'integer', 'default' => '1'),
		'is_allowed_paid_legend'     => array('type' => 'integer', 'default' => '10'),//是否允许用户发付费传说(10 不允许， 20 允许)
        'job'                        => array('type' => 'string', 'null' => true),
        'allow_reset_account'        => array('type' => 'integer'),
        'vip_discount'               => array('type' => 'float unsigned', 'default' => 0.8),
        'vip_start_at'               => array('type' => 'datetime', 'default' => '0000-00-00 00:00:00'),
        'vip_end_at'                 => array('type' => 'datetime', 'default' => '0000-00-00 00:00:00'),
    ));
    
//用户隐私设置
$GLOBALS['UserPrivacySettings'] = new ShardedDBTable('UserPrivacySettings', 'mcc_user_privacy_settings', 'user_id', array(
        'user_id'                      => array('type' => 'long', 'primary' => true),
        'simulated_stock_transactions' => array('type' => 'integer'),
        'add_friend'                   => array('type' => 'integer'),
        'add_optional_share'           => array('type' => 'integer'),
        'publish_bowen_topic'          => array('type' => 'integer'),
        'add_join_group'               => array('type' => 'integer'),
        'last_change_time'             => array('type' => 'datetime'),
    ));
    
$GLOBALS['UserAccount'] = new DBTable('UserAccount', 'mcc_user_account', array(
        'user_id'        => array('type' => 'long', 'primary' => true),
        'init_money'     => array('type' => 'double', 'default' => 500000),
        'total_money'    => array('type' => 'double', 'default' => 500000),
        'unfrozen_money' => array('type' => 'double', 'default' => 500000),
        'frozen_money'   => array('type' => 'double', 'default' => 0),
        'deal_money'     => array('type' => 'double', 'default' => 0),
        'total_value'    => array('type' => 'double', 'default' => 0),
        'position'       => array('type' => 'float', 'default' => 0),
        'currency'       => array('type' => 'integer', 'default' => 0),
        'scores'         => array('type' => 'float', 'default' => 10),
        'exps'           => array('type' => 'float', 'default' => 10),
        'mvalue'         => array('type' => 'long', 'default' => 0),
        'created_at'     => array('type' => 'datetime'),
        'last_updated'   => array('type' => 'datetime'),
    ));
    
//用户信息统计 
$GLOBALS['UserStat'] = new ShardedDBTable('UserStat', 'mcc_user_stat', 'user_id', array(
        'user_id'                  => array('type' => 'long', 'primary' => true),
        'charms'                   => array('type' => 'long', 'null' => true),
        'hold_stocks'              => array('type' => 'long'),
        'groups'                   => array('type' => 'long'),
        'chats'                    => array('type' => 'long'),
        'shares'                   => array('type' => 'long'),
        'blogs'                    => array('type' => 'long'),
        'messages'                 => array('type' => 'long'),
        'website_messages'         => array('type' => 'long'),
        'friends'                  => array('type' => 'long'),
        'replys'                   => array('type' => 'long'),
        'joined_groups'            => array('type' => 'long'),
        'topics'                   => array('type' => 'long'),
        'created_groups'           => array('type' => 'long'),
        'tracks'                   => array('type' => 'long'),
        'active_user_scores'       => array('type' => 'long'),
        'active_user_scores_level' => array('type' => 'integer'),
        'invitors'                 => array('type' => 'long'),
        'invitors_level'           => array('type' => 'integer'),
        'writers_scores'           => array('type' => 'long'),
        'writers_scores_level'     => array('type' => 'integer'),
        'legend_accuracy'          => array('type' => 'integer'),
        'stock_yield'              => array('type' => 'integer'),
        'trackers'                 => array('type' => 'long'),
        'today_topics'             => array('type' => 'long'),
        'today_replys'             => array('type' => 'long'),
        'today_blogs'              => array('type' => 'long'),
        'today_scores'             => array('type' => 'long'),
        'total_scores'             => array('type' => 'long'),
        'today_mvalue'             => array('type' => 'long'),
        'total_mvalue'             => array('type' => 'long'),
        'forwards'                 => array('type' => 'long'),
        'deal_times'               => array('type' => 'long'),
        'login_times'              => array('type' => 'long'),
    ));
$GLOBALS['UserDealStat'] = new ShardedDBTable('UserDealStat', 'mcc_user_deal_stat', 'user_id', array(
        'user_id'            => array('type' => 'long', 'primary' => true),
        'short_term_money'   => array('type' => 'double'),
        'middle_term_money'  => array('type' => 'double'),
        'long_term_money'    => array('type' => 'double'),
        'large_stock_money'  => array('type' => 'double'),
        'small_stock_money'  => array('type' => 'double'),
        'st_stock_money'     => array('type' => 'double'),
        'gem_stock_money'    => array('type' => 'double'),
        'b_stock_money'      => array('type' => 'double'),
        'large_stock_profit' => array('type' => 'double'),
        'small_stock_profit' => array('type' => 'double'),
        'st_stock_profit'    => array('type' => 'double'),
        'gem_stock_profit'   => array('type' => 'double'),
        'b_stock_profit'     => array('type' => 'double'),
    ));
    
    
$GLOBALS['UserStatus'] = new ShardedDBTable('UserStatus', 'mcc_user_status', 'user_id', array(
        'user_id'     => array('type' => 'long', 'primary' => true),
        'key'         => array('type' => 'string', 'primary' => true),
        'status'      => array('type' => 'string'),
        'last_update' => array('type' => 'datetime'),
    ));

function mcc_host_info() {
	global $host_info;
	
	if (! isset ( $host_info )) {
		$host = $_SERVER ['HTTP_HOST'];
		$user = false;
		
		if ($host == '7878.com') {
			return array ('host' => $host, 'user' => $user );
		}
		$parts = explode ( '.', $host );
		$username = count ( $parts ) == 4 ? ($parts [0] . '.' . $parts [1]) : $parts [0];
		
		if ($username != 'www') {
			global $Users;
			$user = $Users->fetch_one ( array ('username' => $username ) );
		}
		
		$host_info = array ('host' => $host, 'user' => $user );
	}
	return $host_info;
}
function mcc_count_unread_messages() {
	if (isset ( $GLOBALS ['unread_msgs'] ))
		return $GLOBALS ['unread_msgs'];
	
	global $auth, $Inbox;
	
	if (! $auth->is_logged_in ()) {
		$GLOBALS ['unread_msgs'] = 0;
	} else {
		$GLOBALS ['unread_msgs'] = $Inbox->count ( array ('user_id' => $auth->id, 'status' => MESSAGE_UNREAD ) );
	}
	return $GLOBALS ['unread_msgs'];
}

function mcc_get_previous_login_time() { /*{{{*/
	if (isset ( $_SESSION ['previous_login'] ))
		return $_SESSION ['previous_login'];
	
	global $auth, $UserLogins;
	
	if (! $auth->is_logged_in ())
		return false;
	
	$logins = $UserLogins->fetch ( array ('user_id' => $auth->id, 'order_by' => 'login_at desc', 'limit' => 2 ) );
	
	if (count ( $logins ) < 2)
		return 0;
	
	$login_time = $logins [1]->login_at;
	
	$_SESSION ['previous_login'] = $login_time;
	return $login_time;
}

function mcc_get_previous_login_ip($user = false) {
	global $auth, $UserLogins;
	
	$user_id = $user === false ? $auth->id : (is_object ( $user ) ? $user->user_id : $user);
	$query = array ('user_id' => $user_id, 'order_by' => 'login_at desc' );
	
	$user_login = $UserLogins->fetch_one ( $query );
	
	return $user_login == false ? 0 : $user_login->login_ip;
}

function mcc_get_new_stocks() {
	_require(DOC_ROOT . '/lib/services/user_stock.php');
	$stocks = mcc_get_stocks ( array ('is_new' => 1, 'page' => false, 'per_page' => false ) );
	return $stocks;
}

function mcc_get_user_status($users, $group) {
	$redises = array ();
	_require(DOC_ROOT . '/lib/services/redis.php');
	$status = array ();
	$now = time ();
	if (empty ( $users ))
		return $status;
	$group_id = is_object ( $group ) ? $group->group_id : $group;
	foreach ( $users as $user ) {
		$user_id = is_object ( $user ) ? $user->user_id : $user;
		$redis = get_user_redis ( $user_id, true );
		$lastping = $redis->get ( "user:lastping:$group_id:$user_id" );
		if ($lastping && ($now - intval ( $lastping )) < 600)
			$status [$user_id] = true; //online;
		else
			$status [$user_id] = false;
	}
	return $status;
}

function mcc_user_online($user) {
	_require(DOC_ROOT . '/lib/services/redis.php');
	$user_id = is_object ( $user ) ? $user->user_id : $user;
	$redis = get_user_redis ( $user_id );
	
	$redis->set ( "user:lastping:$user_id", time () );
}

function mcc_get_related_groups() {
	global $auth;
	if (! $auth->is_logged_in ()) {
		return array ();
	}
	
	$user = $auth->user;
	_require(DOC_ROOT . '/lib/services/group.php');
	$user_groups = mcc_get_user_groups ( $user, array ('group_type' => GROUP_TYPE_NORMAL, 'order_by' => 'roles desc, visit_times desc' ), false, 50);
	$owned_groups = array ();
	$joined_groups = array ();
	$focused_groups = array ();
	$latest_groups = array ();
	$mostly_groups = array ();
	$latest_stocks_groups = array ();
	$hot_groups = array();
	foreach ( $user_groups as $ug ) {
		if(!$ug) {continue;}
		$g = mcc_get_group ( $ug->group_id );
		if ($ug->roles == GROUP_ROLE_ADMIN || $ug->roles == GROUP_ROLE_CREATOR)
			$owned_groups [] = $g;
		if ($ug->roles == GROUP_ROLE_MEMBER)
			$joined_groups [] = $g;
	}
	$joined_groups = array_slice ( $joined_groups, 0, 10 );
	
	return array ('owned_groups' => $owned_groups, 
			'joined_groups' => $joined_groups, 
			'focused_groups' => $focused_groups, 
			'latest_groups' => $latest_groups, 
			'mostly_groups' => $mostly_groups, 
			'latest_stocks_groups' => $latest_stocks_groups);
}

function mcc_get_joined_matches () {
	global $auth;
	
	if (! $auth->is_logged_in ()) {
		return array ();
	}
	
	$user = $auth->user;
    
    $running_matchs = array();//running match
    
    _require(DOC_ROOT . '/lib/services/match.php');
    _require(DOC_ROOT . '/lib/services/match_player.php');
    _require(DOC_ROOT . '/lib/services/league.php');
    _require(DOC_ROOT . '/lib/services/league_user.php');
    
    $leaguer_player = mcc_get_league_user($user->user_id);//千万实盘
    
	$match_players = mcc_get_match_players(array('user_id'=>$user->user_id/*, 'order_by'=>'updated_at desc'*/));
	
	if (is_object($leaguer_player)) {
	    $running_matchs [] = array('match_name' => '千万实盘大奖赛', 'match_url' => Urls::absolute('/match/qwsp/account/'));
	}
	
	if( is_array($match_players) ) {
		foreach ($match_players as $match_player)
		{
		    $match = mcc_get_match($match_player->match_id);
		    if (is_object($match)) {
    			if( $match->match_type == MATCH_TYPE_PRIVATE  )
    			{
    				continue;
    			}
    			if( is_object($match) && $match->status == MATCH_STATUS_CREATED )
    			{
    				if( $match->object_type == MATCH_OBJECT_TYPE_NORMAL && strtotime( '+1 day', $match->end_at) < time() )
    				{
    					continue;
    				}
    				if( $match->object_type == MATCH_OBJECT_TYPE_LEAGUE && strtotime( '+1 day', $match->league_season->end_at) < time() )
    				{
    					continue;
    				}
    				$running_matchs[] = array('match_name' => $match->match_name, 'match_url' => Urls::matchurl($match, '/account/'));
    			}
		    }
		}
	}
	return $running_matchs;
}



function md5_hmac($key, $data) {
	if (function_exists ( 'hash_hmac' )) {
		return hash_hmac ( 'md5', $data, $key );
	}
	$key = (strlen ( $key ) > 64) ? pack ( 'H32', 'md5' ) : str_pad ( $key, 64, chr ( 0 ) );
	$ipad = substr ( $key, 0, 64 ) ^ str_repeat ( chr ( 0x36 ), 64 );
	$opad = substr ( $key, 0, 64 ) ^ str_repeat ( chr ( 0x5C ), 64 );
	return md5 ( $opad . pack ( 'H32', md5 ( $ipad . $data ) ) );
}

function random_text() {
	$chars = array_flip ( array_merge ( range ( 0, 9 ), range ( 'A', 'Z' ) ) );
	for($i = 0, $text = ''; $i < 10; $i ++) {
		$text .= array_rand ( $chars );
	}
	return $text;
}

function toHex($t) {
	$j = "";
	//将字符串转为16进制
	for($i = 0; $i < strlen ( $t ); $i ++) {
		$j .= dechex ( ord ( substr ( $t, $i, 1 ) ) );
	}
	return $j;
}

function is_vip_user($user) {

	$role = is_object($user) ? $user->roles : $user;
	$roles = @explode(',', $role);
	
	$vip_roles = array(
					USER_ACE, 		//炒股高手
					USER_ADVISER, 	//投资顾问
					USER_ANALYST,	//证券分析师
		        	USER_MINGREN 	//名人堂高手
  	);
  	
	$is_vip_user = false;
	foreach ($roles as $role) {
		if(in_array($role, $vip_roles)) {
	 		$is_vip_user = true;
	    	break;
	  	}    	
    }
	return $is_vip_user;
}

function set_client_id() {
	if (!isset($_COOKIE['cid']) || !is_string($_COOKIE['cid'])) {
		setcookie('cid', uuid(), time() + 3600*24*365*10, '/');
	}
}
?>