<?php
/*应用站点的展现模块,所有的应用显示时都需要调用此程序
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
define( 'ABS_LOADMODULES_CUR_DIR', dirname(__FILE__).'/' );
require_once( ABS_LOADMODULES_CUR_DIR.'../inc/conf.php' );
require_once( ABS_LOADMODULES_CUR_DIR.'../function/fileOperation.php' );

function loadModules( $modulesName, &$errMsg="success" )
{
	global $GLOBAL;
	$dirList = Dirs::getFiles( $GLOBAL['serverInfo']['siteStruct']['modulesPath'].$modulesName );
	if (   !isset( $dirList[ "conf" ] ) 
		|| !isset( $dirList[ "datastruct" ] )
		|| !isset( $dirList[ "sql" ] ) 
		|| !isset( $dirList[ "tmpl" ] )
		|| !isset( $dirList[ "showtmpl.php" ] )
		)
	{
		print_r( $GLOBAL['serverInfo']['siteStruct']['modulesPath'] );
		$errMsg = "模块\"".$modulesName."\"定义无效!";
		echo $errMsg;
		exit;
	}
	//echo "l=".__LINE__."<br>";
//	include( $GLOBAL['serverInfo']['siteStruct']['modulesPath'].$modulesName."/conf/conf.php" );
	return $GLOBAL['serverInfo']['siteStruct']['modulesPath'].$modulesName."/showtmpl.php";
}
?>