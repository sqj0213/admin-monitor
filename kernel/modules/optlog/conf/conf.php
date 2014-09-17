<?php
	define( 'ABC_CUR_KEYVALUE_DIR', dirname(__FILE__).'/' );
	require_once( ABC_CUR_KEYVALUE_DIR."../../../inc/checkSession.php" );
	require_once( ABC_CUR_KEYVALUE_DIR."../conf/conf.php" );
	require_once( ABC_CUR_KEYVALUE_DIR."../../../function/webOptCode.php" );
	
	if ( $GLOBAL['runData']['opt'] == 'listFlag' )
	{

		$GLOBAL['htmlDefine']['tmplPath'] = ABC_CUR_KEYVALUE_DIR.'../tmpl/page.html';

		process();//初始化搜索器
		$GLOBAL['modulesInfo']['userKey'] = array(	
													'a.id'=>'__ID__',
													'b.userName'=>'__USERNAME__',
													'a.title'=>'__TITLE__',
													'a.text'=>'__TEXT__',
													'a.ip'=> '__IP__',
													'a.regTime'=>'__REGTIME__'
													);
		$GLOBAL['modulesInfo']['tableName'] = 'webadmin.optlog a, webadmin.user b';
		
		//搜索器模块有待抽象，并系统化，目前暂不处理，以后再优化
		if ( !Empty( $GLOBAL['modulesInfo']['subSql'] ) )
			$GLOBAL['modulesInfo']['subSql'] = $GLOBAL['modulesInfo']['subSql'].' and a.userID=b.id';
		else
			$GLOBAL['modulesInfo']['subSql'] = ' a.userID=b.id';
		//若为超级管理员的话		
		if ( $GLOBAL[ 'runData' ][  'userData' ][  'influenceID' ] == -1 || 
			$GLOBAL[ 'runData' ][  'userData' ][  'siteID' ] == 8 )
			;
		else
			$GLOBAL['modulesInfo']['subSql'] = $GLOBAL['modulesInfo']['subSql']. ' and b.siteID='.$GLOBAL[ 'runData' ][  'userData' ][  'siteID' ];



		$GLOBAL['modulesInfo']['orderSubSql'] = ' order by a.id desc';
		//$GLOBAL['modulesInfo']['subSql'] = $GLOBAL['modulesInfo']['subSql'].isset( $_REQUEST[ 'typeFlag' ] ) ? ('A.typeFlag='.intval( $_REQUEST[ 'typeFlag' ] ) ): '';
		
		require_once( ABC_CUR_KEYVALUE_DIR."../../../comm/loadModules.php" );
		$errMsg = '';
		$moduleShowtmpl = loadModules( "webPage", $errMsg );

	} 
	
	
	//日后可以做搜索器模块，暂时先不处理
	function process()
	{
		global $GLOBAL;
		$optUserID = intval( isset( $_POST[ 'optUserID' ] ) ? $_POST[ 'optUserID' ] : 0 );
		if ( $optUserID === 0 )
			$optUserID = intval( isset( $_REQUEST[ 'optUserID' ] ) ? $_REQUEST[ 'optUserID' ] : 0 );

		$year = intval( isset( $_POST[ 'year' ] ) ? $_POST[ 'year' ] : 0 );
		if ( $year === 0 )
			$year = intval( isset( $_REQUEST[ 'year' ] ) ? $_REQUEST[ 'year' ] : 0 );

		$month = intval( isset( $_POST[ 'month' ] ) ? $_POST[ 'month' ] : 0 );
		if ( $month === 0 )
			$month = intval( isset( $_REQUEST[ 'month' ] ) ? $_REQUEST[ 'month' ] : 0 );


		$day = intval( isset( $_POST[ 'day' ] ) ? $_POST[ 'day' ] : 0 );
		if ( $day === 0 )
			$day = intval( isset( $_REQUEST[ 'day' ] ) ? $_REQUEST[ 'day' ] : 0 );

		if ( !Empty( $optUserID ) && $optUserID !== 0 )
		{
				$subSql = " a.userID=".$optUserID;
		}
		if ( !Empty( $year ) && $year !==0 )
		{
			if ( !Empty( $subSql ) )
				$subSql = $subSql." and year(a.regtime)=".$year;
			else
				$subSql = " year(a.regtime)=".$year;
		}
		if ( !Empty( $month )&& $month !==0 )
		{
			if ( !Empty( $subSql ) )
				$subSql = $subSql." and month(a.regtime)=".$month;
			else
				$subSql = " month(a.regtime)=".$month;
		}
		if ( !Empty( $day )&& $day !==0 )
		{
			if ( !Empty( $subSql ) )
				$subSql = $subSql." and day(a.regtime)=".$day;
			else
				$subSql = " day(a.regtime)=".$day;
		}
		$searchList = "";
		if ( $optUserID !== 0 )
		{
			$searchList = "&optUserID=".$optUserID;
		}
		if ( $year !== 0 )
		{
			if ( Empty( $searchList ) )
				$searchList .= "year=".$year;
			else
				$searchList .= "&year=".$year;
		}
		if ( $month !== 0 )
		{
			if ( Empty( $searchList ) )
				$searchList .= "month=".$month;
			else
				$searchList .= "&month=".$month;
		}
		if ( $day !==0 )
		{
			if ( Empty( $searchList ) )
				$searchList .= "day=".$day;
			else
				$searchList .= "&day=".$day;
		}
		//去除不必要的模块功能按钮
		$GLOBAL['modulesInfo']['powerList'] = array_fill_keys( array_keys( $GLOBAL['modulesInfo']['powerList'] ) , 0 );
		//print_r( $GLOBAL['modulesInfo'] );
		$GLOBAL['htmlDefine']['replaceArray']['__MENUID__'] = $GLOBAL['runData']['menuID'];
		$GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], getDateTimeCombox( $year, $month, $day ) );
		if ( $GLOBAL[ 'runData' ][  'userData' ][  'influenceID' ] == -1 || 
			$GLOBAL[ 'runData' ][  'userData' ][  'siteID' ] == 8 )
			;
		else
			$subSql1 = ' siteID='.$GLOBAL[ 'runData' ][  'userData' ][  'siteID' ];
		if ( !Empty( $subSql ) && !Empty( $subSql1 ) )
			$subSql .= ' and '.$subSql1;
		$GLOBAL['htmlDefine']['replaceArray']['__OPTUSER__'] = getComboxFromSql( 'optUserID', 'select id, userName from webadmin.user '.( (!Empty( $subSql1 ) )?(' where '.$subSql1):''), $optUserID );
		$GLOBAL[ 'modulesInfo' ][ 'subSql' ] = $GLOBAL[ 'modulesInfo' ][ 'subSql' ].isset( $subSql ) ? $subSql : '';
		$GLOBAL[ 'modulesInfo' ][ 'splitPageLink '] = str_replace( "".$searchList, '', $GLOBAL['modulesInfo']['splitPageLink'] );
		//重定义翻页脚本以便于传参数
		$GLOBAL[ 'modulesInfo' ][ 'buttomStr' ] = "共__TOTALRECORD__条&nbsp;&nbsp;分__PAGECOUNT__页&nbsp;&nbsp;第__PAGENUM__页&nbsp;&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMFIRST__&__SEARCHLIST__'>首页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMPRE__&__SEARCHLIST__'>前页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMNEXT__&__SEARCHLIST__'>后页</a>&nbsp;<a href='__PAGELINK__&pagenum=__PAGENUMLAST__&__SEARCHLIST__'>尾页</a>";

		$GLOBAL[ 'modulesInfo' ][ 'buttomStr' ] = str_replace( "&__SEARCHLIST__", $searchList, $GLOBAL['modulesInfo']['buttomStr'] );		
		
	}
	
	
	//4226
?>