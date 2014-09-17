<?php
define('ABS_CUR_DIR_CHKAUTHOR_CONF', dirname(__FILE__).'/');
require_once( ABS_CUR_DIR_CHKAUTHOR_CONF."../../../../kernel/inc/conf.php" );
require_once (ABS_CUR_DIR_CHKAUTHOR_CONF.'../../../../kernel/comm/formCheck.php');
//require_once (ABS_CUR_DIR_CHKAUTHOR_CONF.'../../../inc/conf.php');
global $GLOBAL;
//$GLOBAL['modulesInfo']['tmplPath'] = ABS_CUR_DIR_CHKAUTHOR_CONF.'/../tmpl/login.tmpl';
//认证系统数组定义
$GLOBAL['modulesInfo']['formAction'] = GLOBAL_ROOT_PATH.'kernel/comm/urlDiffluence.php';
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH.'modules/chkauthor/showtmpl.php'] = 'author_url_to_url';
$author_url_to_url = array(GLOBAL_ROOT_PATH.'modules/chkauthor/showtmpl.php' =>array(
													'default'=>array	(
													'to_path'=>MODULES_PATH.'mainFrame/systemhome.html',
													'to_query'=>'',
													'info'=>'成功登录系统'
													),

													'flag=1'=>array	(
													'to_path'=>MODULES_PATH.'mainFrame/systemhome.html',
													'to_query'=>'',
													'info'=>'成功登录系统'
													)
														),
							);/**/
?>