<?php
require('weixin.class.php');

/**
 * 首页
 */
function index(){
    global $tpl;
    
    $tpl->render('weixin/index.tpl.php', array (
        'title' => '微信首页'
    ), 'layout.tpl.php');
}

/**
 * 验证接入腾讯微信
 */
function valid(){
    $weixin = new weixin();
    if (isset($_GET ["echostr"])){
        $weixin->valid();
    } else {
        $weixin->responseMsg();
    }
}

