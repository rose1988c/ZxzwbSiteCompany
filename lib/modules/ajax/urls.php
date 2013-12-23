<?php
$urls = array(
        '^/ajax/global/menuinfo/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'menuinfo',
		),
        '^/ajax/global/groupinfo/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'groupinfo',
		),
        '^/ajax/global/group_join_info/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'group_join_info',
		),
        '^/ajax/global/getrelation/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'get_relation',
		),
        '^/ajax/global/ajax_newsflash_everyday/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'ajax_newsflash_everyday',
		),
        '^/ajax/global/ajax_newsflash/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'ajax_newsflash',
		),
        '^/ajax/global/ajax_set_briefnews_cookie/?$' => array(
            'module'    => 'ajax/global.php',
            'function'  => 'ajax_set_briefnews_cookie',
		)
	);
?>
