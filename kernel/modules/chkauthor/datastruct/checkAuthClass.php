<?php

/*
 * 认证与权限检查类
	1.实现登录后系统权限的检查功能
	2.实现用户拥有功能权限的读取功能

 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */

define( 'ABS_CHECKaUTHCLASS_CUR_DIR', dirname(__FILE__).'/' );
require_once( ABS_CHECKaUTHCLASS_CUR_DIR."../../../inc/global.php" );
require_once( ABS_CHECKaUTHCLASS_CUR_DIR."../../../function/userIP.php" );
class checkAuthClass
{
	private $loginame = "";
	private $passwd = "";
	private $runMsg = "";
	public $xmlArray = array();

	private $fieldList = "MenuId,MenuName,addFlag,delFlag,editFlag,readFlag,listFlag,menuFlag,editPower,customInfluenceItemList";//要显示的数据结构去除无用的数据结构
	public function __construct()
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__construct,f=".__FILE__.",l=".__LINE__."<br>";
	
	}
	public function __destruct()
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__destruct,f=".__FILE__.",l=".__LINE__."<br>";
	}
	public function setLoginame( $_loginame="" )
	{
		$this->loginame = $_loginame;
	}

	public function setPasswd( $_passwd="" )
	{
		$this->passwd = $_passwd;
	}
	public function getLoginame( )
	{
		return $this->loginame;
	}

	public function getPasswd( )
	{
		return $this->passwd;
	}
	private function filterArrayField( $filterArray = array() )
	{
		$retArray = array();
		if ( Empty( $filterArray ) )
			return $retArray;
		$tmpArr = explode( ",", $this->fieldList );

		$len = count( $tmpArr );
		//print_r( "asdfasdf");
		while ( current( $filterArray ) !== false )
		{
			if ( !is_array( current( $filterArray ) ) )
				return $retArray;
			$subArray = current( $filterArray );
			for ( $i = 0; $i < $len; $i++ )
			{
				if ( isset( $subArray[ $tmpArr[ $i ] ] ) )
					$retArray[ key( $filterArray ) ][ $tmpArr[ $i] ] =  $subArray[ $tmpArr[ $i ] ];
			}
			next( $filterArray );
		}

		return $retArray;
	}

	private function initAdminInfluence( &$row=array() )
	{
		global $GLOBAL;
		$tmp = parseStr( $GLOBAL['serverInfo']['influenceItemList'] );
		//print_r( current( $row ) );
		//exit;
		//超级管理员默认填加所有权限
		while ( current( $row ) !== false )
		{
			$row1 = array_merge( current( $row ), $tmp );
			if ( isset( $row1['InfluenceItemList'] ) )
				unset( $row1['InfluenceItemList'] );
			$row[ key( $row ) ] = $row1;
			next( $row );
		}
		reset( $row );
		//print_r( $row );
	}
	private function initInfluence( &$row=array() )
	{
		//print_r( $row );
		//exit;
		global $GLOBAL;
		//print_r( $GLOBAL['serverInfo']['influenceItemList'] );
		$filterInfluenceItemList = $GLOBAL['serverInfo']['influenceItemList'];
		$filterArray = parseStr( $filterInfluenceItemList );
		//print_r( $filterArray );
		while ( current( $row ) !== false )
		{
			
			$tmpRow = current( $row );
			/*
			//去除自定义菜单的操作
			if ( isset( $tmpRow['customInfluenceList'] ) )
			{
				$customInfluenceList = $tmpRow['customInfluenceList'];
				unset( $tmpRow['customInfluenceList'] );
			}
			*/
			if ( isset( $tmpRow['customInfluenceItemList'] ) )
			{
				$tmpRow1 = parseStr( $tmpRow['customInfluenceItemList'] );

				while ( current( $tmpRow1 ) !== false )//解析系统分配给此菜单的所有可操作权限
				{
					//print_r( $tmpRow1 );
					if ( isset( $tmpRow[ key( $tmpRow1 ) ] ) )
						$tmpRow1[ key( $tmpRow1 ) ]['value'] = $tmpRow[ key( $tmpRow1 ) ];//把此角色的用户的真实权限进行赋值
					else
						$tmpRow1[ key( $tmpRow1 ) ] = current( $tmpRow1 );//把此角色的用户的真实权限进行赋值
					next( $tmpRow1 );
				}
				reset( $tmpRow1 );
				//print_r( $tmpRow['InfluenceItemList'] );
				//print_r( $tmpRow1 );
				//exit;
				unset( $tmpRow['customInfluenceItemList'] );//去除此菜单的最高权限无素
				$tmpRow2 = array_merge( $tmpRow, $tmpRow1 );
				$tmpRow = $tmpRow2;
			}
			$tmpArr1 = array();
			while( current( $filterArray ) !== false )
			{
				
				if ( isset(  $tmpRow[ key( $filterArray ) ] ) )
				{
					$tmpArr1[ key( $filterArray ) ]['value'] = $tmpRow[ key( $filterArray ) ];
					$tmpArr1[ key( $filterArray ) ]['name'] = $filterArray[ key( $filterArray ) ]['name'];
					$tmpArr1[ key( $filterArray ) ]['style'] = $filterArray[ key( $filterArray ) ]['style'];
				}
				else
				{
					$tmpArr1[ key( $filterArray ) ]['name'] = $filterArray[ key( $filterArray ) ]['name'];
					$tmpArr1[ key( $filterArray ) ]['style'] = $filterArray[ key( $filterArray ) ]['style'];
					$tmpArr1[ key( $filterArray ) ]['value'] = 0;
				}
				unset( $tmpRow[ key( $filterArray ) ] );
				next( $filterArray );
			}
			reset( $filterArray );
			if ( !Empty( $tmpArr1 ) )
			{
				$tmpRow2 = array_merge( $tmpRow, $tmpArr1 );
				$tmpRow = $tmpRow2;
			}
			
			//print_r( $tmpRow );
			/*
			//若此菜单此角色有自定义的权限
			if ( isset( $customInfluenceList ) && !Empty(  $customInfluenceList ) )
			{
				//print_r( $customInfluenceList );
				$tmpRow1 = parseStr( $customInfluenceList );
				//print_r( $tmpRow1 );
				//exit;
				if ( !Empty( $tmpRow1 ) )
				{
					$tmpRow2 = array_merge( $tmpRow, $tmpRow1 );
					$tmpRow = $tmpRow2;
				}
			}
			*/
			$row[ key( $row ) ] = $tmpRow;//回写权限菜单
			next( $row );
		}
		//exit;
		reset( $row );
	}
	public function setSession( $result=array() )
	{
		global $GLOBAL;
		//print_r( $result );
		//exit;
		session_start();
		$GLOBAL['runData']['sessionID'] = session_id();
		if ( $result['uid'] == $GLOBAL['admin'] )
		{
			$_SESSION['userData']['influenceID'] = -1;
			$result['influenceID'] = -1;
		}
		else
			$_SESSION['userData']['influenceID'] = $result['influenceID'];
		$_SESSION['userData'] = $result;
		//print_r( $result );
		//exit;
		//print_r( "l=".__LINE__."<br>");		print_r( $_SESSION );
		//print_r( "l=".__LINE__."<br>");
		//print_r( $result );
		//echo "adsfadsf";
		//print_r( $GLOBAL['admin'] );
		//exit;
		$_SESSION['userData']['ip'] = getClientIP();
		$_SESSION['influenceData'] = $this->xmlArray['influenceStruct'];
		$this->xmlArray['sessionID'] = $GLOBAL['runData']['sessionID'];
	}
	//用于处理自定义权限
	public function rebuildAcl( $tmpArray=array() )
	{
		
	}
	public function checkAuth( )
	{
		global $GLOBAL;
		$sqlString = "select * from webadmin.user where uid='".$this->loginame."' and passwd='".$this->passwd."' limit 1";
		$result = $GLOBAL['G_DB_OBJ']->executeSql( $sqlString );

		//print_r( $sqlString );
		//exit;
		if ( $this->loginame == $GLOBAL['admin'] )//若为超级管理员的话则置为最高权限
			$result[ 'influenceID' ] = -1;
			

		$this->xmlArray['loginame'] = $this->loginame;
		$this->xmlArray['passwd'] = $this->passwd;

		if ( Empty( $result ) )
		{
			$this->xmlArray['result'] = 0;
			$this->xmlArray['message'] = 'auth failed!('.$this->loginame.','.$this->passwd.')';
			return ;
		}
		$this->xmlArray['result'] = 1;
		$this->xmlArray['message'] = 'auth success!('.$this->loginame.',********)';
		$this->xmlArray['dataStruct'] = $result;
		//print_r( $this->xmlArray['dataStruct'] );
		//echo "l=".__LINE__."<br>";
		//exit;
		$this->getInfluenceModule( $result[ 'influenceID' ] );
	}
	public function getInfluenceModule( $influenceID=0 )
	{
		
		if ( isset( $_SESSION['influenceData'] ) )
		{
		//print_r( $influenceID );
		//print_r( $this->xmlArray['dataStruct'] );
		//print_r( $_SESSION['influenceData'] );
		//exit;
			$this->xmlArray['influenceStruct'] = $_SESSION['influenceData'];
			return ;
		}
		
		//print_r( $influenceID );
		//exit;
		$influence = new aclClass( $influenceID );
		$menuArray = $influence->getAclByMenuID(  );

		$aclArray = $this->filterArrayField( $menuArray );//过滤所有无用的字段
		//print_r( $aclArray );
		//exit;

		if ( $influenceID == -1 )//若为超级管理员的话，则打开所有的权限
		{
			//print_r( $aclArray );
			//exit;
			$this->initAdminInfluence( $aclArray );//填充超级管理员权限
			$aclArray['allModulesAllowed']['name'] = '所有附加权限';
			$aclArray['allModulesAllowed']['value'] = 1;
			//unset( 
			//print_r( $aclArray );
			//exit;
		}
		else
		{
			$this->initInfluence( $aclArray );
			$aclArray['allModulesAllowed']['name'] = '所有附加权限';
			$aclArray['allModulesAllowed']['value'] = 0;
		}
		//print_r( $aclArray );
		//exit;
		//其它角色的成员需要查询数据库决定
		$this->xmlArray['influenceStruct'] = $aclArray;	
	}

}
?>