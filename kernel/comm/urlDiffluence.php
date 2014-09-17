<?php
/* 站点的控制器
   1.验证前端数据
   2.验证请求的来源
   3.拼写数据处理sql
   4.调用应用定义的hook接口
   5.处理数据并跳转到应用配置的出口
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */

define('ABS_CUR_DIR_COMM', dirname(__FILE__) . '/');
require_once(ABS_CUR_DIR_COMM . '../inc/conf.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/conf.php');
require_once(ABS_CUR_DIR_COMM . '../inc/global.php');
require_once(ABS_CUR_DIR_COMM . '../function/parseUrl.php');
require_once(ABS_CUR_DIR_COMM . '../function/webOptCode.php');

$parseUrl = getPreUrlPathQurey();
$parseUrl_tmp = $parseUrl;

if (preg_match('/login.php/', $parseUrl['path']))
    include_once( DOCUMENT_ROOT. $parseUrl['path'] . "conf/conf.php");
else if (preg_match('/admin.php/', $parseUrl['path']))
    include_once( DOCUMENT_ROOT . $parseUrl['path'] . "conf/conf.php");
else if (preg_match('/index.php/', $parseUrl['path'])) {
	//echo "l=".__LINE__."<br>";
    include_once( DOCUMENT_ROOT . $parseUrl['path'] . "conf/conf.php");
	//print_r(DOCUMENT_ROOT . $parseUrl['path'] . "conf/conf.php" );
}
else
{

	if ( strlen( $parseUrl['path'] ) < 4 )
	    require_once( DOCUMENT_ROOT. "/login.phpconf/conf.php");
	else
	    require_once( DOCUMENT_ROOT. str_replace("showtmpl.php", "", $parseUrl['path']) . "conf/conf.php");
}
$parseUrl['path'] = str_ireplace("//", "/", $parseUrl['path']);

$regex = '/(opt=)[^&]*/';
preg_match_all($regex, $parseUrl['query'], $tmp);
$parseUrl['query'] = $tmp[0][0];
/*
$parseUrl['query']=preg_replace( '/(&|\?)?pagenum=[0-9]{1,10}/i', '', $parseUrl[ 'query' ] );
$parseUrl['query']=preg_replace( '/(&|\?)?menuID=[0-9]{1,10}/i', '', $parseUrl['query'] );

$parseUrl['query']=preg_replace( '/(&|\?)?optUserID=[0-9]{1,10}/i', '', $parseUrl['query'] );
$parseUrl['query']=preg_replace( '/(&|\?)?activityID=[0-9]{1,10}/i', '', $parseUrl['query'] );
$parseUrl['query']=preg_replace( '/(&|\?)?id=[0-9]{1,10}/i', '', $parseUrl[ 'query'] );
*/
$parseUrl['path'] = preg_replace('/\/+/i', '/', $parseUrl['path']);
/*
$tmp = $GLOBAL['modulesArray'][$parseUrl['path']];
$moduleArr = $$tmp;
$moduleFrom = $moduleArr[$parseUrl['path']];
*/
//print_r( $_POST );
//exit;
$moduleFrom = isset( $GLOBAL['modulesArray'][$parseUrl['path']] )?$GLOBAL['modulesArray'][$parseUrl['path']]:'';


if ( Empty( $moduleFrom  ) ) {
	//if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
	//	echo json_encode( array( 'retCode'=>-1, 'errMsg'=>'请求非法,或者组件未注册,请检查数据结构!', 'data'=>array() ) );
	//else
	    echo '请求非法,或者组件未注册,请重新登录!' . $GLOBAL['serverInfo']['errorUrl'];
    exit;
}

if (preg_match('/login.php/', $parseUrl['path']) || preg_match('/admin.php/', $parseUrl['path']) || preg_match('/index.php/', $parseUrl['path'])) {
    session_start();
    if (strtolower($_SESSION['checkCode']) !== strtolower($_POST['checkCode'])) {
        echo getHistoryBackScript("校验码不正确请检查!");
        exit;
    }
}

$db_obj;
$sqlstring;


if ( function_exists('hookBefore') )
	hookBefore();

try
{
    $postPageOBJ = new postPage($_POST);
}
catch (Exception $e)
{
	if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
		echo  json_encode( array( 'retCode'=>-1, 'errMsg'=>'数据非法！('.__LINE__.')info('.$e->getMessage().')', 'data'=>array() ) );
	else
	 echo $e->getMessage() . $GLOBAL['serverInfo']['errorUrl'] . '<br>';
    return;
}
$errMsg = "";
$sqlstring = $postPageOBJ->get_string_from_post_array($errMsg);


if ($errMsg !== "") {
	if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
		echo json_encode( array( 'retCode'=>-1, 'errMsg'=>$errMsg, 'data'=>array() ) );
	else
		echo getHistoryBackScript($errMsg);
    exit;
}
$result = array();

try
{
    $result = $GLOBAL['G_DB_OBJ']->executeSql($sqlstring);

} catch (Exception $e)
{
	if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
		echo json_encode( array( 'retCode'=>-1, 'errMsg'=>$e->getMessage(), 'data'=>array() ) );
	else
    echo $e->getMessage() . $GLOBAL['serverInfo']['errorUrl'] . '<br>';
    return;
}

if ($postPageOBJ->formPostToDBArray['accesssign'] === 4 && $result['retNum'] == 0) //若为存储过程调用的话
{
	if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
		echo json_encode( array( 'retCode'=>-1, 'errMsg'=>$result['errMsg'], 'data'=>array() ) );
	else
    echo getErrorTmpl($result['errMsg']);
    exit;
}

if ( function_exists( 'hookAfter' ) )
	hookAfter();

if (preg_match('/login.php/', $parseUrl['path']) ||strlen( $parseUrl['path'] ) <2 || preg_match('/admin.php/', $parseUrl['path']) || preg_match('/index.php/', $parseUrl['path'])) {
	if ( strlen( $parseUrl['path'] ) < 2 )
	    require_once( DOCUMENT_ROOT . '/'.$parseUrl['path'] . 'login.phpconf/conf.php');
	else

    require_once( DOCUMENT_ROOT . $parseUrl['path'] . 'conf/conf.php');
    if (count($result) === 0) {
        echo "该用户不存在!&nbsp;&nbsp;<a href='" . $GLOBAL['serverInfo']['errorUrl'] ."'>返回</a>";
        exit;
    }
    else
    {
	       //若有权限验证的话
        if ($GLOBAL['checkACL']) {
            if ($result[18] == 1 && $result[1] !== $GLOBAL['admin']) {
                $runMsg = "用户已经被禁用，不能登录!";
                GwriteLogToDB1('login', $runMsg);
                echo getErrorTmpl('login', "用户已经被禁用，不能登录!");
                exit;
            }
        }
        $checkAuthor = new checkAuthClass();
		//$_SESSION['influenceData'] = $this->xmlArray['influenceStruct'];
		$checkAuthor->setLoginame( $result['uid']  );
		$checkAuthor->setPasswd( $result['passwd'] );
		$checkAuthor->checkAuth( );

        $checkAuthor->setSession($result);//权限已经加入session,权限列表为influenceData
		
        session_start();
        $GLOBAL['runData']['userData'] = $_SESSION['userData'];
        if ($GLOBAL['checkACL']) {
			
        }

        $tmpSql = "update webadmin.user set lastLoginTime=now() where id=" . $result['id'] . ";";
        if ($GLOBAL['G_DB_OBJ']->executeSql($tmpSql) !== 1) {
            $GLOBAL['G_DB_OBJ']->writeLog($GLOBAL['G_DB_OBJ']->errLog, "f=" . __FILE__ . "\tl=" . __LINE__ . "\tinfo(" . $tmpSql . ")");
            echo getErrorTmpl("登录失败!info('修改登录时间失败')" . $tmpSql);
            exit;
        }
    }
}
if ( function_exists('hookAfter') )
{
	hookAfter();
}
//优化代码,之前已经定义,无需再次定义
//$moduleFrom = $moduleArr[$parseUrl['path']];

if (!Empty($parseUrl['query']) && !Empty($moduleFrom[$parseUrl['query']]))
    $toURLArray = $moduleFrom[$parseUrl['query']];
else
    $toURLArray = $moduleFrom['default'];

$text = $postPageOBJ->getPostInfo();

GwriteLogToDB1($toURLArray['info'], $text);
if (Empty($toURLArray['to_query'])) {
    $toURL = $toURLArray['to_path'] . '?' . $parseUrl_tmp['query'];
}
else
{

	if (preg_match('/(opt=)[^&]*/', $toURLArray['to_query'])) //若目标里包含opt
        $parseUrl_tmp['query'] = preg_replace('/(opt=)[^&]*/', '', $parseUrl_tmp['query']);
    //替空现有的opt
	$diffQueryString =  parseQueryArrayToString( array_diff( parseQueryStringToArray( $parseUrl_tmp['query'] ), parseQueryStringToArray( $toURLArray['to_query']  ) ) );
        $toURL = $toURLArray['to_path'] . '?' . $toURLArray['to_query'] .'&'.$diffQueryString;
//	echo $toURL;
//	exit;
}
$toURL = preg_replace('/&+/i', '&', $toURL); //替换多个&号字符

if ($toURLArray['type'] == 'reload')
    echo getWebLocationScript($toURL, $toURLArray['info']);
else if ( $toURLArray['type'] == 'json' )
	echo $toURLArray['info'];
else
    header("Location:" . BASEURL . $toURL);
?>
