<?php
$urls = array (
    '^/api/weixin/?$' => array (
        'module' => 'api/weixin/index.php',
        'function' => 'index' 
    ),
    '^/api/weixin/valid/?$' => array (
        'module' => 'api/weixin/index.php',
        'function' => 'valid' 
    ),
//     获取微信的信息
//     '^/api/weixin/(?<action>info|send|send_group|group|get_group_member|get_new|get_msg)/?$' => array(
//         'module' => 'api/weixin/client.php',
//         'function'  => 'dispatcher_action_route',
//         'arguments' => array('action'),
//     ),
//     function dispatcher_action_prefix()
//     {
//         return 'client_';
//     }
    //信息
    '^/api/weixin/info/?$' => array (
        'module' => 'api/weixin/client.php',
        'function' => 'info'
    ),
    //发送
    '^/api/weixin/send/?$' => array (
        'module' => 'api/weixin/client.php',
        'function' => 'send'
    ),
    //测试
    '^/api/weixin/test/?$' => array (
        'module' => 'api/weixin/client.php',
        'function' => 'test'
    ),
    
);
?>
