<?php
define('MODULE_NAME',											'web页面'	);
define('MODULE_NAME_EN_LOW',											'webPage'	);
define('ABS_CUR_PATH_CONF',				dirname( __FILE__ )."/" );
//require_once( ABS_CUR_PATH_CONF."../../../inc/conf.php" );

define('ROOT_PATH',	GLOBAL_ROOT_PATH.'/kernel/modules/'.MODULE_NAME_EN_LOW.'/'	);
//require_once(ABS_CUR_PATH_CONF.'../../../inc/global.php');
//equire_once(ABS_CUR_PATH_CONF.'../../../kernel/baselib/postPage.php');
//require_once(ABS_CUR_PATH_CONF.'../../../comm/formCheck.php');
$eventList = array();
//		initEvent( "initRegexDataArray", array( 0=>$mapData, 1=>'/(<!--mapdata1-->)([\s\S]*?)(<!--mapdata1-->)/i' ) );

function initEvent( $function, $paraArray )
{
	global $eventList;
	$eventLength = count( $eventList );
	if ( $eventLength == 0 )
	{
		$eventList[ 0 ]['func'] = $function;
		$eventList[ 0 ]['para'] = $paraArray;
	}
	else
	{
		$eventList[ $eventLength ]['func'] = $function;
		$eventList[ $eventLength ]['para'] = $paraArray;
	}
	global $webPage;
}
function runEvent( )
{
	//echo "l=".__LINE__."<br>";
	global $webPage;
	//print_r( $webPage );
	global $eventList;
	//print_r( $eventList );
	//exit;
	$eventLength = count( $eventList );
	for ( $i = 0; $i < $eventLength; $i++ )
	{
		//print_r( explode( $eventList[ $i ]['para']) );
		//if ( $eventList[ $i ]['func'] == "initRegexDataArray" )
			$webPage->$eventList[ $i ]['func']( $eventList[ $i ]['para'] );
	}
}

?>
