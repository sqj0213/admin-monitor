<?php
	define( 'ABS_CUR_DIR_KEYVALUE', dirname( __FILE__ ).'/');
	require_once( ABS_CUR_DIR_KEYVALUE."conf/conf.php" );
		//检查权限
	$influenceID =  intval( $_SESSION['userData']['influenceID'] );
	$opt = $GLOBAL['runData']['opt'];
	$GLOBAL['modulesInfo']['influenceCheck'] = getModuleInfluenceSession( $opt );
	
	require_once( $moduleShowtmpl );
?>