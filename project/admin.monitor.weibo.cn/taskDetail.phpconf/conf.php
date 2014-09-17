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
//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);

if ($opt === "listFlag") {
	//select userkey from test order by id;
    $GLOBAL['modulesInfo']['userKey'] = array(
        'id' => '__ID__',
        'ip' => '__IP__',
        'cmdSN'=>'__CMDSN__',
        'cmdStr' => '__CMDSTR__',
        'ip' => '__IP__',
        '(case sendStatus when \'0\' then \'未发送\' when \'1\' then \'已发送\' end)' => '__SENDSTATUS__',
        '(case retCode when \'-1\' then \'失败\' when \'1\' then \'成功\' when \'0\' then \'未执行\' end)' => '__RUNSTATUS__',
        'sendTime' => '__SENDTIME__',
        'runTime' => '__RUNTIME__',
        'retMsg' => '__RETMSG__',
        'retData' => '__RETDATA__',
    );

    $GLOBAL['modulesInfo']['tableName'] = 'CMDDetail';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id';
	$GLOBAL['modulesInfo']['subSql'] = "";
	
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/taskDetail.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskDetail.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除任务明细成功'
    )
);



?>	
