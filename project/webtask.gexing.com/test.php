<?php
/**
 * Created by Zend Studio
 * User: chunlei
 * Date: 12-03-26
 * Time: 上午10:10
 */

//本文件所在路径
//define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');

require_once("./test.phpconf/conf.php");
require_once($moduleShowtmpl);
//包含文件
/*require_once(ABS_CUR_LOGIN_DIR . '/inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../kernel/inc/checkSession.php');
global $GLOBAL;


$adminId = $appConf["AdminID"]["id"];
$siteId = $GLOBAL['runData']['userData']['siteID'];
if ( $GLOBAL['runData']['userData']['influenceID'] === -1 )
	$siteId = $adminId;
//$siteId = 1;
if ($siteId != $adminId) {
    $isAdmin = false;
    if (!isset($siteId) || (intval($siteId) == 0)) {
        echo "<script type='text/javascript'>";
        echo "alert(\"非法访问！\");";
        echo "window.location='/login.php';";
        echo "</script>";
    }
} else $isAdmin = true;

$opt = $_REQUEST['opt'];

//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里
$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);

if ($opt === "listFlag") {
	//select userkey from test order by id;
    $GLOBAL['modulesInfo']['userKey'] = array(
        'id' => '__ID__',
        'username'=>'__USERNAME__',
        'password' => '__PASSWORD__',
    );

    $GLOBAL['modulesInfo']['tableName'] = 'test';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	$GLOBAL['modulesInfo']['subSql'] = "";
	
    require_once(ABS_CUR_LOGIN_DIR . "../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	require_once($moduleShowtmpl);
	
} else if ($opt === "addFlag") {

    require_once(ABS_CUR_LOGIN_DIR . "../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	require_once($moduleShowtmpl);
	
} else if ($opt === "editFlag") {

    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id, username,password from test where id = $id");

    if ($info != null) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
            '__ID__' => $id,
            '__USERNAME__' => $info["username"],
            '__PASSWORD__' =>$info["password"]
        ));
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/test.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'test.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除用户成功'
    ),
    'opt=addFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'test.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '添加用户成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'test.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '修改用户成功'
    )
);
*/
?>