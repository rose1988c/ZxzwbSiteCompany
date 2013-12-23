<?php

class Urls {
    
	public static function image($key, $image_type = 'jpg') {
		$img_src = '';
		
		// 如果是对象
		// 默认字段 image_type 代表图片后缀
		if (is_object($image_type)){
		    $image_type = ( $image_type->image_type != null && $image_type->image_type != '' ) ? $image_type->image_type : 'jpg';
		} else {
	    //传入普通字符 判断是否为空
		    if (!strlen ( $image_type ) > 0){
		        $image_type = 'jpg';
		    }
		}
		
		if (strlen ( $key ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
		    $img_src = "http://img." . $host . "/" . $key . '.' . $image_type;
		}
		
		return $img_src;
	}
	
	public static function buddyicon($user = false, $large = false) {
		if ($user && $user->icon_key) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico.$host/{$user->icon_key}.jpg";
		}
		return MEDIA_ROOT . '/img/head.gif';
	}
	
	public static function mingrenicon($headurl) {
		if (strlen ( $headurl ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $headurl . ".jpg";
		}
		return MEDIA_ROOT . '/img/head.gif';
	}
	
	public static function matchicon($headurl) {
		if (strlen ( $headurl ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $headurl . ".jpg";
		}
		return MEDIA_ROOT . '/img/head.gif';
	}
	
	public static function geticon($url) {
		$img_src = MEDIA_ROOT . '/img/head.gif';
		
		if (strlen ( $url ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			
			/** 得到有后缀的图片 */
			if (strpos($url, '.') !== false) {
			    $img_src = "http://ico." . $host . "/" . $url;
			} else {
			    $img_src = "http://ico." . $host . "/" . $url . ".jpg";
			}
		}
		
		return $img_src;
	}
	
	public static function get_group_user_medal_icon($group_medal) {
		if (strlen ( $group_medal->icon ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $group_medal->icon . "." . $group_medal->image_type;
		}
		return '';
	}
	
	public static function match_sponsor_logo( $match )
	{
		if (strlen ( $match->sponsor_logo ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $match->sponsor_logo . ".jpg";
		}
		return MEDIA_ROOT . '/img/match/sponsor_logo.gif';
	}
	
	public static function match_commend_logo( $match_commend )
	{
	    $logo = is_object($match_commend) ? $match_commend->logo : $match_commend;
		if (strlen ( $logo ) > 0) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $logo . ".jpg";
		}
		return MEDIA_ROOT . '/img/match/match-noImg.gif';
	}
	
	public static function matchurl($match, $path = '/')
	{
		$site_domain = self::_get_domain ();
		if( !is_object($match) )
		{
			return false;
		}
		if( !empty($match->match_url) )
		{
			return $match->match_url;
		}
		return $site_domain . "/match/" . $match->match_id . $path;
	}
	
	public static function match_template($match, $is_output = false)
	{
		$site_domain = self::_get_domain ();
		$host = config_get ( 'mogilefs.domain' );
		if( !is_object($match) )
		{
			return $site_domain . "/img/match/common/banner.gif";
		}
		$template = $is_output ? $match->output_template : $match->template;
		if( !strlen($template) )
		{
			return $site_domain . "/img/match/common/banner.gif";
		}
		if( strlen((int)$template) == strlen($template) )
		{
			return $site_domain . "/img/match/common/template" . $template . ".gif";
		}
		return "http://img." . $host . "/" . $template . ".jpg";
	}
	
	public static function article($node_id,$file_key,$file_ext,$type=false) {
	   
		$host = config_get ( 'mogilefs.domain' );
		if ($type =='image') {
			return "http://img." . $host . "/" . $file_key . ".jpg";
		}else{
		    return  "http://file{$node_id}.$host/{$file_key}.{$file_ext}";
		}
		return;
	}

	
	public static function weiboicon($weibo = false, $type = 'small') {
		if ($weibo) {
			$host = config_get ( 'mogilefs.domain' );
			$image = '';
			switch ($type) {
				case 'small' :
					$image = $weibo->image_small;
					break;
				case 'medium' :
					$image = $weibo->image_medium;
					break;
				case 'original' :
					$image = $weibo->image_original;
					break;
			}
			
			if ($image != '') {
				return "http://img.$host/{$image}.jpg";
			}
		
		}
		return;
	}
	
	public static function gifticon($gift = false, $large = false) {
		
		if ($gift && $gift->gift_icon) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico.$host/{$gift->gift_icon}.jpg";
		}
		return MEDIA_ROOT . '/img/blog/lw/01.gif';
	
	}	
	public static function adicon($ad = false, $large = false) {
		
		if ($ad && $ad->ad_icon) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico.$host/{$ad->ad_icon}.jpg";
		}
		return false;
	}
	
	public static function sysicon($src) {
		$host = config_get ( 'mogilefs.domain' );
		return "http://ico.$host/{$src}.jpg";
	}
	
	public static function download($file, $type = false) {
		
		$download = "";
		if ($file && $file->file_key) {
			$host = config_get ( 'mogilefs.domain' );
			$download = "http://file{$file->node_id}.$host/{$file->file_key}.{$file->file_ext}";
		}
		if($type != false) {
			
			switch ($type) {
				case "thunder" :
					$download = base64_encode("AA{$download}ZZ");
					$download = "thunder://{$download}";
					break;
				case "viewer" :
					$site_domain = config_get ( 'site_domain' );
					$download = "http://doc.$site_domain/?file={$download}";
					break;
			}
			
		}
		return $download;
	}
	
	public static function charticon($stock, $type = "kd") {
		
		$site_domain = config_get ( 'site_domain' );
		$url = "http://chart.$site_domain";
		
		if ($stock == false) {
			return MEDIA_ROOT . '/img/charts/single_chart_error.jpg';
		}
		if ($stock->stock_type == STOCK_TYPE_SHANG_A) {
			$url = "$url/$type/sh$stock->symbol.gif";
		} else if ($stock->stock_type == STOCK_TYPE_SHEN_A) {
			$url = "$url/$type/sz$stock->symbol.gif";
		}
		$now = time ();
		$url = "$url?$now.gif";
		return $url;
	}
	
	public static function userchart($user = false, $size = "in") {
		$site_domain = config_get ( 'site_domain' );
		$url = "http://chart.$site_domain";
		$user_id = is_object ( $user ) ? $user->user_id : $user;
		if (! $user_id)
			$user_id = 0;
		$stamp = date ( 'ymd' );
		if (! $user)
			$user_id = 0;

		if( $size == 'league' )
		{
			_require(DOC_ROOT . '/lib/services/league_stock.php');
			$criteria = array(
							'action__in'=>	array(STOCK_DEAL_ACTION_BUY_IN, STOCK_DEAL_ACTION_SELL_OUT), 
							'order_by'	=>	'created_at asc'
						);
			$deal_log = mcc_get_league_deal_log($user_id, $criteria);
			if( !$deal_log || date("Y-m-d", $deal_log->created_at) == date("Y-m-d", time()) ){
				 return Urls::absolute('/img/charts/people_chart_error2.gif');
			}
		}	
		return "http://chart.$site_domain/$size/$user_id.gif?$stamp.gif";
	}
	
	public static function legendchart($legend = false) {
		$site_domain = config_get ( 'site_domain' );
		$url = "http://chart.$site_domain";
		$legend_id = is_object ( $legend ) ? $legend->legend_id : $legend;
		if (! $legend_id || ! $legend)
			$legend_id = 0;
		
		return "http://chart.$site_domain/legend/$legend_id.gif";
	}
	
	public static function relative($path = '/') {
		return $path;
	}
	
	public static function absolute($path = '/', $schema = 'http') {
		if ($schema instanceof DBObject) $schema = true;
		$site_domain = self::_get_domain($schema);
		return $site_domain . $path;
	}
	public static function update_buddyicon($path = '/') {
		$site_domain = self::_get_domain ();
		return $site_domain . $path;
	}
	
	public static function absolute_user($path = '/', $user = null) {
		if (is_null ( $user )) {
			global $auth;
			if ($auth->is_logged_in ())
				$user = $auth->user;
		}
		return self::absolute ( $path, $user );
	}
	
	public static function media($path) {
		$devmode = config_get ( 'devmode', false );
		if (preg_match ( '/\.css$/i', $path )) {
			$css_base = MEDIA_ROOT . ($devmode ? '/_src/css' : '/css');
			return $css_base . $path;
		}
		
		if (preg_match ( '/\.js$/i', $path )) {
			$js_base = MEDIA_ROOT . ($devmode ? '/_src/js' : '/js');
			return $js_base . $path;
		}
		
		return MEDIA_ROOT . $path;
	}
	
	public static function user($user = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/people/{$user->username}$path";
			}
			return "$site_domain/people/{$user->user_id}$path";
		}
		return "$site_domain/people/{$user}$path";
	}
	
	public static function t($user = false, $path = '/') {
	    /*
		$t_domain = self::_get_t_domain ();
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$t_domain/{$user->username}$path";
			}
			return "$t_domain/{$user->user_id}$path";
		}
		return "$t_domain{$path}";
		*/
		$site_domain = self::_get_domain ();
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/account/{$user->username}$path";
			}
			return "$site_domain/account/{$user->user_id}$path";
		}
		return "$site_domain/account{$path}";
	}
	
	public static function player($user = false, $match = false, $path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/match/people/";
		
		$match_id = is_object($match) ? $match->match_id : $match;
		if($match_id != false){
			$url = "$site_domain/match/$match_id/people/";
		}
		
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "{$url}{$user->username}$path";
			}
			return "{$url}{$user->user_id}$path";
		}
		return "{$url}{$user}$path";
	}
	
	//用户个人中心--炒股大赛 Author cyw  2012-2-6 13:54:01 

	public static function player_league($user = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		$url = "playstock/match/qwsp";
		if (is_object ( $user ) ) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/people/{$user->username}/{$url}{$path}";
			}
			return "$site_domain/people/{$user->user_id}/{$url}{$path}";
		}
		return "$site_domain/people/{$user}/{$url}{$path}";
	}
	
	public static function player_new($user = false, $match = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		$url = "playstock";
		$match_id = is_object($match) ? $match->match_id : $match;
		if($match_id != false){
		    $url = "playstock/match/{$match->match_id}";
		}
		if (is_object ( $user ) ) {
		    		    
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/people/{$user->username}/{$url}{$path}";
			}
			return "$site_domain/people/{$user->user_id}/{$url}{$path}";
		}
		return "$site_domain/people/{$user}/{$url}{$path}";
	}
	
	public static function invite($user = false, $http = true, $path = '/', $module = '/') {
		$site_domain = self::_get_domain ($http);
		if ($user == false) {
			return "$site_domain{$module}in/";
		}
		if (is_object ( $user )) {
			if (is_numeric($user->username) || preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain{$module}in/{$user->username}$path";
			}
			return "$site_domain{$module}id/{$user->user_id}$path";
		}
		return "$site_domain{$module}id/{$user}$path";
	}
	
	public static function user_blog($user, $blog, $position = false/*用于定位到目标页的某个位置*/, $method = false/*用于判断是分享还是评论（分页）*/, $path = '/') {
		$site_domain = self::_get_domain ();
		$blog_id = is_object($blog) ? $blog->blog_id : $blog;
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/people/{$user->username}/blog/$blog_id{$method}{$path}$position";
			}
			
			return "$site_domain/people/{$user->user_id}/blog/$blog_id{$method}{$path}$position";
		} else {
			return "$site_domain/people/$user/blog/{$blog_id}/";
		}
	
	}
	
	public static function stock_new($stock, $new, $position = ''/*用于定位到目标页的某个位置*/, $method = false/*用于判断是分享还是评论（分页）*/, $path = '/') {
		$site_domain = self::_get_domain ();
		$symbol = is_object ( $stock ) ? $stock->symbol : $stock;
		return "$site_domain/info/symbol/{$stock->symbol}/news/$new->news_id{$method}{$path}$position";
	}
	
	public static function user_evaluate($user, $path = '/') {
		$site_domain = self::_get_domain ();
		if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
			return "$site_domain/people/{$user->username}/evaluate/{$path}";
		}
		return "$site_domain/people/{$user->user_id}/evaluate/{$path}";
	}
	
	public static function user_group($user = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
			return "$site_domain/people/{$user->username}$path";
		}
		return "$site_domain/people/{$user->user_id}$path";
	}
	
	public static function about($path = '/') {
		
		$site_domain = self::_get_domain ();
		
		return "$site_domain/about$path";
	}
	
	public static function helps($path = '/') {
		
		$site_domain = self::_get_domain ();
		
		return "$site_domain/service$path";
	}
	
	public static function manage_user($user = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($user === false) {
			return "$site_domain/manage/user{$path}";
		}
		if (is_object ( $user ))
			return "$site_domain/manage/user/{$user->user_id}$path";
		else
			return "$site_domain/manage/user/{$user}$path";
	}
	
	public static function manage_blog($blog = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($blog === false) {
			return "$site_domain/manage/blog{$path}";
		}
		if (is_object ( $blog ))
			return "$site_domain/manage/blog/{$blog->blog_id}$path";
		else
			return "$site_domain/manage/blog/{$blog}$path";
	}
	
	public static function manage_group($group = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($group === false) {
			return "$site_domain/manage/group{$path}";
		}
		if (is_object ( $group ))
			return "$site_domain/manage/group/{$group->group_id}$path";
		else
			return "$site_domain/manage/group/{$group}$path";
	}
	
	public static function manage_legend($legend = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($legend === false) {
			return "$site_domain/manage/legend{$path}";
		}
		if (is_object ( $legend ))
			return "$site_domain/manage/legend/{$legend->legend_id}$path";
		else
			return "$site_domain/manage/legend/{$legend}$path";
	}
	
	public static function manage_news($stock = false, $news = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($stock === false) {
			if ($news === false) {
				return "$site_domain/manage/news{$path}";
			}
		}
		if (is_object ( $news ) && is_object ( $stock ))
			return "$site_domain/manage/news/symbol/$stock->symbol/new/{$news->news_id}$path";
		else
			return "$site_domain/manage/news{$path}";
	}
	
	public static function manage_node($node_id = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/manage";
		if ($node_id !== false && $node_id > 0) {
			$url = "{$url}/node{$node_id}";
		}
		if ($where !== false) {
			if (array_key_exists ( 'user_id', $where ) && $where ['user_id'] > 0) {
				$url = "{$url}/user{$where['user_id']}";
			}
			if (array_key_exists ( 'group_id', $where ) && $where ['group_id'] > 0) {
				$url = "{$url}/group{$where['group_id']}";
			}
			if (array_key_exists ( 'topic_id', $where ) && $where ['topic_id'] > 0) {
				$url = "{$url}/topic{$where['topic_id']}";
			}
			if (array_key_exists ( 'post_id', $where ) && $where ['post_id'] > 0) {
				$url = "{$url}/post{$where['post_id']}";
			}
		
		}
		return "$url{$path}";
	}
	
	public static function manage_website_new($website_new = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($website_new === false) {
			return "$site_domain/manage/about/new{$path}";
		}
		return "$site_domain/manage/about/new{$website_new->news_id}$path";
	}
	
	public static function manage_suggest($suggest = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($suggest === false) {
			return "$site_domain/manage/about{$path}";
		}
		return "$site_domain/manage/about/suggest{$suggest->suggest_id}$path";
	}
	
	public static function manage_website($path = '/') {
		$site_domain = self::_get_domain ();
		return "$site_domain/manage/site{$path}";
	}
	
	public static function manage_weibo($path = '/') {
		$site_domain = self::_get_domain ();
		return "$site_domain/manage/weibo{$path}";
	}
	
	public static function manage($path = '/', $name = '') {
		$site_domain = self::_get_domain ();
		
		if ($name == '') {
		    return "$site_domain/manage/";
		} else {
    		return "$site_domain/manage/{$name}{$path}";
		}
	}
	
	public static function manage_wealth_planning($path = '/') {
		$site_domain = self::_get_domain ();
		return "$site_domain/manage/wealth_planning{$path}";
	}
	
	public static function manage_log($log = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($log === false) {
			return "$site_domain/manage/actionlog{$path}";
		}
		return "$site_domain/manage/actionlog/{$log->log_id}$path";
	}
	
	public static function manage_gift($gift = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($gift === false) {
			return "$site_domain/manage/gift{$path}";
		}
		return "$site_domain/manage/gift/{$gift->gift_id}$path";
	}
	
	public static function manage_topic($topic = false, $path = '/') {
		$site_domain = self::_get_domain ();
		if ($topic === false) {
			return "$site_domain/manage/topic{$path}";
		}
		return "$site_domain/manage/group{$topic->group_id}/topic/{$topic->topic_id}$path";
	}
	
	public static function group($group = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/group";
		
		if ($group !== false) {
			if (! is_object ( $group ))
				$url = "{$url}/{$group}";
			else if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] > 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	
	public static function new_group($group = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/group";
		
		if ($group !== false) {
			if (! is_object ( $group ))
				$url = "{$url}/{$group}";
			else if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] > 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	
	public static function service($service = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/service";
		if ($service !== false) {
			if (! is_object ( $service ))
				$url = "{$url}/{$service}";
			else
				$url = "{$url}/{$service->service_id}";
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] >= 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	
	public static function inbox($inbox = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($inbox === false) {
			return "$site_domain/message{$path}";
		}
		
		return "$site_domain/message/{$inbox->message_id}/{$inbox->from_user_id}$path";
	}
	
	public static function outbox($outbox = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($outbox === false) {
			return "$site_domain/message{$path}";
		}
		
		return "$site_domain/message/{$outbox->message_id}/{$outbox->to_user_id}$path";
	}
	
	public static function draftbox($draft = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($draft === false) {
			return "$site_domain/message/draft{$path}";
		}
		
		return "$site_domain/message/draft/{$draft->draft_id}$path";
	}
	
	public static function account_group($path = '/', $group = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/group";
		
		if ($group !== false) {
			if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		return "{$url}$path";
	}
	public static function new_account_group($path = '/', $group = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/group";
		
		if ($group !== false) {
			if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		return "{$url}$path";
	}
	
	//cyw 新我的魔方 2012-02-27 11:24
	public static function new_account_group2($path = '/', $group = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/group";
		
		if ($group !== false) {
			if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		return "{$url}$path";
	}
	
	public static function new_account($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account";
		
		return "{$url}$path";
	}
	
	public static function new_t($user = false, $path = '/') {
		$t_domain = self::_get_domain ();
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$t_domain/account/{$user->username}$path";
			}
			return "$t_domain/account/{$user->user_id}$path";
		}
		return "$t_domain/account{$path}";
	}
	
	public static function new_account_blog($path = '/', $blog = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/blog";
		
		if ($blog !== false) {
			$url = "{$url}/{$blog->blog_id}";
		}
		
		return "{$url}$path";
	}
	
	public static function new_account_stock($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/stock";
		
		return "{$url}$path";
	}
	
	public static function new_account_legend($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/legend";
		
		return "{$url}$path";
	}
	
	public static function new_account_gift($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/gifts";
		
		return "{$url}$path";
	}
	
	public static function new_account_bell($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/bell";
		
		return "{$url}$path";
	}
	
	public static function bell_icon($bell_package) {
		$site_domain = self::_get_domain ();
		if( is_object($bell_package) )
		{
			return "{$site_domain}" . "/img/shopping/iconW{$bell_package->category}.gif";
		}
		return "{$site_domain}" . "/img/shopping/iconW10.gif";
	}
	
	public static function new_account_setting($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/settings";
		
		/*if ($blog !== false) {
            $url = "{$url}/{$blog->blog_id}";
        } */
		
		return "{$url}$path";
	
	}
	
	public static function new_inbox($inbox = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($inbox === false) {
			return "$site_domain/message{$path}";
		}
		
		return "$site_domain/message/{$inbox->message_id}/{$inbox->from_user_id}$path";
	}
	
	public static function new_outbox($outbox = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($outbox === false) {
			return "$site_domain/message{$path}";
		}
		
		return "$site_domain/message/{$outbox->message_id}/{$outbox->to_user_id}$path";
	}
	
	public static function new_draftbox($draft = false, $path = '/') {
		$site_domain = self::_get_domain ();
		
		if ($draft === false) {
			return "$site_domain/message/draft{$path}";
		}
		
		return "$site_domain/message/draft/{$draft->draft_id}$path";
	}
	
	public static function match_help_ppt(){
	    
	    return '/img/ppt/match_help201203_v1.1.ppt';
	}
	
	public static function pay($user, $path = '/'){
	    
		$site_domain = self::_get_domain ();
		
		return "$site_domain/pay{$user->user_id}$path";
	    
	}
	
	public static function group_topic($topic, $path = '/') {
		$site_domain = self::_get_domain ();
		
		$group_id = is_object($topic) ? $topic->group_id : $topic;
		$topic_id = is_object($topic) ? $topic->topic_id : $topic;
		
		return "$site_domain/group/{$group_id}/topic/{$topic_id}$path";
	}

	public static function group_version($group = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/group";
		
		if ($group !== false) {
			if (! is_object ( $group ))
				$url = "{$url}/{$group}";
			else if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] > 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	
	public static function advertising_click($ad = false, $path = '/', $where = 'adclick') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/$where";
		
		if (is_object($ad)){
		    $url = $url . '/?ad_id=' . $ad->player_id . '&type=' . $ad->type . '&from=' . urlencode($ad->url);
		}
		
		return "{$url}";
	}
	
	//--
	
	
	public static function account_blog($path = '/', $blog = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/blog";
		
		if ($blog !== false) {
			$url = "{$url}/{$blog->blog_id}";
		}
		
		return "{$url}$path";
	}
	
	public static function account_gift($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/gifts";
		
		return "{$url}$path";
	}
	
	
	public static function account_setting($path = '/') {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/settings";
		
		/*if ($blog !== false) {
            $url = "{$url}/{$blog->blog_id}";
        } */
		
		return "{$url}$path";
	
	}
	
	public static function follow($follow = false, $path = '/') {
		
		$site_domain = self::_get_domain ();
		
		if ($follow === false) {
			return "$site_domain/follow{$path}";
		}
		
		return "$site_domain/follow/{$follow->follow_user_id}$path";
	}
	
	/**
	 * Enter description here ...
	 * @param unknown_type $friend
	 * @param unknown_type $path
	 * @return string
	 */
	/**
	 * Enter description here ...
	 * @param unknown_type $friend
	 * @param unknown_type $path
	 * @return string
	 */
	public static function friend($friend = false, $path = '/') {
		
		$site_domain = self::_get_domain ();
		
		if ($friend === false) {
			return "$site_domain/friend{$path}";
		}
		
		return "$site_domain/friend/{$friend->userlist_id}$path";
	}
	
	public static function friendlist($userlist = false, $path = '/') {
		
		$site_domain = self::_get_domain ();
		
		if ($userlist === false) {
			return "$site_domain/friend{$path}";
		}
		
		return "$site_domain/friend/{$userlist->userlist_id}$path";
	}
	
	public static function userlist($userlist = false, $path = '/') {
		
		$site_domain = self::_get_domain ();
		
		if ($userlist === false) {
			return "$site_domain/userlist{$path}";
		}
		
		return "$site_domain/userlist/{$userlist->userlist_id}$path";
	}
	
	public static function back($url = false) {
		if ($url)
			return clean_string ( $url );
		if (isset ( $_SERVER ['HTTP_REFERER'] )) {
			$referer = clean_string ( $_SERVER ['HTTP_REFERER'] );
			return $referer;
		}
		return 'javascript:history.back();';
	}
	
	public static function user_image($user_image, $size = '') {
		if (is_object ( $user_image )) {
			$suffix = $user_image->file_type;
			$file_key = $user_image->file_key;
		} else {
			$suffix = 'jpg';
			$file_key = $user_image;
		}
		$site_domain = config_get ( 'site_domain' );
		if ($size == 's')
			$size = '_s';
		return "http://img.$site_domain/$file_key{$size}.$suffix";
	}
	
	public static function _get_domain($schema = true) {
		$site_domain = config_get ( 'site_domain' );
		if($schema) {
			if ($schema === true || !config_get('usehttps'))  
				return "http://www.$site_domain";
			return "{$schema}://www.$site_domain";
		}
		return "www.$site_domain";
	}
	public static function _get_t_domain() {
		$t_domain = config_get ( 't_domain' );
		return "http://$t_domain";
	}
	
	public static function manage_buddyicon($icon_key) {
		if ($icon_key) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico.$host/{$icon_key}.jpg";
		}
		
		return MEDIA_ROOT . '/img/head.gif';
	}

	public static function manage_site( $path = '/' )
	{
		$site_domain = self::_get_domain ();
		return $site_domain . '/manage/site' . $path;
	}
	
	public static function manage_site_custom( $path = '/' )
	{
		$site_domain = self::_get_domain ();
		return $site_domain . '/manage/site/custom' . $path;
	}
	
    public static function channel( $path = '/' )
	{
		$site_domain = self::_get_domain ();
		
		return $site_domain . '/channel/' . $path ;
	}
	
	public static function user_article($user, $article, $position = false/*用于定位到目标页的某个位置*/, $method = false/*用于判断是分享还是评论（分页）*/, $path = '/') {
		$site_domain = self::_get_domain ();
		if (is_object ( $user )) {
			if (preg_match ( '/^[a-zA-Z][a-zA-Z\d-_]+$/', $user->username )) {
				return "$site_domain/channel/{$user->username}/article/$article->article_id{$method}{$path}$position";
			}
			
			return "$site_domain/channel/{$user->user_id}/article/$article->article_id{$method}{$path}$position";
		} else {
			return "$site_domain/channel/unavailable_user/article/unavailable_{$article->article_id}";
		}
	
	}
	
	public static function channel_article($article, $channel, $category = false)
	{
		$site_domain = self::_get_domain ();
		$channel_id = is_object($channel) ? $channel->channel_id : $channel;
		if( $category == false )
		{
			return $site_domain . '/channel/' . $channel_id . "/article/{$article->user_id}-{$article->article_id}/" ;
		}
		return $site_domain . '/channel/' . $channel_id . "/category{$category->category_id}/article/{$article->user_id}-{$article->article_id}/" ;
	}
	
	public static function baidu_app($path = '/') {
	    $baidu_app = 'http://app.baidu.com';
	    return $baidu_app . $path;
	}
	
	public static function account_baidu($path = '/') {
	    $site_domain = self::_get_domain ();
		$url = "$site_domain/account/openapi/baidu";
		return "{$url}$path";
	}
	
	public static function cnfol_app($path = '/') {
	    $cnfol_app = 'http://my.cnfol.com';
	    return $cnfol_app . $path;
	}
	
	public static function account_cnfol($path = '/') {
	    $site_domain = self::_get_domain ();
		$url = "$site_domain/account/openapi/cnfol";
		return "{$url}$path";
	}
	
	/******************* t_0pk start ******************************/
	public static function game_t_0pk($path = '/')
	{
		$site_domain = self::_get_domain ();
		return "$site_domain/game/tzs{$path}";
	}
	public static function game($game, $path = '/')
	{
		$site_domain = self::_get_domain ();
		$game_id = is_object($game) ? $game->game_id : $game;
		return "$site_domain/game/{$game_id}{$path}";
	}
	
	public static function game_tournament($path = '/')
	{
		$site_domain = self::_get_domain ();
		return "$site_domain/game/zbs{$path}";
	}
	public static function game_stockcontest($path = '/')
	{
		$site_domain = self::_get_domain ();
		return "$site_domain/game/jd{$path}";
	}
	/************** group3 ************************/
	public static function account_group3($path = '/', $group = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/account/group";
		
		if ($group !== false) {
			if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		return "{$url}$path";
	}
	public static function group3($group = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/group";
		
		if ($group !== false) {
			if (! is_object ( $group ))
				$url = "{$url}/{$group}";
			else if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] > 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	public static function user_ask($user_ask)
	{
		return self::absolute('/ask/question/' . $user_ask->user_id . '-' . $user_ask->ask_id . '/');
	}
	public static function treasure_box($group, $treasure_box, $path = '/')
	{
		return self::group3($group, '/box/' . $treasure_box->box_id . $path);
	}
	public static function treasure_box2($path = '/', $group_id, $box_id)
	{
		$site_domain = self::_get_domain ();
		
		$url = "$site_domain/group/";
		
		$url .= $group_id . '/box/' . $box_id;
		
		return "{$url}$path";
	}
	public static function group4($group = false, $path = '/', $where = false) {
		$site_domain = self::_get_domain ();
		$url = "$site_domain/group";
		
		if ($group !== false) {
			if (! is_object ( $group ))
				$url = "{$url}/{$group}";
			else if ($group->url_name) {
				$url = "{$url}/{$group->url_name}";
			} else {
				$url = "{$url}/{$group->group_id}";
			}
		}
		
		if ($where !== false) {
			if (array_key_exists ( 'category', $where ) && $where ['category'] > 0) {
				$url = "{$url}/category{$where['category']}";
			}
		}
		
		return "{$url}$path";
	}
	/******************** 视频直播室 ***************************/
	public static function join_webcast($webcast, $user_id)
	{
		_require(DOC_ROOT . '/lib/services/users.php');
		_require(DOC_ROOT . '/lib/services/gensee.php');
		_require(DOC_ROOT . '/lib/services/webcast_users.php');
		$user = mcc_get_user($user_id);
		$webcast_user = mcc_load_webcast_user($webcast, $user_id);
		if( is_object($webcast_user) ){
			switch ($webcast_user->roles)
			{
				case WEBCAST_USER_ROLE_PANELIST:
					$url = $webcast->panelist_join_url . '?nickName=' . urlencode($user->nickname) . '&token=' . $webcast->panelist_token;
					break;
				case WEBCAST_USER_ROLE_ORGANIZER:
					$url = $webcast->panelist_join_url . '?nickName=' . urlencode($user->nickname) . '&token=' . $webcast->organizer_token;
					break;
				case WEBCAST_USER_ROLE_ATTENDEE:
					$url = $webcast->attendee_join_url . '?nickName=' . urlencode($user->nickname) . '&token=' . $webcast->attendee_token . '&trans=true';
					break;
			}
		}
		else{
			$url = $webcast->attendee_join_url . '?nickName=' . urlencode($user->nickname) . '&token=' . $webcast->attendee_token . '&trans=true';
		}
		$url.= '&k=' . mcc_create_gensee_k($webcast->webcast_id, $user_id);
		return $url;
	}
	public static function webcast_vod_play_url($webcast_vod, $user)
	{
		_require(DOC_ROOT . '/lib/services/gensee.php');
		_require(DOC_ROOT . '/lib/services/webcast.php');
		_require(DOC_ROOT . '/lib/services/webcast_users.php');
		_require(DOC_ROOT . '/lib/services/webcast_vods.php');
		$webcast_vod->url.= '?nickName=' . urlencode($user->nickname) . '&token=' . $webcast_vod->password;
		$webcast_vod->url.= '&k=' . mcc_create_gensee_k($webcast_vod->webcast_id . '-' . $webcast_vod->vod_id, $user->user_id, GENSEE_AUTH_TYPE_WEBCAST_VOD) . '&trans=true';
		return $webcast_vod->url;
	}
	public static function webcast($webcast, $path = '/read/')
	{
		$site_domain = self::_get_domain ();
		$webcast_id = is_object($webcast) ? $webcast->webcast_id : $webcast;
		return "$site_domain/webcast/{$webcast_id}{$path}";
	}
	public static function vod($vod, $path = '/')
	{
		$site_domain = self::_get_domain ();
		$vod_id = is_object($vod) ? $vod->vod_id : $vod;
		return "$site_domain/vod/{$vod_id}{$path}";
	}
	
	public static function vodico($vod){
		if( !empty($vod->ico_file_key) ) {
			$host = config_get ( 'mogilefs.domain' );
			return "http://ico." . $host . "/" . $vod->ico_file_key . ".jpg";
		}
		return MEDIA_ROOT . '/img/webcast/mr.gif';
	}
	public static function vod_play_record($vod_record, $user)
	{
		_require(DOC_ROOT . '/lib/services/gensee.php');
		_require(DOC_ROOT . '/lib/services/webcast.php');
		_require(DOC_ROOT . '/lib/services/webcast_users.php');
		_require(DOC_ROOT . '/lib/services/webcast_vods.php');
		$vod_record->url.= '?nickName=' . urlencode($user->nickname) . '&token=' . $vod_record->password;
		$vod_record->url.= '&k=' . mcc_create_gensee_k($vod_record->vod_id . '-' . $vod_record->record_id, $user->user_id, GENSEE_AUTH_TYPE_VOD_RECORD) . '&trans=true';
		return $vod_record->url;
	}
}
?>
