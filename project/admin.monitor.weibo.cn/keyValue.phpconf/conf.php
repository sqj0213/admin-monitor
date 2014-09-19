<?php
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . '../inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../../kernel/inc/checkSession.php');
global $GLOBAL;

$opt = $_REQUEST['opt'];
$typeFlag = $_REQUEST['typeFlag'];



//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里

//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);

if ($opt === "listFlag") {
	//select userkey from test order by id;
    $GLOBAL['modulesInfo']['userKey'] = array(
        'id' => '__ID__',
		'keyName'=> '__KEYNAME__',
        'keyValue'=>'__KEYVALUE__',
		'(select keyName from monitor.keyValue where id=A.pid limit 1)' => '__PKEYNAME__',
        'regTime' => '__REGTIME__'
    );

    $GLOBAL['modulesInfo']['tableName'] = 'monitor.keyValue A';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	$GLOBAL['modulesInfo']['subSql'] = "typeFlag=".$typeFlag;
	
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
	$GLOBAL['htmlDefine']['replaceArray']['__TYPEFLAGLIST__'] = getComboxFromSql( 'pid_上级类别_integer_1_10_0_0', 'select id,keyName as name from monitor.keyValue where pid=0','no',False,$key='"请选择"',$value='0' );
	$GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__TYPEFLAG__' ] = $typeFlag;
	$moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
} else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    $typeFlag= $_REQUEST['typeFlag'];
    $parentTypeFlag= $_REQUEST['parentTypeFlag'];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,keyName, keyValue from monitor.keyValue where id = $id limit 1");

    if ($info != null) {
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__TYPEFLAGLIST__' ] = getComboxFromSql( 'pid_所属分类_integer_1_10_1_1', 'select id,keyName as name from monitor.keyValue where typeFlag='.$parentTypeFlag, $info[ 'id' ],False,$key='请选择',$value='0' );
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__KEYNAME__' ] = $info[ 'keyName' ]; 
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__KEYVALUE__' ] = $info[ 'keyValue' ]; 
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__ID__' ] = $info[ 'id' ];
        $GLOBAL[ 'htmlDefine' ][ 'replaceArray' ][ '__TYPEFLAG__' ] = $typeFlag;
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/keyValue.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'keyValue.php',
        'to_query' => 'opt=listFlag&typeFlag=101&menuID=28',
        'type' => 'reload',
        'info' => '删除类型成功'
    ),
    'opt=addFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'keyValue.php',
        'to_query' => 'opt=listFlag&typeFlag=101&menuID=28',
        'type' => 'reload',
        'info' => '添加类型成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'keyValue.php',
        'to_query' => 'opt=listFlag&typeFlag=101&menuID=28',
        'type' => 'reload',
        'info' => '修改类型成功'
    )
);



?>	