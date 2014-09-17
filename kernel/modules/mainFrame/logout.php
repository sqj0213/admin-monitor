<?php
	define('ABS_CUR_DIR_FRAME',	dirname(__FILE__).'/');
	require_once(ABS_CUR_DIR_FRAME.'../../inc/checkSession.php');
	require_once(ABS_CUR_DIR_FRAME.'../../inc/global.php');
	$userID = $_SESSION['userData']['id'];
	$msg = "成功退出系统!";
	$tmpSql = "insert into webadmin.optlog(title, userID,text,ip) values('退出登录',".$_SESSION['userData']['id'].",'".$msg."','".$_SESSION['userData']['ip']."');";

	if ( $GLOBAL['G_DB_OBJ']->executeSql( $tmpSql ) !== 1 )
		$GLOBAL['G_DB_OBJ']->writeLog( $GLOBAL['G_DB_OBJ']->errLog, "f=".__FILE__."\tl=".__LINE__."\tinfo(退出登录错误,loginame=".$_SESSION['userData']['loginame'].",".$tmpSql.")" );

	session_destroy();
	echo getWebLocationScript( $GLOBAL['serverInfo']['errorUrl'], "成功退出系统!", "parent" );
		
?>