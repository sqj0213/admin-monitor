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
        'cmdSN'=>'__CMDSN__',
        '(select keyName from webadmin.keyValue where id=cmdKeyID limit 1)' => '__CMDKEY__',
        '(case cmdType when \'0\' then \'手动\' when \'1\' then \'api\' end)' => '__CMDTYPE__',
        'cmdPara' => '__CMDPARA__',
		'cmdStr'=>'__CMDSTR__',
//        'sendTime' => '__SENDTIME__',
        'completeTime' => '__COMPLETETIME__',
        '(case sendStatus when \'-1\' then \'有异常\' when \'0\' then \'未发送\' when \'1\' then \'已发送\' end)' => '__SENDSTATUS__',

        '(case runStatus when \'-1\' then \'全部失败\' when \'-1\' then \'有异常\' when \'0\' then \'等待运行\' when \'1\' then \'全部成功\' end)'=> '__RUNSTATUS__',
        'regTime' => '__SENDTIME__'
    );

    $GLOBAL['modulesInfo']['tableName'] = 'cmd';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	$GLOBAL['modulesInfo']['subSql'] = "";
	//print_r( $GLOBAL );
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $GLOBAL['htmlDefine']['replaceArray']['__CMDSN__'] = time();
    $GLOBAL['htmlDefine']['replaceArray']['__KEYLIST__'] = getComboxFromSql( 'cmdKeyID_指令集_integer_1_10_1_1', 'select id,keyName as name from webadmin.keyValue where typeFlag=3', '' );
    $GLOBAL['htmlDefine']['replaceArray']['__CMDTARGET__'] = getComboxFromSql( 'cmdTargetID_指令集群_integer_1_10_1_1', 'select id,keyName as name from webadmin.keyValue where typeFlag=4', '' );
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
} else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id, username,password from test where id = $id");

    if ($info != null) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
            '__ID__' => $id,
            '__USERNAME__' => $info["username"],
            '__PASSWORD__' =>$info["password"]
        ));
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
} else if ($opt === "sendFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名

	$id =  $_REQUEST[ 'id' ];
	$para = $GLOBAL['G_DB_OBJ']->executeSql( 'select sendStatus, cmdSN,cmdPara from cmd where id='.$id ) ;


	if ( $para['sendStatus'] == 1 )
	{
		//echo getHistoryBackScript("指令已经发送,不能重复发送!");
		//exit;
	}

	$cmd = $GLOBAL['G_DB_OBJ']->getFieldValue( 'select value from webadmin.keyValue a, cmd b where a.id=b.cmdKeyID and b.id='.$id );
	$targetIPList = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select ip from serverList a, cmd b  where a.typeID = b.cmdTargetID and  b.id='.$id);

	$GLOBAL['G_DB_OBJ']->executeSql( "update cmd set sendTime=now(),sendStatus='1' where id=".$id ) ;
	$sendCMDObj = new sendCMD( );

	$sendCMDObj->init( $para['cmdSN'], $cmd, $targetIPList, explode( "\n", $para['cmdPara'] ), $GLOBAL['G_DB_OBJ'], $appConf );
	$sendCMDObj->sendCMD();
    echo getWebLocationScript( '/taskManage.php?flag=1&opt=listFlag&menuID=188', '任务发送成功，请等待执行!' );	
	exit;
//    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
//    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
}
//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/taskManage.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除任务成功'
    ),
    'opt=addFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '添加任务成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '修改任务成功'
    )
);



?>	