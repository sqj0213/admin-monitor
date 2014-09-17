<?php
define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/admin/login.phpconf/conf.php' );

$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/login.php'] = array(
    'default' => array(
        'to_path' => '/systemhome.html',
        'to_query' => '',
        'type' => 'reload',
        'info' => '登录成功!'
    )
);
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/'] = array(
    'default' => array(
        'to_path' => '/systemhome.html',
        'to_query' => '',
        'type' => 'reload',
        'info' => '登录成功!'
    )
);
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH ] = array(
    'default' => array(
        'to_path' => '/systemhome.html',
        'to_query' => '',
        'type' => 'reload',
        'info' => '登录成功!'
    )
);
?>