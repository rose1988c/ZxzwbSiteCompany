<?php
/**
 * 首页
 */
function index(){
    global $tpl;
    
    $tpl->render('case/index.tpl.php', array (
        'title' => '作品案例',
        'nav' => 'case'
    ), 'layout.tpl.php');
}

