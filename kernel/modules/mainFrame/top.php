<?php
	define('ABS_CUR_DIR_FRAME',	dirname(__FILE__).'/');
	require_once(ABS_CUR_DIR_FRAME.'../../inc/checkSession.php');
	require_once(ABS_CUR_DIR_FRAME."../../inc/global.php");
	require_once(ABS_CUR_DIR_FRAME."../../comm/formCheck.php");
	$userID = $_SESSION['userData']['id'];

	$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_DIR_FRAME."html/top.html";

	$GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $_SESSION['userData']['uid'];
	$GLOBAL['htmlDefine']['replaceArray']['__USERNAME__'] = $_SESSION['userData']['userName'];
	$GLOBAL['htmlDefine']['replaceArray']['__LASTLOGINTIME__'] = $_SESSION['userData']['lastLoginTime'];
	//$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCENAME__'] = $GLOBAL['G_DB_OBJ']->getFieldValue('select name from webadmin.influence where id='.$_SESSION['userData']['influenceID'] );
	$GLOBAL['htmlDefine']['replaceArray']['__IP__'] = $_SESSION['userData']['ip'];

	$htmlBody = new formcheck(  );

	echo $htmlBody->getHtmlCode();	

	return ;
?>
