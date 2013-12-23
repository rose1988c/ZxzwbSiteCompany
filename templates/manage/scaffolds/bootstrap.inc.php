<?php
    //定义Title
    $site_title = '在线书签';
    
    //规避 单一的分页 title
    $pager_title = '';
    if(isset($pager) && is_object($pager) && $pager->page > 1) {
        $pager_title = "_第{$pager->page}页";
    }
    if (isset($head_title)) {
        if($_SERVER["SCRIPT_NAME"] != '/index.php'){
            $titleseo = $head_title . $pager_title . ' - ' . $site_title;
        }else{
            $titleseo = $head_title . $pager_title;
        }
    } else {
        $titleseo = !empty($title) ? ($title . $pager_title . ' - ') : '';
        $titleseo = browser_is_search_engine() ? ($titleseo  . $site_title) : ($titleseo . $site_title );
    }
    $titleseo = strip_tags_attributes($titleseo);
    
    //SEO
    $head_description = isset($head_description) ? $head_description : $site_title;
    $head_keywords    = isset($head_keywords) ? $head_keywords : $site_title;
    $robots = isset($robots) ? $robots : 'all';
    
    
    
    