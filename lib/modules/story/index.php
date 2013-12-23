<?php
/**
 * 首页
 */
function index(){
    global $tpl;
    
    $tpl->render('story/index.tpl.php', array (
        'title' => '品牌故事',
        'nav' => 'story'
    ), 'layout.tpl.php');
}

