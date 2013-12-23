<?php
// define('SHARKY_ROOT', $_SERVER['SHARKY_ROOT']);
define('DOC_ROOT', realpath(dirname(__FILE__) . '/../'));

// 设置核心库路径
define('SHARKY_ROOT', DOC_ROOT . '/sharky');

// 设置缓存路径
define('CACHE_DIR', DOC_ROOT . '/cache');

define('OPTIMIZE_REQUIRE_DIR', false);

// Global include files
require SHARKY_ROOT . '/lib/functions.inc.php'; // __autoload() is contained in this file
                                                
// 加载整个目录里的所有php文件 
// 如果设置了OPTIMIZE_REQUIRE_DIR 目录里所有php文件会被合并成一个文件, 放进CACHE_DIR, 然后在加载.
require_path(SHARKY_ROOT . '/lib/core', array (
    'config.php',
    'database.php',
    'pager.php',
    'dbobject.php',
    'sharding.php',
    'cache.php',
    'dispatcher.php',
    'template.php',
    'form.php',
    'message.php',
    'auth.php' 
));

// global functions/variables
_require(DOC_ROOT . '/lib/common.inc.php'); 

// 设置INCLUDE_PATH
add_include_path(DOC_ROOT . '/lib');
add_include_path(DOC_ROOT . '/lib/helpers');
add_include_path(DOC_ROOT . '/lib/library');
add_include_path(SHARKY_ROOT . '/lib');

// $_REQUEST里包含Cookie值，去掉先
foreach ( $_REQUEST as $key => $value ) {
    if (! isset($_GET [$key]) && ! isset($_POST [$key]))
        unset($_REQUEST [$key]);
}

// Fix magic quotes
if (get_magic_quotes_gpc()) {
    $_POST = fix_slashes($_POST);
    $_GET = fix_slashes($_GET);
    $_REQUEST = fix_slashes($_REQUEST);
    $_COOKIE = fix_slashes($_COOKIE);
}

// Set default text encoding
mb_internal_encoding('UTF-8');

// Setup Session
session_start();

// Initialize cache
cache_init();

// Object for tracking and displaying error messages
$msg = Message::get_instance();

// Initialize current user
$auth = Auth::get_instance();

$html = new Html();

define('WEB_ROOT', config_get('web_root'));
define('MEDIA_ROOT', config_get('media_root'));

// Initialize template
$tpl = new Template();
// Set global template variables
//$tpl->set('auth', $auth);
$tpl->set('html', $html);
$tpl->set('msg', $msg);
$tpl->set('web_root', WEB_ROOT);
$tpl->set('media_root', MEDIA_ROOT);
?>