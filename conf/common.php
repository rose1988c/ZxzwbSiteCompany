<?php
    $cfg['devmode'] = true;
    $cfg['web_root'] = '';
    $cfg['media_root'] = ''; 

    $cfg['deploy_hostsname']     = 'zxzwb';
    $cfg['deploy_hostsname_end'] = '.com';
    
    // 各个环境的域名，以便选择不同的配置文件
    $cfg['hosts.production'] = '/.*' . $cfg['deploy_hostsname'] . '\.com/';
    $cfg['hosts.staging']    = '/.*\.mcc\.com/';
    $cfg['hosts.local']      = '/zxzwb.*\.seeker\.com/';
 
    // 域名
    $cfg['site_domain'] = $cfg['deploy_hostsname'] . '.com';
     
    // 数据库配置
	$cfg['database.host']         = 'localhost';
	$cfg['database.port']         = 3306;
	$cfg['database.db']           = 'mcc_cluster';
	$cfg['database.user']         = 'root';
	$cfg['database.password']     = 'lovetwins';
	$cfg['database.die_on_error'] = true; 

    // 全局ID库
	$cfg['database.id.host']         = 'localhost';
	$cfg['database.id.port']         = 3306;
	$cfg['database.id.db']           = 'mcc_cluster_id';
	$cfg['database.id.user']         = 'root';
	$cfg['database.id.password']     = '';
	$cfg['database.id.die_on_error'] = true;

    // Settings for the Auth class
    $cfg['cookie_domain'] = '.' . $cfg['site_domain'];
    $cfg['auth_salt']     = 'qr48)DF"4&%3789ah4324&Y*Gd34OJF*#$x)'; // Pick any random string of characters

    // Session
    $cfg['session.name']         = 'mccsid';
    $cfg['session.save_handler'] = 'memcached';
    $cfg['session.save_path']    = '127.0.0.1:11211';

    // Cache configurations
    $cfg['cache.enabled'] = true;

    // Memcached Configurations
    $cfg['memcached.enabled'] = true;
    $cfg['memcached.conn_id'] = false;
    $cfg['memcached.servers'] = array(
            array('127.0.0.1', 11211, 33),
        );

    // 临时目录
    $cfg['tmp_dir'] = '/tmp';

    ini_set ('session.save_path' , dirname ( __FILE__ ) . '/../tmp/' ) ;

    // 文件存储
    $cfg['filestore.backend'] = 'webdav';
    $cfg['filestore.domain']  = '7878.com';
	
	$cfg['image.max_width'] = 5000;
	$cfg['image.max_height'] = 5000;
	

    // Message Queue
    $cfg['amqp.host']  = '127.0.0.1';
    $cfg['amqp.port']  = 5672;
    $cfg['amqp.user']  = 'guest';
    $cfg['amqp.pass']  = 'guest';
    $cfg['amqp.vhost'] = '/';
    
    // quote redis server
    $cfg['redis.quote.host'] = '192.168.100.80';
    $cfg['redis.quote.port'] = 6000;
    $cfg['redis.quote.host.read'] = '192.168.100.80';
    $cfg['redis.quote.port.read'] = 6000;
    
    // new system redis server
    $cfg['redis.system.host'] = 'localhost';
    $cfg['redis.system.port'] = 6379;
    $cfg['redis.system.host.read'] = 'localhost';
    $cfg['redis.system.port.read'] = 6379;
    
    //weixin
    $cfg['weixin.account'] = '349252963@qq.com';
    $cfg['weixin.password'] = 'lovetwins';
    $cfg['weixin.cookiePath'] = DOC_ROOT . '/cache/cookie';
    $cfg['weixin.webTokenPath'] = DOC_ROOT . '/cache/webToken';
    
    // searching
    //$cfg['searching.provider'] = false;
    $cfg['solr'] = array(
                    'host' => 'localhost',
                    'port' => 8983,
                    'path' => '/solr/',
                );
?>
