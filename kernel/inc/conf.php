<?php
/*全局配置文件,所有文件必须要包含此文件
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
//xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
define ('ABS_CONF_CUR_DIR_INC_GLOBAL', dirname(__FILE__) . "/");
require_once(ABS_CONF_CUR_DIR_INC_GLOBAL . "../function/parseUrl.php");

//注意框架与应用的目录结构
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
$tmpStr = strstr($_SERVER['DOCUMENT_URI'], 'kernel\/');
//print_r( $tmpStr );
if (Empty($tmpStr)) {
    define('GLOBAL_ROOT_PATH', str_replace(substr($_SERVER['DOCUMENT_URI'], strripos($_SERVER['DOCUMENT_URI'], '/')), '', $_SERVER['DOCUMENT_URI']));
    //echo "l=".__LINE__."<br>";
    //全局类路径
    define('URL_DIFFLUENCE', GLOBAL_ROOT_PATH . '/urlDiffluence.php');
    //echo "l=".DOCUMENT_ROOT."<br>";

}
else
{
    define('GLOBAL_ROOT_PATH', str_replace($tmpStr, '', $_SERVER['DOCUMENT_URI']));
    define('URL_DIFFLUENCE', GLOBAL_ROOT_PATH . 'kernel/comm/urlDiffluence.php');
}

//web数据库查询工具,-2小于,-1小于等于,0等于,1大于等于,2大于,ll左匹配,rl右匹配,l为全匹配
//define( 'WEB_SEARCH_ITEM_ROLE', '/^(([a-z\.0-9A-Z]{1,30})|([a-z\.0-9A-Z_]{1,30}))(_)[\-2,\-1,0,1,2,l,ll,rl]{1,2}$/' );
define('WEB_SEARCH_ITEM_ROLE', '/^([a-z\.0-9A-Z]{1,30})(_)[\-2,\-1,0,1,2,l,ll,rl]{1,2}$/');
global $webSearchSqlKey;
$webSearchSqlKey = array('-2' => '< \'_VAL_\'',
    '-1' => '<= \'_VAL_\'',
    '0' => '= \'_VAL_\'',
    '1' => '>= \'_VAL_\'',
    '2' => '> \'_VAL_\'',
    'l' => 'like \'%_VAL_%\'',
    'll' => 'like \'_VAL_%\'',
    'rl' => 'like \'%_VAL_\''
);
$webSearchDenyChar = '\'\\';


//print_r( GLOBAL_ROOT_PATH );
//全局类路径
define('BASEURL', 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/'); //全局类路径
define('DEFAULTURL', BASEURL . GLOBAL_ROOT_PATH . 'index.html'); //全局类路径

//系统所拥有的所有类
$systemClass = array(
    'formCheck' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../comm/formCheck.php',
    'pageList' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../comm/pageList.php',
    'baseClass' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../baselib/baseClass.php',
    'postPage' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../baselib/postPage.php',
    'DBBaseClass' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../baselib/DBBaseClass.php',
    'checkAuthClass' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../modules/chkauthor/datastruct/checkAuthClass.php',
    'treeDBClass' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../modules/menu/datastruct/treeDBClass.php',
    'aclClass' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../modules/acl/datastruct/aclClass.php',
    'XML' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../baselib/xmlClass.php',
    'cache' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../modules/cache/datastruct/cache.php'
);
//web开发时所用
/*notice PHP正则表达式中不支持下列 Perl 转义序列：\L, \l, \N, \P, \p, \U, \u, or \X*/
define('JS_CH_REG', '\u4e00-\u9fa5'); //javascript中文检验正则表达式
define('PHP_CH_REG', '\x80-\xff'); //PHP中文检验正则表达式

define('TEXTBOXEN', '/^[' . PHP_CH_REG . '@a-z0-9A-Z_\-\. \:\|\/\=#]{0,280}$/');
//define( 'TEXTAREA',								'/^['.PHP_CH_REG.'a-z0-9A-Z_\-\. &;,<>\r\n\ ]{1,5000}$/');   
define('TEXTAREA', '/.*/');
define('BIRTHDAY', '/^(19|20)[0-9]{2,2}(-)(0|1){0,1}[0-9]{1,1}(-)[0-3]{0,1}[0-9]{1,1}$/');
define('DATETIME', '/^(1|2)[0-9]{3,3}(-)(0|1)[0-9]{1,1}(-)[0-3]{1,1}[0-9]{1,1}( )[0-2]{1,1}[0-9]{1,1}(:)[0-5]{1,1}[0-9]{1,1}(:)[0-5]{1,1}[0-9]+$/');
define('CHECKBOX', '/^[0-1]{1,1}$/');
define('CHECKCODE', '/^[\-0-9A-Za-z]{1,4}$/');
define('GAINRATE', '/^[+]?(?:\d+(\.\d*)?|\d*\.\d+?)$/');
//define( 'TEXTBOXEN',								'/[^\x00-\xff]$/');   
//define( 'TEXTBOXEN','/^[a-z0-9A-Z_\-\.]+([a-z0-9A-Z_\-\.])+[a-z0-9A-Z_\-\.]$/'	);  
define('TELEPHONE', '/(^[0-9]{3,4})+(\-){1,1}\d{7,8}$/');
define('PHONE', '/^[0-9\-]{7,15}$/');
define('MOBILE', '/(^1[3,5,8][0123456789]\d{8}$)/');
define('EMAIL', '/^[_a-z0-9\.]+(@{1,1})([_a-z0-9]+\.)+[a-z0-9]{2,3}$/');
define('NUMBER', '/^[0-9]{1,20}$/');
define('NUMBERSPLIT', '/^[0-9,\-]{1,}$/');
define('NEGATIVE', '/^(-)[0-9,]{1,}$/');
define('FLOAT', '/^(0|[1-9]\d*)$|^(0|[1-9]\d*)\.(\d{1,2})$/');
define('URL', '/[a-z0-9A-Z.\/]/');
define('SQL_FILTER', '/[. =]/'); // The name of the database
define('POSTCODE', '/^[a-z0-9A-Z_\-\.]+([a-z0-9A-Z_\-\.])+[a-z0-9A-Z_\-\.]$/'); // The name of the database
//define( 'FIELD_KEY_VALUE',"/( name[ \t]*=[ \t]*[\"'][^\"^']*[\"'] )/"			);
//define( 'FIELD_KEY_VALUE',"/( name[ \t]*=[ \t]*[\"'][^\"^']*[\"'] )/"			);
define('FIELD_KEY_VALUE', "/(\ +name[\ \t]*=[\ \t]*[\"'][^\"^']*[\"']\ {0,})/");
define('FORM_REG', '/<input[^>]*?>|<select[^>]*?>|<form[^>]*?>|<textarea[^>]*?>/');
//define( 'FILTERFORMREGEX',												'/^[a-z0-9A-Z]{1,30}+(_)+(['.PHP_CH_REG.'])+(_)+([0-9a-zA-Z])+(_)+[0-9]{1,4}+(_)+[0-9]{1,4}+(_)+[0-1]{1}+(_)+([0-1]{1})$/'	);
define('FILTERFORMREGEX', '/^[a-z0-9A-Z]{1,30}(_)[\x80-\xffA-Z0-9a-z]+(_)+([0-9a-zA-Z])+(_)+[0-9]{1,4}+(_)+[0-9]{1,4}+(_)+[0-1]{1}+(_)+([0-1]{1})$/');
define('TMPL_FORM_PRE', "form_");
define('FORM_SCRIPT_PRE', "script_");
define('OTHERFILTERFORM', "/(menuID|formname|ID|union_field)/");
define('FORM_NAME', "formname");
define('UPD_ID_NAME', "ID");
define('UNION_FIELD', "union_field");
define('CLUBID', "clubID");
define('MENU_ID', "menuID");
define('MYSQL_CHAR_SET', 'utf8');
define('DOMAIN_REG', '/\w+([-.]\w+)*\.\w+([-.]\w+)*/');


//example:form_0_systemuser 0为认证,1为查询，3为修改,4为删除,5为提取列表
define('FORM_CHK_REG', '/^form(_)[0-5]{1,1}(_)[a-z0-9-A-Z]{1,20}$/');
//example: loginame_登录名称_textboxen_4_20_1_0
//loginame_登录名称_检验类型_最小长度_最大长度_是否检查_是否加入数据库
//loginame_登录名称_textboxen_4_20_1_0

//全局数组定义,注意配置项的数组深度不能超过3层
$GLOBAL = array();
//调试开关
$GLOBAL['debugFlag'] = "onf";
$GLOBAL['checkSession'] = true; //默认情况下检查session
$GLOBAL['checkACL'] = true; //默认情况下检查ACL
$GLOBAL['dbInit'] = true; //默认情况下创建dbObj
$GLOBAL['admin'] = "quanjun@staff.sina.com.cn"; //超管帐号
//系统所包含的功能模块，每填加一个功能都可以修改此数组
$GLOBAL['runData'] = array('menuID' => 0,
    'opt' => null,
    'updID' => 0
);
$GLOBAL['modulesArray'] = array(
    GLOBAL_ROOT_PATH . '/modules/acl/showtmpl.php' => 'influence_url_to_url' //所对应的url数组名称
);
//print_r( $_SERVER['QUERY_STRING'] );
//列表页可以控制的成员变量，专用于列表控制
$GLOBAL['modulesInfo'] = array(
    //'tableName'=>TABLE_NAME,
    //'unionField'=>"name_角色名称",//排重字段
    //'userKey'=>$node_data,//列表的字段集
    //哪个字段有超链接自动填加超链接
    //'primaryLink'=>array('field'=>'__UID__','url'=>'?opt=readFlag&id=__ID__'),
    //'primaryLink'=>array('field'=>'__UID__','url'=>preg_replace('/&pagenum=[0-9]{1,10}/i','',getCurrentUrlPathQueryString())),//在指定的列表字段上定义超链接
    //'pageListType' =>array( 'type'=>'photo', 'colsNum'=>3 ),//列表类型

    'primaryLink' => array('field' => '__UID__', 'url' => '?' . replaceQueryStringItem($_SERVER['QUERY_STRING'], 'opt', 'readFlag') . '&id=__ID__'), //在指定的列表字段上定义超链接
    'splitPageLink' => '?' . removeQueryStringItem($_SERVER['QUERY_STRING'], 'pagenum'),
    //'powerList'=>array('addFlag'=>0, 'editFlag'=>0, 'delFlag'=>0,'antiSelectAll'=>0,'selectAll'=>0 ),
    'pageSize' => 30,
    'orderSubSql' => '', //排序
    'searchWebPara' => '', //web查询条件挂到翻页按钮
    'subSql' => '', //where子句里的条件filed like '%a%'
    'formAction' => URL_DIFFLUENCE,
    'primaryKey' => 'id', //主键删除时用
    //列表模块下方所拥有的操作按钮
    'powerList' => array(
        'selectAll' => 1, //全选按钮是否显示
        'antiSelectAll' => 1, //反选按钮是否显示
        'readFlag' => 1, //是否有查看明细的权限
        'addFlag' => 1, //是否有填加的按钮
        'delFlag' => 1, //是否有删除的按钮
        'listFlag' => 1, //是否有列表的权限
        'menuFlag' => 1, //是否有显示菜单的权限
        'customInfluenceItemList' => 1, //是否有定制权限的权限
        'editFlag' => 1, //是否有显示 修改按钮
        'editPower' => 1 //是否显示编辑权限按钮
    ),
    'buttomStr' => "共__TOTALRECORD__条&nbsp;&nbsp;分__PAGECOUNT__页&nbsp;&nbsp;第__PAGENUM__页&nbsp;&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMFIRST__&__SEARCHLIST__'>首页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMPRE__&__SEARCHLIST__'>前页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMNEXT__&__SEARCHLIST__'>后页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMLAST__&__SEARCHLIST__'>尾页</a>"
);
//页面可能用到的全局属性
$GLOBAL['htmlDefine'] = array('style' => '',
    //????有点绕，需要优化
    'optStyle' => array( //__URL__为global['modulesInfo']里的splitPageLink,即指调用者自己，通过opt参数来决定操作方式
        'popUp' => "javascript:window.open('__URL__','','toolbar=no,resizable=yes,scrollbars=yes,menubar=no');",
        'location' => "javascript:location.href='__URL__';",
        'delSele' => "javascript: if (checkchose())   { if (confirm('所选内容将被删除，确认要删除吗？')) this.form.formname.value=this.form.name;this.form.submit();}",
        'mulSele' => "javascript:if (checkchose()){ this.form.submit();}",
        'singleSele' => "javascript:if (chk_box_status()) {location.href='__URL__&id='+get_chk_box_value();}",
        'null' => ''
    ),
    'title' => 'aacube俱乐部',
    'tmplPath' => '',
    'lang' => 'zh_CN',
    //notice 用的时候再打开，考虑到有缓存的问题，所以此处有性能问题
    'replaceArray' => array('__HEADERFILE__' => ABS_CONF_CUR_DIR_INC_GLOBAL . '',
        '__FOOTERFILE__' => ABS_CONF_CUR_DIR_INC_GLOBAL . '',
        '__CSSFILEPATH__' => GLOBAL_ROOT_PATH . '/kernel/cssimg/style.css'
    ),
    'errTmplPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../tmpl/errMsg.tmpl',
    'defaultReplaceArray' => array() //页面里要替换的内容
);
//自定义的属性或规则一般不发生变化

$GLOBAL['serverInfo'] = array(
    'mutiLangFlag' => 0, //多语言开关
    'tmplPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../static/tmpl', //模板路径
    'cacheConf' => 'file|E:/webapp/webadmin.cloudway.cn/project/cloudway.cn/cache/', //若为文件请确认
    'baseUrl' => BASEURL,
    'diskRootPath' => GLOBAL_ROOT_PATH,
    'errorUrl' => DEFAULTURL,
    'mainPrograme' => GLOBAL_ROOT_PATH . '/site/login.php',

    'siteStruct' => array(
        'logPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '/log/',
        'modulesPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../modules/',
        'sitePath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '/site/',
        'applicationPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '/application/',
        'kernelPath' => ABS_CONF_CUR_DIR_INC_GLOBAL . '/'
    ),
    'dbInfo' => array('dbHost' => 'localhost',
        'dbUser' => 'root',
        'dbPwd' => '123qwe',
        'dbPort' => '3306',
        'dbName' => 'webadmin',
        'dbCharset' => MYSQL_CHAR_SET
    ),
    'logInfo' => array('errLog' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../log/errLog',
        'accLog' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../log/accLog',
        'notLog' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../log/notLog',
        'appLog' => ABS_CONF_CUR_DIR_INC_GLOBAL . '../log/app_log'
    ),
    //定义模块时决定此模块所能显示的权限项列表,0为不显示1为显示
    'influenceItemList' => '添加:style=location:addFlag=1|删除:style=delSele:delFlag=1|修改:style=singleSele:editFlag=1|只读:style=null:readFlag=1|列表:style=null:listFlag=1|菜单显示:style=null:menuFlag=1|权限分配:style=singleSele:editPower=1'
);


define('__DEFAULTJJS__', "<script language=javascript>\n<!--\nfunction frm_chk(fm)\n{\n\treturn true;\n}\n//-->\n</script>");

?>
