<?php
    //mcc配置

    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL | E_STRICT);

    $cfg['devmode'] = true;
    $cfg['site_domain'] = '61.164.97.3';
    $cfg['cookie_domain'] = '.' . $cfg['site_domain'];
    $cfg['auth_salt']     = 'sdfj2o32#234@1*99832#';
    

    // 数据库配置
    $cfg['database.host']         = 'localhost';
    $cfg['database.db']           = 'mcc_cluster';
    $cfg['database.user']         = 'root';
    $cfg['database.password']     = '';
    $cfg['database.die_on_error'] = true;
    
    // 全局ID库
    $cfg['database.id.host']         = 'localhost';
    $cfg['database.id.port']         = 3306;
    $cfg['database.id.db']           = 'mcc_cluster_id';
    $cfg['database.id.user']         = 'root';
    $cfg['database.id.password']     = '';
    $cfg['database.id.die_on_error'] = true;
    
    // searching
    $cfg['searching.provider'] = 'solr';
    $cfg['solr'] = array(
                    'host' => 'localhost',
                    'port' => 8983,
                    'path' => '/solr/',
                );
                
    $cfg['secretary'] = 1;
    
?>
