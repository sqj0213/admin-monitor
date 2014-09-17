<?php
define( 'NOT_CHECK_SESSION', true );
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . '../inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../../kernel/inc/checkSession.php');
global $GLOBAL;

$opt = $_REQUEST['opt'];

//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里
//http://webtask.gexing.com/api.php?opt=clearCache&from=customer&timestamp=12345665&param=shaitu/20121107/1620/509a19d76a2c7_197x146_1.jpg&sign=0123456789
//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);
 if ($opt === "clearCache") {
        //静态页面中需要注意，input框的name属性需要按照规则命名
        $opt =$_REQUEST['opt'];
        $from = $_REQUEST['from'];
        $timestamp = $_REQUEST['timestamkp'];
        $cmdParam = $_REQUEST['param'];
        $sign =$_REQUEST['sign'];
        if ( $sign != '0123456789' )
         {
                echo json_encode( array('retCode'=>-1, 'retMsg'=>'signature is invalid!', 'retData'=>$sign) );
                exit;
         }
        $cmdSN = time();
                $sqlStr = "insert into webtask.cmd ( cmdSN, cmdKeyID,cmdTargetID,cmdPara,sendStatus,cmdType) values('".$cmdSN."','43','45','".$cmdParam."','1','1')";
                $GLOBAL['G_DB_OBJ']->executeSql( $sqlStr );

                $id =  $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from cmd where cmdSN='".$cmdSN."' limit 1");
                $para = $GLOBAL['G_DB_OBJ']->executeSql( 'select sendStatus, cmdSN,cmdPara from cmd where id='.$id ) ;

                $cmd = $GLOBAL['G_DB_OBJ']->getFieldValue( 'select value from webadmin.keyValue a, cmd b where a.id=b.cmdKeyID and b.id='.$id );
                $targetIPList = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select ip from serverList a, cmd b  where a.typeID = b.cmdTargetID and  b.id='.$id);

                //$GLOBAL['G_DB_OBJ']->executeSql( "update cmd set sendTime=now(),sendStatus='1' where id=".$id ) ;
                $sendCMDObj = new sendCMD( );

                $sendCMDObj->init( $para['cmdSN'], $cmd, $targetIPList, explode( "\n", $para['cmdPara'] ), $GLOBAL['G_DB_OBJ'], $appConf );
                $sendCMDObj->sendCMD();


                $cmdSN = $cmdSN+1;

                $sqlStr = "insert into webtask.cmd ( cmdSN, cmdKeyID,cmdTargetID,cmdPara,sendStatus,cmdType) values('".$cmdSN."','47','46','".$cmdParam."','1','1')";
                $GLOBAL['G_DB_OBJ']->executeSql( $sqlStr );


                $id =  $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from cmd where cmdSN='".$cmdSN."' limit 1");
                $para = $GLOBAL['G_DB_OBJ']->executeSql( 'select sendStatus, cmdSN,cmdPara from cmd where id='.$id ) ;

                $cmd = $GLOBAL['G_DB_OBJ']->getFieldValue( 'select value from webadmin.keyValue a, cmd b where a.id=b.cmdKeyID and b.id='.$id );
                $targetIPList = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select ip from serverList a, cmd b  where a.typeID = b.cmdTargetID and  b.id='.$id);

                //$GLOBAL['G_DB_OBJ']->executeSql( "update cmd set sendTime=now(),sendStatus='1' where id=".$id ) ;
                $sendCMDObj = new sendCMD( );

                $sendCMDObj->init( $para['cmdSN'], $cmd, $targetIPList, explode( "\n", $para['cmdPara'] ), $GLOBAL['G_DB_OBJ'], $appConf );
                $sendCMDObj->sendCMD();



        echo json_encode( array('retCode'=>1, 'retMsg'=>'success', 'retData'=>'') );
        exit;
//    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
//    $moduleShowtmpl = loadModules("webPage", $errMsg);
        //require_once($moduleShowtmpl);
}



?>