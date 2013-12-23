<?php
/**
 * client.php
 * 客户端 - 发送信息
 * 
 * @author: Cyw
 * @email: chenyunwen01@bianfeng.com
 * @created: 2013-11-5
 * @logs: 
 * 
 */
require('weixin.class.php');

function send(){
    global $tpl, $msg;
    
    $id = param_int($_GET, 'id', false);
    $content = param_string($_GET, 'content', false, false);
    
    if($id && $content) {
        $weixin_client = new weixin_client();
        $backmsg = $weixin_client->send($id, $content);
        
        if ($backmsg->ret == 0 && $backmsg->msg == 'ok') {
            $msg->add_message($backmsg->msg);
        }
    }
    
    $tpl->render('weixin/send.tpl.php', array (
        'title' => '微信发送页',
        'site_nav' => 'send',
    ), 'layout.tpl.php');
}

function info(){
    global $tpl;

    $wxcurl = new weixinCurl();

    $group = $wxcurl->getGroup();

    $groupMermber = array();

    foreach ( $group as $k => $v ) {
        $groupMermber[] = $wxcurl->getFriendByGroup($k);
    }

    $groupMermber = array_filter($groupMermber);

    $tpl->render('weixin/info.tpl.php', array (
        'title' => '微信信息页',
        'groupMermber' => $groupMermber,
    ), 'layout.tpl.php');
}

function test(){
    $weixin_client = new weixin_client();
    $fakeId = $weixin_client->getLatestMsgByCreateTimeAndContent(1383627499, 'id@hyvgii');
    $contentStr = '你的id:' . $fakeId['fakeid'];
    
    echo "<pre>";
    print_r($contentStr);
    echo "<pre>";
    die();
}
