<?php
/**
 * 首页
 */
function index(){
    global $tpl;
    
    $tpl->render('about/index.tpl.php', array (
        'title' => '关于',
        'nav' => 'about'
    ), 'layout.tpl.php');
}

