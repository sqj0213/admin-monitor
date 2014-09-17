<?php
	define('ABS_CUR_DIR_FRAME',	dirname(__FILE__).'/');
	require_once(ABS_CUR_DIR_FRAME.'../../inc/checkSession.php');
	require_once(ABS_CUR_DIR_FRAME."../../comm/formCheck.php");
	$userID = $_SESSION['userData']['id'];

	$htmlBody = new formCheck(ABS_CUR_DIR_FRAME."/html/userInfo.html");
	$srcHtml = $htmlBody->getHtmlCode();
	$srcHtml = str_replace( "__LOGINAME__", $_SESSION['userData']['uid'], $srcHtml );
	$srcHtml = str_replace( "__NAME__", $_SESSION['userData']['userName'], $srcHtml );
	if ( $_SESSION['userData']['influenceID'] == -1 )
		$srcHtml = str_replace( "__INFLUENCE__", $GLOBAL['G_DB_OBJ']->getFieldValue("select name from webadmin.influence where id=(select influenceID from webadmin.user where uid='quanjun@staff.sina.com.cn')" ), $srcHtml );
	else
		$srcHtml = str_replace( "__INFLUENCE__", $GLOBAL['G_DB_OBJ']->getFieldValue("select name from webadmin.influence where id=".$_SESSION['userData']['influenceID'] ), $srcHtml );

	$srcHtml = str_replace( "__LASTLOGINTIME__", $_SESSION['userData']['lastLoginTime'], $srcHtml );
	$srcHtml = str_replace( "__REGTIME__", $_SESSION['userData']['regTime'], $srcHtml );
	$srcHtml = str_replace( "__IP__", $_SESSION['userData']['ip'], $srcHtml );
	$srcHtml = str_replace( "__INFO__", "恭喜，登录成功!", $srcHtml );

	echo $srcHtml;	

	return ;
?>
