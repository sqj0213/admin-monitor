<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Zhenqiang.du
 * Date: 11-11-16
 * Time: 下午1:01
 */
set_time_limit(0);
header('Content-type: text/html;charset=utf-8');
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . 'inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../kernel/inc/global.php');
global $GLOBAL;

print_r( $GLOBAL['G_DB_OBJ'] );
?> 