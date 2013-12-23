<?php
$urls = array(
	    '^/manage/(?<action>login|logout|changepass)/?$' => array(
            'module'    => 'manage/manage.php',
            'function'  => 'dispatcher_action_route',
            'arguments' => array('action'),
		),
        '^/manage(/page(?<page>\d+))?/?$' => array(
                'module' => 'manage/index.php',
                'function'  => 'index',
                'arguments' => array ('page' ),
                'defaults' => array ('page' => 1 )
        ),
        /* USER */
        '^/manage/user|users/' => array(
                'include'   => 'manage/user/urls.php',
        ),
        /* URL */
        '^/manage/urls/' => array(
                 'include'   => 'manage/url/urls.php',
		),
        /* TAG  */
        '^/manage/tag|tags/' => array(
                'include'   => 'manage/tag/urls.php',
        ),
        /* TAG BUNDLES */
        '^/manage/bundles|tag_bundles/' => array(
                'include'   => 'manage/tag_bundles/urls.php',
        ),

);
?>
