<?php
	define( 'ABC_CUR_KEYVALUE_DIR', dirname(__FILE__).'/' );
	require_once( ABC_CUR_KEYVALUE_DIR."../../../inc/checkSession.php" );
	require_once( ABC_CUR_KEYVALUE_DIR."../conf/conf.php" );

	if ( $GLOBAL['runData']['opt'] == 'listFlag' )
	{
		$GLOBAL['htmlDefine']['tmplPath'] = ABC_CUR_KEYVALUE_DIR.'../tmpl/page.html';
		$GLOBAL['htmlDefine']['replaceArray']['__COMMONCSS__'] = GLOBAL_ROOT_PATH.'kernel/cssimg/style.css';

		$GLOBAL['modulesInfo']['userKey'] = array(	
													'id'=>'__ID__',
													'keyName'=>'__NAME__',
													'typeFlag'=>'__TYPEFLAG__',	
													'value'=>'__VALUE__',
													'delFlag'=>'__STATUS__',
													'note'=> '__NOTE__',
													'regTime'=>'__REGTIME__'
													);
		$GLOBAL['modulesInfo']['tableName'] = 'webadmin.keyValue';
		$GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';
		$GLOBAL['modulesInfo']['subSql'] = isset( $_REQUEST[ 'typeFlag' ] ) ? ('typeFlag='.intval( $_REQUEST[ 'typeFlag' ] ) ): '';
		
		require_once( ABC_CUR_KEYVALUE_DIR."../../../comm/loadModules.php" );
		$errMsg = '';
		$moduleShowtmpl = loadModules( "webPage", $errMsg );
		//global $serverInfo;
		//print_r( $GLOBAL[ 'serverInfo'] );
		//exit;
	} 
	if ( $GLOBAL['runData']['opt'] == 'editFlag' )
	{
		//$GLOBAL['modulesInfo']['splitPageLink'] = getUrlServer().getUrlPathQuery();
		$GLOBAL['htmlDefine']['tmplPath'] = ABC_CUR_KEYVALUE_DIR.'../tmpl/edit.html';
		
		$GLOBAL['htmlDefine']['replaceArray']['__COMMONCSS__'] = GLOBAL_ROOT_PATH.'kernel/cssimg/common.css';
			
		//$swsPrice = $salesDB->executeSqlMap( 'sele
		
		$pageData = $GLOBAL[ 'G_DB_OBJ' ]->executeSql( 'select id as __ID__, keyName as __NAME__, typeFlag as __TYPEFLAG__, value as __VALUE__, note as __NOTE__ from webadmin.keyValue where id='.$GLOBAL[ 'runData' ][ 'updID' ] );

		$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $pageData );
		//print_r( $pageHtml->getTableSql( ) );
		//print_r( $mapData );
		//$mapData = buildProductPrice( $mapData );
		require_once( ABC_CUR_KEYVALUE_DIR."../../../comm/loadModules.php" );
		$moduleShowtmpl = loadModules( "webPage", $errMsg );
		
	}
	
	if ( $GLOBAL['runData']['opt'] == 'addFlag' )
	{
		//$GLOBAL['modulesInfo']['unionField'] = 'id_编号';
		require_once( ABC_CUR_KEYVALUE_DIR."../../../comm/loadModules.php" );
		$moduleShowtmpl = loadModules( "webPage", $errMsg );

		$GLOBAL['htmlDefine']['tmplPath'] = ABC_CUR_KEYVALUE_DIR.'../tmpl/add.html';
		$GLOBAL['htmlDefine']['replaceArray']['__COMMONCSS__'] = GLOBAL_ROOT_PATH.'kernel/cssimg/common.css';
		$GLOBAL['htmlDefine']['replaceArray']['__SYSTEMUSERID__'] = $GLOBAL['runData']['userData']['id'];
		$GLOBAL['htmlDefine']['replaceArray']['__TYPEFLAG__'] = intval( $_REQUEST[ 'typeFlag' ] );
		
		
	}
	
	$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH.'kernel/modules/keyValue/showtmpl.php'] = 'keyValue_url_to_url';//url所对应的跳转数组名称
	$keyValue_url_to_url = array(GLOBAL_ROOT_PATH.'kernel/modules/keyValue/showtmpl.php' =>array(
																		'default'=>array(
																						'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/keyValue/showtmpl.php',
																						'to_query'=>'opt=listFlag',
																						'type'=>'location',
																						'info'=>'删除类型成功!'
																						),
																		'opt=addFlag'=>array(
																						'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/keyValue/showtmpl.php',
																						'to_query'=>'opt=addFlag',
																						'type'=>'reload',
																						'info'=>'填加类型成功!'
																						),
																		'opt=editFlag'=>array(
																						'to_path'=>GLOBAL_ROOT_PATH.'kernel/modules/keyValue/showtmpl.php',
																						'to_query'=>'opt=listFlag',
																						'type'=>'reload',
																						'info'=>'修改类型成功!'
																						)
																		)
								);
//4226
?>