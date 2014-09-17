<?php
define('ABS_CUR_DIR_CHKAUTHOR', dirname(__FILE__).'/');
include_once( ABS_CUR_DIR_CHKAUTHOR.'conf/conf.php' );
$tmplHtml = new formCheck( $GLOBAL['modulesInfo']['tmplPath'] ); 
try
{
	//print_r( $GLOBAL );
	echo  $tmplHtml->getHtmlCode( $GLOBAL['modulesInfo']['formAction'] );
}catch( Exception $e )
{
	echo $e->getMessage( );
}
?>