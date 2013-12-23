<?php
$urls = array(
        '^/about/?$' => array(
            'module' => 'account/index.php',
            'function'  => 'about',
		),
        '^/join/?$' => array(
            'module' => 'account/index.php',
            'function'  => 'account_join',
		),
        '^/login/?$' => array(
            'module' => 'account/index.php',
            'function'  => 'account_login',
		),
        '^/mlogin/?$' => array(
            'module' => 'account/index.php',
            'function'  => 'account_mlogin',
		),
        '^/account/logout/?$' => array(
            'module'    => 'account/index.php',
            'function'  => 'account_logout'
        ),
		/*------------------------ ajax -------------------------*/
        '^/account/user_exists/?$' => array(
            'module' => 'account/account.php',
            'function'  => 'ajax_user_exists',
		),
        '^/account/nickname_exists/?$' => array(
            'module'    => 'account2/account.php',
            'function'  => 'ajax_nickname_exists'
        ),
);
?>
