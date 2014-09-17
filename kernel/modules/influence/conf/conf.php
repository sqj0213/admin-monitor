<?php
define('MODULE_NAME',											'角色管理'	);
define('MODULE_NAME_EN',											'INFLUENCE'	);
define('MODULE_NAME_EN_LOW',											'influence'	);
define('ABS_CUR_PATH_CONF',				dirname( __FILE__ )."/" );
require_once(ABS_CUR_PATH_CONF.'../../../inc/checkSession.php');
//require_once(ABS_CUR_PATH_CONF.'../../../inc/global.php');

define('ROOT_PATH',											GLOBAL_ROOT_PATH.'kernel/modules/'.MODULE_NAME_EN_LOW.'/'	);
define('TMPL_PATH_ADD',			ABS_CUR_PATH_CONF.'../tmpl/add.html'	);
define('TMPL_PATH_EDIT',			ABS_CUR_PATH_CONF.'../tmpl/edit.html'	);
define('TMPL_PATH_PAGE',			ABS_CUR_PATH_CONF.'../tmpl/page.html'	);
define('TMPL_PATH_DETAIL',			ABS_CUR_PATH_CONF.'../tmpl/detail.html'	);
require_once(ABS_CUR_PATH_CONF.'../../../function/parseUrl.php');
require_once(ABS_CUR_PATH_CONF.'../../../comm/formCheck.php');
require_once(ABS_CUR_PATH_CONF.'../../menu/datastruct/treeDBClass.php');

define('TABLE_NAME',						'influence');
define('PAGE_LINK_FILE',					'showtmpl.php');
define('URL_DIFFLUENCE',								ROOT_PATH.'../comm/url_diffluence.php');
if (defined(GLOBAL_DEFAULT_PAGE_SIZE))
	define('GLOBAL_DEFAULT_PAGE_SIZE',		GLOBAL_DEFAULT_PAGE_SIZE);
else
	define('INFLUENCE_PAGE_SIZE',								10);

$nodeData = array( 'id'=>'__ID__',
				   'name'=>'__NAME__',
				   '(select keyName from keyValue where id=keyValueID)'=>'__STATUS__',
				   'regTime'=>'__REGTIME__'
				   );
$combox_data=array( 'keyValueID'=>'keyValueID' );//编辑时使用，sql取值会更新此值 
global $GLOBAL;
$GLOBAL['modulesInfo']['tableName'] = TABLE_NAME;
$GLOBAL['modulesInfo']['unionField'] = "name_角色名称";//排重字段
$GLOBAL['modulesInfo']['primaryLink'] = array('field'=>'__NAME__','url'=>ROOT_PATH.PAGE_LINK_FILE.'?opt=showpower&id=__ID__');
$GLOBAL['modulesInfo']['userKey'] = $nodeData;
$GLOBAL['modulesInfo']['splitPageLink'] = PAGE_LINK_FILE.preg_replace('/&pagenum=[0-9]{1,10}/i','', getUrlQueryString());
$GLOBAL['htmlDefine']['tmplPath'] = TMPL_PATH_PAGE;
$GLOBAL['modulesInfo']['powerList'] = array('addFlag'=>1, 'editFlag'=>1, 'delFlag'=>1,'antiSelectAll'=>1,'selectAll'=>1 );

$GLOBAL['htmlDefine']['buttomStr'] = "共__TOTALRECORD__条&nbsp;&nbsp;分__PAGECOUNT__页&nbsp;&nbsp;第__PAGENUM__页&nbsp;&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMFIRST__'>首页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMPRE__'>前页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMNEXT__'>后页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMLAST__'>尾页</a>&nbsp;<input name=\"button\" type=\"button\" id=\"button\" value=\"编辑权限\" onclick=\"javascript:if (chk_box_status()) {location.href='".preg_replace('/.php[?0-9=a-z&]{1,100}/i','.php',PAGE_LINK_FILE.preg_replace('/&pagenum=[0-9]{1,10}/i','',getUrlQueryString()))."?opt=editPower&id='+get_chk_box_value()+'&menuID='+get_menu_id(this);}\">";

//echo get_url_query()."ashdfasdfasdf";
//填加用户所需的脚本--begin
function get_rep_tmp( $defaultValue )
{

	//$tmplHtml = new DBBaseClass( );
	//function getComboxFromSql( $name, $sql, $defaultValue="", $onChange=false, $key="", $value=-1 )

	return array(
					'__TYPEDATA__'=>getComboxFromSql( 'keyValueID_角色状态_integer_1_10_1_1', 'select id,keyName as name from keyValue where typeFlag=1 order by id desc', $defaultValue ),//需要调用数据库进行再次查询并替换的变量
				);
}
$GLOBAL['modulesArray'][ROOT_PATH.'showtmpl.php'] =  'influence_url_to_url';
$influence_url_to_url = array(ROOT_PATH.PAGE_LINK_FILE =>array(
										'opt=addFlag'=>array	(
													'to_path'=>ROOT_PATH.PAGE_LINK_FILE,
													'to_query'=>'flag=1&opt=listFlag&menuID=2',
													'type'=>'location',
													'info'=>'填加角色'
															),
										'opt=listFlag'=>array	(
													'to_path'=>ROOT_PATH.PAGE_LINK_FILE,
													'to_query'=>'flag=1&opt=listFlag&menuID=2',
													'type'=>'location',
													'info'=>'角色列表'
													),
										'opt=editFlag'=>array	(
													'to_path'=>ROOT_PATH.PAGE_LINK_FILE,
													'to_query'=>'flag=1&opt=listFlag&menuID=2',
													'type'=>'location',
													'info'=>'编辑角色'
																),
										'opt=editPower'=>array	(
													'to_path'=>ROOT_PATH.PAGE_LINK_FILE,
													'to_query'=>'flag=1&opt=listFlag&menuID=2',
													'type'=>'location',
													'info'=>'编辑用户权限'
																)
														)
								);


?>