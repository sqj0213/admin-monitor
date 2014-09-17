<?php
define( 'ABS_CUR_DIR_USERMANAGER',	dirname(__FILE__).'/' );
require_once( ABS_CUR_DIR_USERMANAGER.'conf/conf.php' );

$menuID = $GLOBAL['runData']['menuID'];
$influenceID =  intval( $_SESSION['userData']['influenceID'] );
$opt = $GLOBAL['runData']['opt'];

$GLOBAL['modulesInfo']['influenceCheck'] = getModuleInfluenceSession( $opt );
	require_once( $moduleShowtmpl );
?>