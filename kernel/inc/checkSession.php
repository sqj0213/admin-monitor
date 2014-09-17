<?php
define( 'ABS_CUR_DIR_CHECKSESSION_INC', dirname( __FILE__ ).'/' );
require_once( ABS_CUR_DIR_CHECKSESSION_INC."conf.php" );
require_once( ABS_CUR_DIR_CHECKSESSION_INC."global.php" );

if ( $GLOBAL[ 'checkSession' ] && !defined( 'NOT_CHECK_SESSION' ) )
{
	session_start();

	if ( !isset( $_SESSION['userData']['uid'] ) )
	{
		header("Location:  ".$GLOBAL['serverInfo']['errorUrl'] );
		exit ;
	}

	$GLOBAL['runData']['userData'] = $_SESSION['userData'];
	global $appConf;
	


	if ((isset( $_REQUEST['app'] )) && ( $_REQUEST['app'] == 'logout' ))
	{
		session_destroy();
	}
	else
	{
		if ( $GLOBAL[ 'checkACL'] && $appConf['GLOBAL'][ 'checkACL' ] !== 'off' )
		{
			//print_r($appConf);
			//如果为默认页,菜单页,顶部头页则不检查权限

			if ( $_REQUEST['module'] !== 'mainFrame'&&$_REQUEST['module'] !== 'menu')
				$GLOBAL['runData']['influenceData'] = getModuleInfluenceSession( $GLOBAL['runData']['opt'] );
		}
	}
}
//print_r( getModuleInfluence( $GLOBAL['runData']['opt'] ) );
//exit;

?>