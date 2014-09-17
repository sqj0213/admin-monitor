<?php
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . '../inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../../kernel/inc/checkSession.php');
global $GLOBAL;

$opt = $_REQUEST['opt'];

//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里

//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);

if ($opt === "listFlag") {
	//select userkey from test order by id;
    $GLOBAL['modulesInfo']['userKey'] = array(
        'id' => '__ID__',
		'ip'=> '__IP__',
		'(select keyName from webadmin.keyValue where id=typeID limit 1)' => '__CLUSTERNAME__',
        'regTime' => '__REGTIME__'
    );

    $GLOBAL['modulesInfo']['tableName'] = 'serverList';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	$GLOBAL['modulesInfo']['subSql'] = "";
	
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
	echo "asdfasdf";
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
	$GLOBAL['htmlDefine']['replaceArray']['__CLUSTERLIST__'] = getComboxFromSql( 'typeID_所属集群_integer_1_10_1_1', 'select id,keyName as name from webadmin.keyValue where typeFlag=4', '' );
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
} else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,ip, typeID from serverList where id = $id limit 1");

    if ($info != null) {
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__CLUSTERLIST__' ] = getComboxFromSql( 'typeID_所属集群_integer_1_10_1_1', 'select id,keyName as name from webadmin.keyValue where typeFlag=3', $info[ 'typeID' ] );
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__IP__' ] = $info[ 'ip' ]; 
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__ID__' ] = $info[ 'id' ]; 
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/serverList.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'serverList.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除服务器成功'
    ),
    'opt=addFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'serverList.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '添加服务器成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'serverList.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '修改服务器成功'
    )
);



?>	