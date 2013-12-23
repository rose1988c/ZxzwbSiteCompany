<?php
/*
 * mcc - index.php
 *
 * Created on 2013-4-27 下午12:11:44
 * Created by cyw
 *
 */

function index($page) {
    global $tpl, $auth;
    
    $auth->require_manage();
    
    $per_page = 20;
    
    _require(DOC_ROOT . '/lib/services/users.php');
    $users = mcc_get_users(false, $page, $per_page);

    $tpl->render('manage/index.tpl.php', array(
		'title'               => '在线书签管理平台',
		'manage_left'         => __FUNCTION__,
		'users'               => $users['data'],
		'pager'               => $users['pager'],
		'auth'               => $auth,
        'active' => 'index',
    ), 'manage/layout.tpl.php');
}

function user_urls($page) {
    global $tpl, $auth;

    $auth->require_manage();
    
    $per_page = 20;
    
    _require(DOC_ROOT . '/lib/services/users.php');
    _require(DOC_ROOT . '/lib/services/urls.php');
    $urls = mcc_get_user_urls_lists(false, $page, $per_page);
    
    foreach ($urls['data'] as $url) {
        $user = mcc_get_user($url->user_id);
        $url->user = $user;
    }

    $tpl->render('manage/index/user_urls.tpl.php', array(
		'title'               => '在线书签管理平台',
		'manage_left'         => __FUNCTION__,
		'urls'                => $urls['data'],
		'pager'               => $urls['pager'],
    ), 'manage/layout.tpl.php');
}

