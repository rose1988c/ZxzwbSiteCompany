<?php
global $tpl;

if (!isset($error_code))
$error_code = 500;

$tpl->set('error_code', $error_code);
$tpl->set('error_message', $error_message);

if($error instanceof ManagePermissionException) {
    $tpl->render('manage/forbidden.tpl.php', array('title' => '抱歉，您无权访问'), 'manage/layout.tpl.php');
    
} else {
	switch ($error_code)
	{
	    case 404:
	        $tpl->set('title', '页面未找到');
	        $tpl->render('404.tpl.php', null, false);
	        break;
	    case 403:
	    	$tpl->set('title', $error_message);
	    	$tpl->render('403.tpl.php');
	    	break;
	    default:
	        $tpl->set('title', '哦哦,服务器好像出错了,刷新下看看？');
	        $tpl->render('error.tpl.php');
	}
}
?>
