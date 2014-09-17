<?php
	define( 'ABS_CUR_USERMANAGER_DIR', dirname(__FILE__).'/' );
	require_once( ABS_CUR_USERMANAGER_DIR."../../../inc/checkSession.php" );
	require_once( ABS_CUR_USERMANAGER_DIR."../conf/conf.php" );

	require_once( ABS_CUR_USERMANAGER_DIR."../../../comm/loadModules.php" );
	$errMsg = '';
	$moduleShowtmpl = loadModules( "webPage", $errMsg );
		
	switch ( $GLOBAL['runData']['opt'] )
	{
		case "readFlag":
		{
			$tmpSql = 'select b.name as __INFLUENCENAME__, a.uid as __UID__,a.userName as __USERNAME__, a.lastLoginTime as __LASTLOGINTIME__, a.regtime as __REGTIME__,(select oemName from sales.salesOEM where salesOEM.id=a.siteID limit 1)as __OEMNAME__ from webadmin.user a, webadmin.influence b where a.influenceID=b.id and a.id='.$GLOBAL['runData']['updID'].' limit 1';
			$tmpArray = $GLOBAL[ 'G_DB_OBJ']->executeSql( $tmpSql );
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR.'../tmpl/detail.html';
			$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'],  $tmpArray );

			//print_r( $GLOBAL['htmlDefine']['replaceArray'] );
			break;
		}
		case "addFlag":
		{
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR.'../tmpl/add.html';
			$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCE__'] =  getComboxFromSql( 'influenceid_用户角色_integer_1_10_1_1', 'select id,name from webadmin.influence order by id desc', '' );
			if ( isset( $appConf[ 'adminUserSiteID' ]['siteIDSQL'] ) )
				$GLOBAL['htmlDefine']['replaceArray']['__OEMLIST__'] =  getComboxFromSql( 'siteID_所属oem_integer_1_10_1_1', $appConf[ 'adminUserSiteID' ]['siteIDSQL'], '' );
			else
				$GLOBAL['htmlDefine']['replaceArray']['__OEMLIST__'] = '';
			//print_r( $GLOBAL['htmlDefine']['replaceArray'] );
			break;
		}
		case "listFlag":
		{
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR.'../tmpl/page.html';
			$GLOBAL['modulesInfo']['userKey'] = array(
										'id'=>'__ID__',
										'uid'=>'__UID__',
			//							'password'=>'密码',
										'userName'=>'__USERNAME__',
										'(select name from webadmin.influence where ID=user.influenceID)'=>'__INFLUENCE__',
										'status'=>'__STATUS__',
										'lastLoginTime'=>'__LASTLOGINTIME__',
										'regTime'=>'__REGTIME__'
										);
			$GLOBAL['modulesInfo']['tableName']	= 'webadmin.user';
			$GLOBAL['modulesInfo']['subSql'] = ' influenceID != -1 ';
			$GLOBAL['modulesInfo']['unionField']	= 'uid_用户邮箱';
			//需要点击开看明细的列
			$GLOBAL['modulesInfo']['primaryLink']['field']	= '__UID__';
			break;
		}	
		case "editFlag":
		{
			$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_USERMANAGER_DIR.'../tmpl/edit.html';
			$nodeData = $GLOBAL['G_DB_OBJ']->executeSql( 'select id as __ID__, uid as __UID__, userName as __USERNAME__, lastLoginTime as __LASTLOGINTIME__, influenceID, siteID, regTime as __REGTIME__ from webadmin.user where id='.(isset( $_REQUEST['id'] )?$_REQUEST['id']:$GLOBAL['runData']['userData']['id'] ));
			$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCE__'] = ($GLOBAL['runData']['userData']['influenceID'] == -1)?getComboxFromSql( 'influenceid_用户角色_integer_1_10_1_1', 'select id,name from webadmin.influence order by id desc', $nodeData['influenceID'] ):$GLOBAL['G_DB_OBJ']->getFieldValue('select name from webadmin.influence where id='.$GLOBAL['runData']['userData']['influenceID'].' limit 1');

			if ( isset( $appConf[ 'adminUserSiteID' ]['siteIDSQL'] ) )
                $GLOBAL['htmlDefine']['replaceArray']['__OEMLIST__'] =  $GLOBAL['G_DB_OBJ']->getFieldValue('select oemName from sales.salesOEM where id = '.$nodeData['siteID'].' limit 1');
				//getComboxFromSql( 'siteID_所属oem_integer_1_10_1_1', $appConf[ 'adminUserSiteID' ]['siteIDSQL'], $nodeData['siteID'] );
			else
				$GLOBAL['htmlDefine']['replaceArray']['__OEMLIST__'] = '';

			$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $nodeData );
		break;
		}
	}

	
	$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php'] = array(
											'opt=addFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=1&opt=listFlag&menuID=84',
														'type'=>'location',
														'info'=>'注册用户'
																	),
											'opt=addFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=2&opt=listFlag&menuID=85',
														'type'=>'location',
														'info'=>'填加系统用户'
																	),
											'opt=delFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=2&opt=listFlag&menuID=85',
														'type'=>'location',
														'info'=>'删除系统用户'
																	),														
											'opt=resetPwd'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=1&opt=listFlag&menuID=84',
														'type'=>'location',
														'info'=>'重置密码'
																	),
											'opt=resetPwd'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=2&opt=listFlag&menuID=85',
														'type'=>'location',
														'info'=>'重置密码'
																	),
											'opt=listFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=1&opt=listFlag&id=1&menuID=84',
														'type'=>'location'
																	),
	//http://localhost:81//cgi/backend/usermanager/'showtmpl.php'?opt=page&pagenum=15
											'opt=editFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=1&opt=listFlag&menuID=84',
														'type'=>'location',
														'info'=>'编辑注册用户'
																	),
											'opt=editFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>'flag=2&opt=listFlag&menuID=85',
														'type'=>'location',
														'info'=>'编辑系统用户'
																	),
											'opt=editFlag&editFlag=menu'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/usermanager/showtmpl.php',
														'to_query'=>"flag=1&opt=editFlag&editFlag=menu&menuID=40",
														'type'=>'location',
														'info'=>'用户编辑'
																	)
										);
//	print_r( $GLOBAL['modulesArray'] );
?>
