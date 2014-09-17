<?php
define( 'ABS_CUR_DIR',	dirname(__FILE__).'/' );
require_once( ABS_CUR_DIR.'conf/conf.php' );
$menuID=intval( $_REQUEST['menuID'] );
if ( $menuID == "" )
	$menuID = intval( $_POST['menuID'] );
$influenceID =  intval( $_SESSION['influenceID'] );

/*
if ( $opt !== 'editpowersave' )
{
	print_r( $opt );
	$influenceCheck = getModuleInfluence(  );
	$influenceCheck = $influenceCheck[ $menuID ];
}
*/
$pagenum =intval( $_REQUEST['pagenum'] );
$typeFlag = $_REQUEST['typeFlag'];

switch ( $GLOBAL['runData']['opt'] )
{
	case 'addFlag':

		$tmplHtml = new formCheck( TMPL_PATH_ADD, get_rep_tmp( $id ) );

		$tmplStr = $tmplHtml->getHtmlCode( );
		echo $tmplStr;
		break;
	case 'listFlag':
		$GLOBAL['modulesInfo']['pageNum'] = intval( $_REQUEST['pagenum'] )?intval( $_REQUEST['pagenum'] ):1;
		$GLOBAL['htmlDefine']['replaceArray']['__FORMACTION__'] = ROOT_PATH.'showtmpl.php?flag=1&opt=delFlag&menuID='.$menuID;
		$mapData = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select id as __ID__, name as __NAME__, (select keyName from keyValue where id=keyValueID limit 1) as __STATUS__, regTime as __TIME__ from influence limit '.$GLOBAL['modulesInfo']['pageSize']*( $GLOBAL['modulesInfo']['pageNum'] - 1 ).','.$GLOBAL['modulesInfo']['pageSize'] );
		$pageList = new pageList( );

		$GLOBAL['htmlDefine']['replaceArray']['__BUTTOMSTR__'] = $pageList->getButtomStr();
		$GLOBAL['htmlDefine']['replaceArray']['__JAVASCRIPT__'] = getPageScript();

		$formCheck1 = new formCheck();
		$formCheck1->initRegexDataArray( array( 0=>$mapData, 1=>'/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i' ) );
		$htmlBody = $formCheck1->getHtmlCode(  );
		echo $htmlBody;
		break;
	case 'delFlag':
		$rowID = $_POST['id_编号_integer_1_10_0_0'];
		//print_r( $_POST );
		$errMsg = "删除错误，错误信息如下:<br><br>";
		$runMsg = "删除成功，删除列表如下:<br><br>";
		$chkRet = 1;
		$idList = "";
		while ( current( $rowID ) !== FALSE )
		{
			$tmpSql = "select name from influence where id=".current( $rowID );
			$userName = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpSql );	
			$tmpSql = "select uid from user where influenceId=".current( $rowID );
			$tmpFieldValue = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpSql );	
			if ( !Empty( $tmpFieldValue ) )
			{
				$errMsg = $errMsg."角色为:'".$userName."' 已经被'".$tmpFieldValue."'帐号所使用，请先删除帐号后,再删除该角色!<br>";
				$chkRet = 0;
				break;
			}
			$runMsg = $runMsg."角色为:".$userName."<br><br>";
			$idList = $idList.current( $rowID ).",";
			next( $rowID );
		}
		if ( strlen( $idList ) > 0 )//删除最后的','号便于删除
			$idList = subStr($idList, 0, -1 );

		if ( $chkRet == 1 )
		{
			
			if ( substr_count( $idList, ',' ) < 1 )
				$sql = "delete from influence where id =".$idList;
			else
				$sql = "delete from influence where id in(".$idList.")";
			if ( $GLOBAL['G_DB_OBJ']->executesql( $sql ) )
			{
				GwriteLogToDB( $runMsg );
				echo getErrorTmpl( $runMsg );
			}
			else
			{
				GwriteLogToDB( $runMsg.",执行失败" );
				echo getErrorTmpl( "删除失败!" );
			}
		}
		else
			echo getErrorTmpl( $errMsg );
		exit;
		break;
	case 'editPower':
		$id = $_REQUEST['id'];
		$influence = new influence( $id );
		$powerStr = $influence->getMergeDataHtml( );
		$influenceName = $influence->getFieldValue("select name from webadmin.influence where id=".$id );
		$tmplHtml = new formcheck( ABS_CUR_DIR."tmpl/editpower.html" );
		$tmplStr = $tmplHtml->get_html_code("./showtmpl.php?opt=editpowersave&id=".$id);
		$tmplStr = str_ireplace("__JAVASCRIPT__", "", $tmplStr );
		$tmplStr = str_ireplace("__INFLUENCEID__",  $id, $tmplStr );
		$tmplStr = str_ireplace("__INFLUENCENAME__",  $influenceName, $tmplStr );
		$tmplStr = str_ireplace("__USERPOWER__",  $powerStr, $tmplStr );
		$tmplStr = str_ireplace("__MENU_ID__", $menuID, $tmplStr );
		echo $tmplStr;
		break;
	case 'showpower':
		$id=intval( $_REQUEST['id'] );
		$influence = new influence( $id );
		$powerStr = $influence->getMergeDataHtml( 0 );
		$influenceName = $influence->getFieldValue("select name from webadmin.influence where id=".$id );

		$tmplHtml = new formcheck( ABS_CUR_DIR."tmpl/showpower.html" );
		$tmplStr = $tmplHtml->get_html_code("#");
		$tmplStr = str_ireplace("__INFLUENCENAME__",  $influenceName, $tmplStr );
		$tmplStr = str_ireplace("__JAVASCRIPT__", "", $tmplStr );
		$tmplStr = str_ireplace("__INFLUENCEID__",  $influenceID, $tmplStr );
		$tmplStr = str_ireplace("__USERPOWER__",  $powerStr, $tmplStr );
		echo $tmplStr;
		break;
	case 'editpowersave':
		$id = $_REQUEST['id'];
		$influence = new influence( $id );
		$sqlStr = $influence->getSetUserPowerSql( $_POST );
		$influence->executeMutiSql( $sqlStr );
		echo get_web_location_script( str_replace("opt=editpowersave","opt=listFlag",str_replace( "&action=save", "", get_url_query() )), "权限分配成功" );
		break;
	case 'editFlag':
		if ( $influenceID == -1 )
			$id = $G_db_obj->getFieldValue( "select influenceID from webadmin.user where loginame='quanjun' limit 1;" );
		else
			$id= $influenceID;

		$mapData = $GLOBAL['G_DB_OBJ']->executeSql( 'select id as __ID__, name as __NAME__, (select keyName from webadmin.keyValue where id=influence.keyValueID) as keyValueID, regTime as __REGTIME__ from influence where id='.$_REQUEST['id'] );  
		$tmplHtml = new formCheck( TMPL_PATH_EDIT, get_rep_tmp( $mapData['keyValueID'] ) );
		$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $mapData );
		$tmplStr = $tmplHtml->getHtmlCode( '', $combox_data );
		
		echo $tmplStr;
		break;
	case 'readFlag':
		$id=intval( $_REQUEST['id'] );
		$page_list = new pagelist( );
		$node_data = $page_list->get_node_data( $id );
		$tmplHtml = new formcheck( TMPL_PATH_DETAIL );
		$tmplStr = $tmplHtml->get_html_code(  );
		$tmplStr = str_ireplace("__ID__", $id, $tmplStr );
		$tmplStr = str_ireplace("__LOGINAME__", $node_data['loginame'], $tmplStr );
		$tmplStr = str_ireplace("__PASSWORD__", $node_data['password'], $tmplStr );
		$tmplStr = str_ireplace("__PASSWORD1__", $node_data['password'], $tmplStr );
		$tmplStr = str_ireplace("__NAME__", $node_data['name'], $tmplStr );
		$tmplStr = str_ireplace("__NUMBER__", $node_data['number'], $tmplStr );
		$tmplStr = str_ireplace("__SEX__", $node_data['sex'], $tmplStr );
		$tmplStr = str_ireplace("__TEL__", $node_data['tel'], $tmplStr );
		$tmplStr = str_ireplace("__EMAIL__", $node_data['email'], $tmplStr );
		$tmplStr = str_ireplace("__DEPARTMENT__", $node_data['department'], $tmplStr );
		$tmplStr = str_ireplace("__INFLUENCE__", $node_data['(select name from influence where influence.id='.TABLE_NAME.'.influenceid)'], $tmplStr );
		echo $tmplStr;
		break;
}
?>