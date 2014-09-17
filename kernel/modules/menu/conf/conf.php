<?php
//web develop require
define('ABS_CUR_DIR_MENU_CONF', dirname(__FILE__).'/');
//require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/inc/chk_session.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../datastruct/treeDBClass.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../comm/formCheck.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../baselib/postPage.php' );

//define( 'DEF_URL', '<a href=../html/login.php>重新登录</a>' );
define('MODULE_NAME',											'菜单管理'	);
define('MODULE_NAME_EN',											'MENU'	);
define('MODULE_NAME_EN_LOW',											'menu'	);

define('ROOT_PATH',											GLOBAL_ROOT_PATH.'/modules/'.MODULE_NAME_EN_LOW.'/'	);

define( 'DEF_LINK', GLOBAL_ROOT_PATH.'modules/mainFrame/blank.php?flag=1&opt=listFlag' );    // The name of the database
define( 'MENU_ADD_SUB', 'menu_add_sub'	);
define( 'MENU_ADD_SUB_SAVE', 'menu_add_sub_save'	);
define( 'MENU_ADD', 'menu_add'			);
define( 'MENU_ADD_SAVE', 'menu_add_save'			);
define( 'MENU_UPD', 'menu_upd'			);
define( 'MENU_UPD_SAVE', 'menu_upd_save'			);
define( 'MENU_DEL_SAVE', 'menu_del_save'			);
define( 'MENU_CLOSE', 'menu_close'			);
//定义菜单模板css路径
global $GLOBAL;
$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_DIR_MENU_CONF."../tmpl/menu.tmpl";
$tmplOPTPath = ABS_CUR_DIR_MENU_CONF."../tmpl/menuopt.tmpl";

//菜单属性定义
$menu_pic= array(
				'plus_img_0'	=>'../../cssimg/tree_plus.gif',	//中+
				'plus_img_1'	=>'../../cssimg/tree_plus1.gif',	//底+
				'minus_img_0'	=>'../../cssimg/tree_minus.gif',	//中-
				'minus_img_1'	=>'../../cssimg/tree_minusl.gif',	//底-
				'blank_img_0'	=>'../../cssimg/tree_blank.gif',	//中空
				'blank_img_1'	=>'../../cssimg/tree_blank1.gif',	//底空
				'line_img'		=>'../../cssimg/tree_line.gif',		//连接竖线
				'query_img_0'	=>'../../cssimg/info_query.gif',		//未展开图标
				'query_img_1'	=>'../../cssimg/info_query1.gif',		//展开后图标
				'query_img_2'	=>'../../cssimg/info_query2.gif',		//叶子图标
				'css'			=>'../../cssimg/style.css'
			);
$selfMenu = 1;	//1表示显示右键菜单，0表示不显示右键菜单
define( 'RIGHTMENUSTR',"<div id='ie5menu' class='skin0' onMouseover='highlightie5()' onMouseout='lowlightie5()' >
						<div class='menuitems' id='a1' url=''  onClick='jumptoie5();'>新建子项</div>
						<hr>
						<div class='menuitems' id='a2' url=''  onClick='jumptoie5();'>新建项</div>
						<hr>
						<div class='menuitems' id='a3' url='' onClick='jumptoie5();'>修改</div>
						<hr>
						<div class='menuitems' id='a4' url='' onClick=\"javascript:if(confirm('确定要删除吗?'))jumptoie5();\">删除</div>
						" );
define( 'RIGHTMENUOPTSTR',	"<Script Language='javascript'>
<!--
	if (document.all && window.print)
	{
		ie5menu.className = menuskin;
		document.body.onclick = hidemenuie5;
	}
	document.body.oncontextmenu = Click;
	//<!--是否显示右键菜单//-->
</Script>" );

?>
