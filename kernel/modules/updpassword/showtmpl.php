<?php
define( 'ABS_CUR_DIR',	dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR.'../../inc/checkSession.php');
require_once( ABS_CUR_DIR.'../../inc/global.php' );


$menuID=intval( $_REQUEST['menuID'] );
//$influenceID =  intval( $_SESSION['influenceID'] );
$opt=$_REQUEST['opt'];
if ( $opt !== 'editFlagSave' )
	$influenceCheck = getModuleInfluenceSession( $opt );
//print_r( $GLOBAL );
//exit;
$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_DIR.'./tmpl/edit.html';
switch ($opt)
{

	case 'editFlag':
		$id=intval( $_REQUEST['id'] );

		$tmplHtml = new formCheck(  );
		$tmplStr = $tmplHtml->getHtmlCode( str_ireplace("&opt=editFlag", "", getUrlQueryString()) . "&opt=editFlagSave");
		$tmplStr = str_ireplace("__OLDPASSWORD__", "", $tmplStr );
		$tmplStr = str_ireplace("__PASSWORD__", "", $tmplStr );
		$tmplStr = str_ireplace("__PASSWORD1__", "", $tmplStr );
		echo $tmplStr;
		break;
	case 'editFlagSave':
		$uid =  $GLOBAL['runData']['userData']['uid'];
		$oldPwd = $_POST[ 'oldpassword_原密码_textboxen_4_20_1_0' ];
		$newpassword = $_POST[ 'passwd_登录密码_textboxen_4_20_1_1' ];
		$newpassword1 = $_POST[ 'passwd_确认密码_textboxen_4_20_0_0' ];
		if ( $newpassword !== $newpassword1 )
		{
			echo getHistoryBackScript("新密码与确认密码不一致，请检查!" );
			exit;
		}
		if ( ( $oldPwd === $newpassword ) && ( $newpassword === $newpassword1 ) )
		{
			echo getHistoryBackScript("原密码与新密码一致，请检查!" );
			exit;
		}
		$sql = "select count(id) from webadmin.user where uid='".$uid."' and passwd='".$oldPwd."' limit 1;";
		$ret = $GLOBAL['G_DB_OBJ']->getFieldValue( $sql );
		if ( intval( $ret ) < 1 )//
		{
			GwriteLogToDB( 'updatePassword',"密码修改失败,帐号[".$uid."],原密码输入错误");
			echo getHistoryBackScript("原密码输入错误，请检查!" );
			exit;
		}
		$sql = "update webadmin.user set passwd='".$newpassword."' where uid='".$uid."' limit 1;";
		$ret = $GLOBAL['G_DB_OBJ']->executesql( $sql );
		if ( $ret < 1 )//
		{
			GwriteLogToDB(  'updatePassword',"密码修改失败,帐号[".$uid."]");
			echo getHistoryBackScript("密码修改失败!" );
			exit;
		}
		else
		{
			GwriteLogToDB(  'updatePassword',"密码修改成功,帐号[".$uid."]");
			echo getHistoryBackScript("密码修改成功!" );
			exit;
		}
		break;
}
?>