<?php
define('ABS_CURRENT_GLOBAL', dirname(__FILE__) . "/");
require_once(ABS_CURRENT_GLOBAL . "conf.php");
require_once(ABS_CURRENT_GLOBAL . "../function/parseString.php");
require_once(ABS_CURRENT_GLOBAL . "../function/webOptCode.php");
require_once(ABS_CURRENT_GLOBAL . '../../kernel/function/mergeConf.php');
//require_once(DOCUMENT_ROOT . '/inc/setLang.php');

global $appConf;
mergeConf($GLOBAL, $appConf); //合并应用配置

function __autoload($classname)
{
    global $GLOBAL;
    global $systemClass;
    if (Empty($systemClass[$classname]))
        $systemClass[$classname] = dirname($_SERVER['SCRIPT_FILENAME']) . '/appClass/' . $classname . '.php';

    require_once ($systemClass[$classname]);
}

if ($GLOBAL['dbInit']) {
    $GLOBAL['G_DB_OBJ'] = new DBBaseClass();
    //global $GLOBAL['serverInfo']['dbInfo'];
    $GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);
}

function GwriteLogToDB1($title, $msg, $clubID = 0)
{
    session_start();
    global $GLOBAL;
    $tmpSql = "insert into webadmin.optlog(userID,title, text, ip) values('" . intval(isset($_SESSION['userData']['id']) ? $_SESSION['userData']['id'] : 0) . "','" . $title . "','" . $msg . "','" . $_SESSION['userData']['ip'] . "');";
    $GLOBAL['G_DB_OBJ']->executeSql($tmpSql);
}

function gWriteLogToDB($userID, $title, $msg, $ip)
{
    global $GLOBAL;
    $tmpSql = "insert into webadmin.optlog(userID,title, text, ip) values('" . intval($userID) . "','" . $title . "','" . $msg . "','" . $ip . "');";
    $GLOBAL['G_DB_OBJ']->executeSql($tmpSql);
}

function getModuleInfluenceSession($opt = 'listFlag')
{
    global $GLOBAL;
    $row = array();

    if ($GLOBAL['runData']['userData']['influenceID'] == -1) { //若为超管的话
        $checkInfluence = new checkAuthClass();
        $checkInfluence->getInfluenceModule($GLOBAL['runData']['userData']['influenceID']);
        $row = $checkInfluence->xmlArray['influenceStruct'][$GLOBAL['runData']['menuID']];
        return $row;
    }
    $row = $_SESSION['influenceData'][$GLOBAL['runData']['menuID']];
	if ( Empty( $row ) )
	{
        echo getHistoryBackScript("请求错误!");
        exit;
	}
    if (($row[$opt]['value'] != 1) && ($GLOBAL['runData']['userData']['influenceID'] != -1)) {
        echo getHistoryBackScript("请求错误!");
        exit;
    }
    else if ($row[$opt]['value'] === 0) {
        echo getHistoryBackScript("您没有操作此功能的权限!");
        exit;
    }

    return $row;

}

function getModuleInfluenceOnline($opt = 'listFlag')
{
    global $GLOBAL;
    $row = array();
    $checkInfluence = new checkAuthClass();
    $checkInfluence->getInfluenceModule($GLOBAL['runData']['userData']['influenceID']);

    if ($GLOBAL['runData']['userData']['influenceID'] == -1) { //若为超管的话
        $row = $checkInfluence->xmlArray['influenceStruct'][$GLOBAL['runData']['menuID']];
        //print_r( $row );
        return $row;
    }
    $row = $checkInfluence->xmlArray['influenceStruct'][$GLOBAL['runData']['menuID']];

    if (($row[$opt]['value'] != 1) && ($GLOBAL['runData']['userData']['influenceID'] != -1)) {
        echo getHistoryBackScript("请求错误!");
        exit;
    }
    else if ($row[$opt]['value'] === 0) {
        echo getHistoryBackScript("您没有操作此功能的权限!");
        exit;
    }

    return $row;
}

if (!function_exists('apache_request_headers')) {
    eval('
        function apache_request_headers() {
            foreach($_SERVER as $key=>$value) {
                if (substr($key,0,5)=="HTTP_") {
                    $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                    $out[$key]=$value;
                }
            }
            return $out;
        }
    ');
}
$GLOBAL['runData']['menuID'] = isset($_REQUEST['menuID']) ? $_REQUEST['menuID'] : 0;
if (Empty($GLOBAL['runData']['menuID']))
    $GLOBAL['runData']['menuID'] = isset($_POST['menuID']) ? $_POST['menuID'] : 0;

if (isset($_REQUEST['opt']))
    $GLOBAL['runData']['opt'] = $_REQUEST['opt'];
else
    $GLOBAL['runData']['opt'] = '';

$GLOBAL['runData']['updID'] = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$GLOBAL['modulesInfo']['pageNum'] = isset($_REQUEST['pagenum']) ? $_REQUEST['pagenum'] : 0;
if (Empty($GLOBAL['modulesInfo']['pageNum']))
    $GLOBAL['modulesInfo']['pageNum'] = 0;

if ($GLOBAL['serverInfo']['mutiLangFlag'] == 1) {
    function initLanguage()
    {
        global $GLOBAL;
        $langArray = array('zh_CN' => 'zh_CN',
            'zh_TW' => 'zh_TW',
            'en_US' => 'en_US'
        );
        $lan = Empty($_REQUEST['lang']) ? 'zh_CN' : $_REQUEST['lang'];
        $GLOBAL['htmlDefine']['lang'] = $lan;

        isset($langArray[$lan]) ? (putenv('LANG=' . $langArray[$lan]) && setlocale(LC_ALL, $langArray[$lan])) : (putenv('LANG=zh_CN') && setlocale(LC_ALL, 'zh_CN'));

        $domain = 'lang';
        bindtextdomain($domain, DOCUMENT_ROOT . "/static/locale/");
        bind_textdomain_codeset($domain, 'UTF-8');
        textdomain($domain);

		$tmplPath = $GLOBAL['serverInfo']['tmplPath'];
		$tmplPath = str_replace("zh_CN", $lan, $tmplPath);
        if (!Empty($GLOBAL['runData']['opt']))
            $GLOBAL['htmlDefine']['tmplPath'] = $tmplPath . substr($_SERVER['DOCUMENT_URI'], 0, -4) . '_' . $GLOBAL['runData']['opt'] . '.tmpl';
        else
            $GLOBAL['htmlDefine']['tmplPath'] = $tmplPath . substr($_SERVER['DOCUMENT_URI'], 0, -4) . '.tmpl';
        $GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'] = $tmplPath . 'header.tmpl';
        $GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__'] = $tmplPath . 'footer.tmpl';
    }

    initLanguage();
}
else
{
    //notice this,后面的应用会重新定义tmplPath所以global引用,后面会重置tmplPath
    if (!Empty($GLOBAL['runData']['opt']))
        $GLOBAL['htmlDefine']['tmplPath'] = $GLOBAL['serverInfo']['tmplPath'] . '/' . substr($_SERVER['DOCUMENT_URI'], 0, -4) . '_' . $GLOBAL['runData']['opt'] . '.tmpl';
    else
        $GLOBAL['htmlDefine']['tmplPath'] = $GLOBAL['serverInfo']['tmplPath'] . '/' . substr($_SERVER['DOCUMENT_URI'], 0, -4) . '.tmpl';

    $GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'] = $GLOBAL['serverInfo']['tmplPath'] . '/header.tmpl';
    $GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__'] = $GLOBAL['serverInfo']['tmplPath'] . '/footer.tmpl';
}
?>
