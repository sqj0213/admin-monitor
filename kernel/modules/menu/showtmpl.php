<?php
	define('ABS_CUR_DIR_MENU', dirname(__FILE__).'/');
	require_once( ABS_CUR_DIR_MENU.'../../inc/checkSession.php' );
	require_once( ABS_CUR_DIR_MENU.'conf/conf.php' );
	require_once( ABS_CUR_DIR_MENU.'../../comm/formCheck.php' );
	//$menuID = intval( $GLOBAL['runData']['menuID'] );

	$influenceID =  intval( $GLOBAL['runData']['userData']['influenceID'] );
	//print_r( $influenceID );
	$GLOBAL['htmlDefine']['replaceArray']['__CSSFILEPATH__'] = '../../cssimg/style.css';
	$tmpl = new formcheck( $GLOBAL['htmlDefine']['tmplPath'] );
	//print_r( $GLOBAL['htmlDefine']['tmplPath'] );
	//print_r($GLOBAL['runData']);
	//print_r( $_SESSION );
	//print_r( $influenceID );
	$selfMenu = 1;
 	if (  $influenceID == -1 && $selfMenu == 1 )//超级管理员才可以有菜单
		$TselfMenu = 1;
	else
	{
		$TselfMenu = 0;
		$selfMenu = 0;
	}

	//$tmpl->replaceSrcCode( "__RIGHTMENU__", RIGHTMENUSTR );
	//echo $influenceID;
	$tree_class = new treeDBClass(0, "", $influenceID );

	$menuBody = $tree_class->buildTreeHtml();
	$tmpl->replaceSrcCode( "__MENUBODY__", $menuBody );

 	if (  $influenceID == -1 && $selfMenu == 1 )//超级管理员才可以有菜单
		$tmpl->replaceSrcCode( "__RIGHTMENUOPT__", RIGHTMENUSTR.RIGHTMENUOPTSTR );
	else
		$tmpl->replaceSrcCode( "__RIGHTMENUOPT__", "" );

	//$tmpl->replaceSrcCode( "__CSSFILEPATH__", $GLOBAL['htmlDefine']['cssPath'] );
	echo  $tmpl->getHtmlCode( "" );
?>