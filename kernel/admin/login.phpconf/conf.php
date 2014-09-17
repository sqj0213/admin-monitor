<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Zhenqiang.du
 * Date: 11-11-8
 * Time: 下午4:08
 */
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . '../../../kernel/inc/global.php');
global $GLOBAL;

$opt = isset( $_REQUEST['opt'] ) ? $_REQUEST['opt']:'login';

if ($opt === "login") {
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
}

$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . 'kernel/admin/login.php'] = array(
    'default' => array(
        'to_path' => BASEURL . '/kernel/modules/mainFrame/systemhome.html',
        'to_query' => 'opt=list',
        'type' => 'reload',
        'info' => '登录成功!'
    )
);
?>