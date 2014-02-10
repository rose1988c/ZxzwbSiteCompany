<?php
function index()
{
    global $auth, $tpl;
    
    if ($_SERVER ['REQUEST_URI'] != '/') {
        throw new Exception('页面未找到', 404);
    }
    
    $tpl->render('index.tpl.php', array (
        'title' => '首页' 
    ), 'layout.tpl.php');
}
?>
