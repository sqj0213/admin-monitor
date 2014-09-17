<?php
define( 'ABS_CUR_DIR', dirname(__FILE__).'/' );
require_once( ABS_CUR_DIR."../../../kernel/inc/conf.php" );
require_once( ABS_CUR_DIR."../../../kernel/inc/global.php" );

$loginApi = new checkAuthClass;
$loginApi->setLoginame( "administrator" );
$loginApi->setPasswd( "asdfasdf" );
$loginApi->checkAuth();
$loginApi->getInfluenceModule( 51 );
$loginApi->setSession( $loginApi->xmlArray['dataStruct'] );
$xmlOBJ = new XML();
$xmlOBJ->printXML( $loginApi->xmlArray );
/*
/*
class aa1
{
	function aa1()
	{
	}
}
if ( $b == "aa1 Object ( )"  )
	echo "asdfasdfasdfas";
$b = new aa1();
$b = 1;
echo get_class( $b );
//echo gettype( $b );
*/
?>