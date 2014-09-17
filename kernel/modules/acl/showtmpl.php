<?php
define( 'ABS_CUR_DIR_ACL_SHOWTMPL',	dirname(__FILE__).'/' );
require_once( ABS_CUR_DIR_ACL_SHOWTMPL."../../inc/checkSession.php" );
require_once( ABS_CUR_DIR_ACL_SHOWTMPL.'conf/conf.php' );


$menuID = $GLOBAL['runData']['menuID'];
$influenceID =  intval( $_SESSION['userData']['influenceID'] );
$opt = $GLOBAL['runData']['opt'];

//$GLOBAL['modulesInfo']['influenceCheck'] = getModuleInfluence( $opt );

	require_once( $moduleShowtmpl );
?>