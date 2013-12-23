<?php

//该文件为本地配置。发布配置在common.php

ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL | E_STRICT);

$cfg['devmode'] = true;

$cfg['site_domain'] = 'zxzwb.seeker.com';

$cfg['cookie_domain'] = '.' . $cfg['site_domain'];
$cfg['auth_salt']     = 'sdfj2o32#234@1*99832#'; // Pick any random string of characters

// 数据库配置
$cfg['database.host']         = 'localhost';
$cfg['database.db']           = 'zxzwb';
$cfg['database.user']         = 'root';
$cfg['database.password']     = '';
$cfg['database.die_on_error'] = true;

// 全局ID库
$cfg['database.id.host']         = 'localhost';
$cfg['database.id.port']         = 3306;
$cfg['database.id.db']           = 'zxzwb';
$cfg['database.id.user']         = 'root';
$cfg['database.id.password']     = '';
$cfg['database.id.die_on_error'] = true;

$cfg['mogilefs.backend'] = 'mcc.com';
$cfg['mogilefs.domain'] = 'm.com';
$cfg['mogilefs.trackers'] = array('127.0.0.1:7001');

// Session
$cfg['session.name']         = 'mccsid';
$cfg['session.save_handler'] = 'memcached';
$cfg['session.save_path']    = '127.0.0.1:11211';

// Memcached Configurations
$cfg['memcached.enabled'] = false;
$cfg['memcached.conn_id'] = false;
$cfg['memcached.servers'] = array(
array('127.0.0.1', 11211, 33),
);
// searching

$cfg['searching.provider'] = 'solr';
$cfg['solr'] = array(
                    'host' => 'localhost',
                    'port' => 8983,
                    'path' => '/solr/',
);
// quote redis server
    $cfg['redis.quote.host'] = '127.0.0.1';
    $cfg['redis.quote.port'] = 6379;
    $cfg['redis.quote.host.read'] = '127.0.0.1';
    $cfg['redis.quote.port.read'] = 6379;

$cfg['secretary'] = 1;

if (!is_callable('amqp_connection_open')) {
        function amqp_connection_open($host, $port) {
        $connection = new AMQPConnection(array('host' => $host, 'port' => $port, 'login' => 'guest', 'password' => 'guest'));
        $connection->connect();
        return $connection;
        }
    }
    
    if (!is_callable('amqp_login')) {
        function amqp_login() {
        
        }
    }
    
    if (!is_callable('amqp_channel_open')) {
        function amqp_channel_open($conn, $chan) {
        $chan = new AMQPChannel($conn);
    }
    function amqp_channel_popen($conn, $chan) {
        $chan = new AMQPChannel($conn);
        }
    }
    
    if (!is_callable('amqp_basic_publish')) {
        function amqp_basic_publish($conn, $chan, $exchange, $routing_key, $body) {
        $chan = new AMQPChannel($conn);
        $ex = new AMQPExchange($chan);
        $ex->declare($exchange, AMQP_EX_TYPE_DIRECT);
        $ex->publish($body, $routing_key);
    }
}

?>
