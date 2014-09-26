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
		'username'=> '__USERNAME__',
        'name'=>'__NAME__',
        'email'=>'__EMAIL__',
        'mobile'=>'__MOBILE__',
        'phone'=>'__PHONE__',
        'info'=>'__INFO__',
        'role'=>'__ROLE__',
    );

    $GLOBAL['modulesInfo']['tableName'] = 'monitor.userinfo';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,username, name, email, mobile, phone, info, role from monitor.userinfo where id = $id limit 1");

    if ($info != null) {
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__ID__' ] = $info[ 'id' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__USERNAME__' ] = $info[ 'username' ]; 
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__NAME__' ] = $info[ 'name' ];     
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__EMAIL__' ] = $info[ 'email' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__MOBILE__' ] = $info[ 'mobile' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__PHONE__' ] = $info[ 'phone' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__INFO__' ] = $info[ 'info' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__ROLE__' ] = $info[ 'role' ];
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/userInfo.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'userInfo.php',
        'to_query' => 'opt=listFlag&menuID=28',
        'type' => 'reload',
        'info' => '删除类型成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'userInfo.php',
        'to_query' => 'opt=listFlag&menuID=28',
        'type' => 'reload',
        'info' => '修改类型成功'
    )
);



?>	