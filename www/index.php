<?php
$time_start = microtime(true);
function log_time($str = '')
{
    global $time_start;
    echo '<!-- ' . (microtime(true) - $time_start) . ' seconds: ' . $str . ' -->' . "\n";
}

// 这是所有请求的入口
require 'lib/bootstrap.inc.php';

$uri = strtolower($_SERVER ['REQUEST_URI']);
if ($_SERVER ['REQUEST_METHOD'] == 'GET' && empty($_SERVER ['QUERY_STRING']) && (rtrim($uri, '/') == $uri)) {
    $_SERVER ['REQUEST_URI'] = $uri . '/';
    redirect(full_request_url(), true);
}

// 类似Django的URL映射机制，访问最频繁的放最前面
$urls = array (
    'case/' => array (
        'include' => 'case/urls.php' 
    ),
    'about/' => array (
        'include' => 'about/urls.php' 
    ),
    'story/' => array (
        'include' => 'story/urls.php' 
    ),
    #'manage/' => array (
    #    'include' => 'manage/urls.php' 
    #),
    '^/join|login|mlogin|account|about/' => array (
        'include' => 'account/urls.php'
    ),
    '/?$' => array (
        'module' => 'index.php',
        'function' => 'index' 
    ),
);

log_time();
$dipatcher = new Dispatcher($urls);
$dipatcher->dispatch($uri);
?>