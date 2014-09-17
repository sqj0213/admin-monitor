<?php
	define( 'ABS_CUR_DIR_MENU',		dirname(__FILE__).'/' );
	require_once( ABS_CUR_DIR_MENU.'../../inc/checkSession.php' );
	require_once( ABS_CUR_DIR_MENU.'conf/conf.php' );
	define ( 'TMPLFILE', ABS_CUR_DIR_MENU.'tmpl/menuopt.tmpl' );
	if ( isset( $_REQUEST['menuflag'] ) )
		$menuflag = $_REQUEST['menuflag'];
	else
		$menuflag = MENU_ADD;
	if ( isset( $GLOBAL['runData']['menuID'] ) )
		$menuID = $GLOBAL['runData']['menuID'];
	else
		$menuID = 0;
	/*
<input type=text name=menuName_结点名称_textboxen_3_40_1_1 size=40 maxlength=40 value="__MENUNAME__">
<input type=text name=menuLink_结点链接_textboxen_3_40_1_1 size=40 maxlength=40 value="__MENULINK__">
<input type=text name=menuPId_父结点_integer_1_1000_0_1 size=40 maxlength=40 value="__MENUPID__">
*/
	$srcHtml = file_get_contents( TMPLFILE );
	$srcHtml = str_ireplace( '__MENUID__',		$menuID,		$srcHtml );
	switch ( $menuflag )
	{
		case MENU_ADD_SUB://新建子项_PID_页面
			$srcHtml = str_ireplace( '__FLAG__',		MENU_ADD_SUB_SAVE,		$srcHtml );
			$srcHtml = str_ireplace( '__OPT_TYPE__',	'1',		$srcHtml );
			$srcHtml = str_ireplace( '__MENUNAME__',	'',		$srcHtml );
			$srcHtml = str_ireplace( '__SORTVALUE__',	'1',		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELIST__',	$GLOBAL['serverInfo']['influenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELISTEXAMPLE__',	$GLOBAL['serverInfo']['influenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__MENULINK__',	DEF_LINK,	$srcHtml );
			echo $srcHtml;
			break;
		case MENU_ADD://新建项页面
			$srcHtml = str_ireplace( '__FLAG__',		MENU_ADD_SAVE,		$srcHtml );
			$srcHtml = str_ireplace( '__OPT_TYPE__',	'1',		$srcHtml );
			$srcHtml = str_ireplace( '__SORTVALUE__',	'1',		$srcHtml );
			$srcHtml = str_ireplace( '__MENUNAME__',	'',		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELIST__',	$GLOBAL['serverInfo']['influenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELISTEXAMPLE__',	$GLOBAL['serverInfo']['influenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__MENULINK__',	DEF_LINK,	$srcHtml );
			echo $srcHtml;
			break;
		case MENU_UPD://修改项页面
			$srcHtml = str_ireplace( '__FLAG__',		MENU_UPD_SAVE,		$srcHtml );
			$tree_arr = new treeDBClass();
			$srcHtml = str_ireplace( '__OPT_TYPE__',	'2',		$srcHtml );
			//print_r( $menuID );
			$tree_node = $tree_arr->getTreeNode( $menuID );
			print_r( $tree_node );
			//exit;
			$srcHtml = str_ireplace( '__MENUNAME__',	$tree_node['MenuName'],		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELIST__',	$tree_node['InfluenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__CUSTOMINFLUENCEITEMLIST__',	$tree_node['customInfluenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__INFLUENCELISTEXAMPLE__',	$GLOBAL['serverInfo']['influenceItemList'],		$srcHtml );
			$srcHtml = str_ireplace( '__MENULINK__',	$tree_node['MenuLink'],		$srcHtml );
			$srcHtml = str_ireplace( '__SORTVALUE__',	$tree_node['SortValue'],		$srcHtml );
			echo $srcHtml;
			break;
		case MENU_DEL_SAVE://删除项后台
			$menu_arr['MenuId'] =  $menuID;
			$tree_arr = new treeDBClass();
			try{$ret = $tree_arr->updTreeNode( $menu_arr, MENU_DEL_SAVE );}
			catch (Exception $e){ echo getWebLocationScript('./showtmpl.php',$e->getMessage());}
			echo getWebLocationScript('./showtmpl.php');
			break;
		case MENU_ADD_SUB_SAVE://增加子项后台
			$post_arr =  new postPage( $_POST );
			$menu_arr = $post_arr->getPostDataArr( );
			$menu_arr['MenuId'] = intval( $menu_arr['menuID'] );
			$tree_arr = new treeDBClass();
			$ret = $tree_arr->updTreeNode( $menu_arr, MENU_ADD_SUB_SAVE );
			echo getWinCloseScript( );
			break;
		case MENU_ADD_SAVE://增加项后台
			$post_arr =  new postPage( $_POST );
			$menu_arr = $post_arr->getPostDataArr( );
			//print_r( $menu_arr);
			//exit;
			$menu_arr['MenuId'] = intval( $menu_arr['menuID'] );
			$tree_arr = new treeDBClass();
			$ret = $tree_arr->updTreeNode( $menu_arr, MENU_ADD_SAVE );
			echo getWinCloseScript( );
			break;
		case MENU_UPD_SAVE://修改项后台
			$post_arr =  new postPage( $_POST );
			$menu_arr = $post_arr->getPostDataArr( );
			//print_r( $GLOBAL['runData']  );
			//exit;
			$menu_arr['MenuId'] = intval( $menu_arr['menuID'] );
			$tree_arr = new treeDBClass();
			$ret = $tree_arr->updTreeNode( $menu_arr, MENU_UPD_SAVE );
			echo getWinCloseScript( );
			break;
	}
//	echo $srcHtml;
//	$srcHtml = new formcheck( $tmplPath );
//	echo $srcHtml->getHtmlCode( );

?>
