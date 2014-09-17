<?php
	define( 'ABS_CUR_USERMANAGER_DIR_ACL', dirname(__FILE__).'/' );

	require_once( ABS_CUR_USERMANAGER_DIR_ACL."../../../comm/loadModules.php" );
//	require( ABS_CUR_USERMANAGER_DIR_ACL."../datastruct/aclClass.php" );
	//print_r( ABS_CUR_USERMANAGER_DIR_ACL."../datastruct/aclClass.php" );
	//exit;
	$errMsg = '';
	global $moduleShowtmpl;
	$moduleShowtmpl = loadModules( "webPage", $errMsg );
	//print_r( $GLOBAL[ 'runData' ] );
	global $GLOBAL;
	switch ( $GLOBAL['runData']['opt'] )
	{

		case "addFlag":
		{
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR_ACL.'../tmpl/add.html';
			$GLOBAL['htmlDefine']['replaceArray']['__TYPEDATA__'] =  getComboxFromSql( 'keyValueID_用户角色_integer_1_10_1_1', 'select id,keyName from webadmin.keyValue where typeFlag=1 order by id desc', '' );
			//print_r( $GLOBAL['htmlDefine']['replaceArray'] );
			break;
		}
		case 'editFlag':
		{
			//print_r( $_POST );
			//print_r( $_GET );
			//exit;
			//if ( $webadmin.influenceID == -1 )
			//	$id = $GLOBAL['G_DB_OBJ']->getFieldValue( "select webadmin.influenceID from systemuser where loginame='quanjun' limit 1;" );
			//else
			$id = $GLOBAL['runData']['updID'];
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR_ACL.'../tmpl/edit.html';	
			$mapData =  $GLOBAL['G_DB_OBJ']->executeSql( 'select id as __ID__, name as __NAME__, keyValueID from webadmin.influence where id='.$id );
			//print_r( $GLOBAL );
			$GLOBAL['htmlDefine']['replaceArray']['__TYPEDATA__'] = ($GLOBAL['runData']['userData']['influenceID'] == -1)?getComboxFromSql( 'keyValueID_角色状态_integer_1_10_1_1', 'select id, keyName from webadmin.keyValue order by id desc', $mapData['keyValueID'] ):$GLOBAL['G_DB_OBJ']->getFieldValue('select keyName from webadmin.keyValue l');	
			$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $mapData );

			break;
		}
		case "listFlag":
		{
			//把删除的请求提交到此模块来处理，不由引擎来处理，替换opt与pagenum的request参数为空并追加opt=delFlag
			$GLOBAL['htmlDefine']['replaceArray']['__FORMACTION__'] = preg_replace( '/&opt=listFlag/i', '', preg_replace('/&pagenum=[0-9]{1,10}/i', '', getCurrentUrlPathQueryString() ) ).'&opt=delFlag';
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR_ACL.'../tmpl/page.html';
			$GLOBAL['modulesInfo']['userKey'] = array(
										'id'=>'__ID__',
										'name'=>'__NAME__',
			//							'password'=>'密码',
										'(select keyName from webadmin.keyValue where id=webadmin.influence.keyValueID)'=>'__STATUS__',
										'regTime'=>'__REGTIME__'
										);
			$GLOBAL['modulesInfo']['primaryLink']['field'] = '__NAME__';
			$GLOBAL['modulesInfo']['tableName']	= 'webadmin.influence';
			$GLOBAL['modulesInfo']['unionField']	= 'name_角色名称';
			//echo "l=".__LINE__."<br>";
			break;
		}
		case 'delFlag':
		{
			//print_r( $_POST );
			$rowID = $_POST['id_编号_integer_1_10_0_0'];
			$errMsg = "删除错误，错误信息如下:<br><br>";
			$runMsg = "删除成功，删除列表如下:<br><br>";
			$chkRet = 1;
			$idList = "";
			while ( current( $rowID ) !== FALSE )
			{
				$tmpSql = "select name from webadmin.influence where id=".current( $rowID );
				$userName = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpSql );	
				$tmpSql = "select uid from webadmin.user where influenceId=".current( $rowID );
				$tmpFieldValue = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpSql );	
				if ( !Empty( $tmpFieldValue ) )
				{
					$errMsg = $errMsg."角色为:'".$userName."' 已经被'".$tmpFieldValue."'帐号所使用,请先删除帐号后,再删除该角色!<br>";
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
					$sql = "delete from webadmin.influence where id =".$idList;
				else
					$sql = "delete from webadmin.influence where id in(".$idList.")";
				if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) )
				{
					GwriteLogToDB( '删除角色',$runMsg );
					echo getErrorTmpl( $runMsg, $GLOBAL['htmlDefine']['errTmplPath'] );
				}
				else
				{
					GwriteLogToDB( '删除角色警告!', $runMsg );
					echo getErrorTmpl( "删除失败!" );
				}
			}
			else
				echo getErrorTmpl( $errMsg, $GLOBAL['htmlDefine']['errTmplPath'] );
			//此处必须加exit,否则会调用webPage
			exit;
			break;
		}
	case 'editPower':
	{
		$id = $GLOBAL['runData']['updID'];
		//exit;
		//exit;
		$influence = new aclClass( $id );
		//print_r( $webadmin.influence->menuData );
		//exit;
		$powerStr = $influence->getMergeDataHtml( );
	//	print_r( $powerStr );
		//exit;
		//print_r( $GLOBAL['runData'] );
		$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR_ACL."../tmpl/editpower.html";
		$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCEID__'] = $id;
		//不调用系统引擎处理，调用此类的分支switch来处理
		$GLOBAL['htmlDefine']['replaceArray']['__FORMACTION__'] = "/kernel.php?module=acl&app=showtmpl&opt=editpowersave&id=".$id."&menuID=".$GLOBAL['runData']['menuID'];
		$GLOBAL['htmlDefine']['replaceArray']['__MENUID__'] = $GLOBAL['runData']['menuID'];
		$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCENAME__'] = $GLOBAL['G_DB_OBJ']->getFieldValue("select name from webadmin.influence where id=".$id );
		$GLOBAL['htmlDefine']['replaceArray']['__USERPOWER__'] = $powerStr;

		break;
	}
	case 'editpowersave':
	{
		$id = $GLOBAL['runData']['updID'];
		$influence = new aclClass( $id );
		$sqlStr = $influence->getSetUserPowerSql( $_POST );
		//print_r( $sqlStr );
		//exit;
		//exit;
		$GLOBAL['G_DB_OBJ']->executeMutiSql( $sqlStr );
		//		print_r( $sqlStr );
		echo getWebLocationScript( str_replace("opt=editpowersave","opt=listFlag",str_replace( "&action=save", "", getUrlQueryString() )), "权限分配成功" );
		//notice this exit;
		exit;
		break;
	}
	case 'readFlag':
	{
		$id = $GLOBAL['runData']['updID'];
		$influence = new aclClass( $id );
		$powerStr = $influence->getMergeDataHtml( 0 );
		$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR_ACL.'../tmpl/showpower.html';

		$GLOBAL['htmlDefine']['replaceArray']['__webadmin.influenceNAME__'] = $GLOBAL['G_DB_OBJ']->getFieldValue("select name from webadmin.influence where id=".$id.' limit 1' );
		$GLOBAL['htmlDefine']['replaceArray']['__USERPOWER__'] = $powerStr;
		break;	
	}
}
	$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php'] = array(
										'opt=addFlag'=>array	(
													'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php',
													'to_query'=>'opt=listFlag',
													'type'=>'location',
													'info'=>'填加角色'
															),
										'opt=listFlag'=>array	(
													'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php',
													'to_query'=>'',
													'type'=>'location',
													'info'=>'角色列表'
													),
										'opt=delFlag'=>array	(
													'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php',
													'to_query'=>'opt=listFlag',
													'type'=>'location',
													'info'=>'角色列表'
													),
										'opt=editFlag'=>array	(
													'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php',
													'to_query'=>'opt=listFlag',
													'type'=>'location',
													'info'=>'编辑角色'
																),
										'opt=editPower'=>array	(
													'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/acl/showtmpl.php',
													'to_query'=>'',
													'type'=>'location',
													'info'=>'编辑用户权限'
																)
														);
//	print_r( $GLOBAL['modulesArray'] );
?>
