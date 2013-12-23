<?php
/*
 * mcc - sitemap.php
 * 
 * Created on Sep 5, 2011 1:37:16 PM
 * Created by bill
 * 
 */

_require (DOC_ROOT . '/lib/services/users.php');
_require (DOC_ROOT . '/lib/services/blog.php');

function sitemap() {
	global $tpl, $sitemap_renderers;
	
	header('Content-Type:text/xml;charset=utf-8;');
	
	$type = trim(param_string($_GET, 'type', false, 'blog'));
	
	//$time_start must be a date format
	$time_start = trim(param_string($_GET, 'start', false, false));
	$time_start = __format_date($time_start);

	//$time_end must be a date format
	$time_end = trim(param_string($_GET, 'end', false, false));
	$time_end = __format_date($time_end);
	
	if (!isset($actionlog_renderers)) {
        $sitemap_renderers = array(
                					'blog'  => '_render_sitemap_blog'
                             );
	}
	$maps = array();
	if(array_key_exists($type, $sitemap_renderers)) {
        $maps = call_user_func($sitemap_renderers[$type], $time_start, $time_end);
	}
	
	$tpl->render('sitemap.tpl.php', array('maps' => $maps), false);
}

/**
 * 
 * 从solr里搜索博文数据
 * @param unknown_type $time_start 开始时间
 * @param unknown_type $time_end 结束时间
 */
function _render_sitemap_blog($time_start = false, $time_end = false) {
    global $ShardingNodes, $UserBlogs;
    
	$per_page = 1000;//总条数
	$nodes = $ShardingNodes->fetch ( array ('order_by' => 'shard_id asc' ) );//分库节点集合
	$avg_page = $per_page / (count($nodes));//每个分库取的数据条数
	
	if($time_start !== false && stripos($time_start, '-') !== false) {
	    $time_start = strtotime($time_start);
	    if($time_end && stripos($time_end, '-') !== false) {
            $time_end = strtotime($time_end);
	    } else {
	        $time_end = $time_start + 60*60;
	    }
	} else {
	    if(!$time_end) {
    	    $time_start = time() - 60*60;
    	    $time_end = time();
	    } else {
	        $time_start = 0;
	        $time_end = strtotime($time_end);
	    }
	}
	
	$query = array ( 'order_by' => 'posted_at desc', 'blog_status' => BLOG_STATUS_RELEASE, 'page' => false, 'per_page' => $avg_page );
	$query['changed_at__gte'] = $time_start;
    $query['changed_at__lte'] = $time_end;
	
	$result = array();
	foreach ($nodes as $node) {
    	$db = Shards::get_node ( $node->shard_id );
    	if ($db) {
    		$UserBlogs->reset_cache_revision ( $query, $db );
    		$data = $UserBlogs->db_fetch ( $db, $query );
    		
    		//因为每个分库里的数据都不同，所以不会重复，因此用array_merge()
    		$result = array_merge($result, $data);
	    }
	}
    $blogs = array ();
	if(count($result) > 0) {
    	foreach ( $result as $r ) {
    		try {
    			$user = mcc_get_user_by_id($r->user_id);
    			if(!$user) {
    			    continue;
    			}
    			$blogs[] = array('loc' => urls::user_blog($user,$r->blog_id));
    		} catch ( Exception $e ) {
    		}
    	}
	    $blogs = array_filter ( $blogs );
	}
	
	return $blogs;
}

function __format_date($time) {
    
    $format_time = '';
    if(is_numeric($time) && strlength($time) == 10) {
        $year = utf8_substr($time, 0, 4);
        $month = utf8_substr($time, 4, 2);
        $day = utf8_substr($time, 6, 2);
        $hour = utf8_substr($time, 8, 2);
        
        $format_time = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00';
    }
    
    return $format_time;
}
?>
