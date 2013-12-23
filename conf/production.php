<?php
    //发布后配置
	ini_set('display_errors', '1');  // 不显示任何错误
	ini_set('error_reporting', E_ALL | E_STRICT);

    // 域名
    $cfg['site_domain']= $cfg['deploy_hostsname'] . $cfg['deploy_hostsname_end'];

    $cfg['auth_salt']     = 'sdfj2o32#234@1*99832#'; 
    $cfg['cookie_domain'] = '.' . $cfg['site_domain'];

    // 数据库配置
    $cfg['database.host']         = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
    $cfg['database.port']         = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
    $cfg['database.db']           = 'VPvQcWeuxXMKBZYrOrxg';
    $cfg['database.user']         = getenv('HTTP_BAE_ENV_AK');
    $cfg['database.password']     = getenv('HTTP_BAE_ENV_SK');
    $cfg['database.die_on_error'] = false;

    // 全局ID库
    $cfg['database.id.host']         = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
    $cfg['database.id.port']         = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
    $cfg['database.id.db']           = 'VPvQcWeuxXMKBZYrOrxg';
    $cfg['database.id.user']         = getenv('HTTP_BAE_ENV_AK');
    $cfg['database.id.password']     = getenv('HTTP_BAE_ENV_SK');
    $cfg['database.id.die_on_error'] = false;

    // Session
    $cfg['session.save_path'] = '192.168.100.90:11212';
    
    // Cache configurations

    // Memcached Configurations
    $cfg['memcached.servers'] = array(
            array('192.168.100.90', 11213),
            /*
            array('192.168.0.5',  10001),
            array('192.168.0.11', 10001),
            array('192.168.0.80', 10001),
            array('192.168.0.51', 10001),
            array('192.168.0.52', 10001),
            array('192.168.0.53', 10001),
            array('192.168.0.54', 10001),
            array('192.168.0.55', 10001),
            */
        );
    $cfg['mogilefs.domain'] = '7878.com';
    $cfg['mogilefs.backend'] = 'mcc.com';
    $cfg['mogilefs.trackers'] = array('192.168.120.150:7001');

    // Message Queue
    $cfg['amqp.host']  = '192.168.100.100';

    $cfg['solr'] = array(
                    'hostname' => '192.168.100.70',
                    'port' => 8983,
                    'path' => '/solr/',
                );
	$cfg['secretary'] = 7878;
?>
