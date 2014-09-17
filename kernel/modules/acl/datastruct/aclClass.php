<?php
define('ABS_CUR_DIR_ACL_DATASTRUCT',dirname(__FILE__).'/');
//require_once(ABS_CUR_DIR_ACL_DATASTRUCT.'../conf/conf.php');
require_once(ABS_CUR_DIR_ACL_DATASTRUCT."../../../function/parseString.php");

class aclClass extends treeDBClass
{
	function __construct( $influenceID )
	{
		parent::__construct( 0,"", $influenceID );

	}
	public function getPostData( $post=array() )
	{
		global $GLOBAL;
		$influenceList = parseStr( $GLOBAL['serverInfo']['influenceItemList'] );
		//print_r( $influenceList );
		$this->influenceData['influenceID'] = $post['influenceID'];
		//print_r( $post );
		//exit;
		$cnt = count( $post['tmenuID'] );
		for ( $i = 0; $i < $cnt; $i++ )
		{
			$this->influenceData[ $i ] = array();
			$this->influenceData[ $i ]['treemenuID'] = $post['tmenuID'][ $i ];
			while ( current( $influenceList ) !== false )
			{
				//echo $post[ key( $influenceList )."1" ][ $i ]."<br>";
				$this->influenceData[ $i ][ key( $influenceList ) ] = $post[ key( $influenceList )."1" ][ $i ];
				next( $influenceList );
			}
			$this->influenceData[ $i ][ 'customInfluenceItemList' ] = $post[ 'customInfluenceItemList1' ][ $i ];
			reset( $influenceList );
		}
		//print_r( $this->influenceData );
		//exit;
		return $this->influenceData;
	}
	public function getAclByMenuID( $menuID=0 )
	{
		if ( $menuID === 0 )
			return $this->menuData;
		else
			return $this->menuData[ $menuID ];
	}
	public function getSetUserPowerSql( $post=array() )
	{
		global $GLOBAL;
		$influenceList = parseStr( $GLOBAL['serverInfo']['influenceItemList'] );

		$this->getPostData( $post );
		$influenceID = $this->influenceData['influenceID'];
		$sqlStr = "delete from webadmin.userpower where influenceID=".$influenceID.";";
		while ( current( $this->influenceData ) !== FALSE )
		{
			if ( key( $this->influenceData ) !== "influenceID" )
			{
				$sqlStr=$sqlStr."insert into webadmin.userpower (treemenuID,influenceID";
				$tmpVal = $this->influenceData[ key( $this->influenceData ) ]['treemenuID'].",".$influenceID;
				while ( current( $influenceList ) !== false )
				{
					//$tmp1 =  current( $influenceList );
					$sqlStr .= ",".key( $influenceList );
					if ( key( $influenceList ) !== "customInfluenceList" )
						$tmpVal .= ",'".strval( intval( $this->influenceData[ key( $this->influenceData ) ][key( $influenceList )] ) )."'";
					else
						$tmpVal .= ",'".$this->influenceData[ key( $this->influenceData ) ][key( $influenceList )]."'";
					next( $influenceList );
				}
				reset( $influenceList );
				$sqlStr .= ",customInfluenceItemList";
				$sqlStr .= ") values(".$tmpVal.",'".$this->influenceData[ key( $this->influenceData ) ]['customInfluenceItemList']."');";
			}
			next( $this->influenceData );
		}
		reset( $this->influenceData );
		return $sqlStr;
	}

	public function getMergeDataHtml( $readonly=1 )
	{

	//	if ( array_key_exists( "editFlag", array("adFlag"=>0, "delFlag"=>0,"editFlag"=>0,"readFlag"=>0,"listFlag"=>0,"menuFlag"=>0,"editPower"=>0) ))
		//	echo "l=".__LINE__."<br>";
		
		$powerStr = "";

		if ( $readonly === 0 )
			$tmpVal = "disabled=true";
		else
			$tmpVal = "";
			$i = 0;
		$j = 0;//用于控制自定义权限的一组变量
		$checkedFlag = "";
		$checkedValue = 0;

		//print_r( $this->menuData );
	
		while ( current( $this->menuData ) !== FALSE )
		{
			$filterArray = array('addFlag'=>0, 'delFlag'=>0,'editFlag'=>0,'readFlag'=>0,'listFlag'=>0,'menuFlag'=>0,'editPower'=>0);
			$tmpArr = current( $this->menuData );

			$InfluenceList = array();
			$InfluenceList = parseStr( $this->menuData[ key( $this->menuData ) ]['InfluenceItemList'] );//取得模块定义时可以拥有定制的权限
			$tmpArray11 = $InfluenceList;
			$InfluenceList = array_merge( $InfluenceList, parseStr( $this->menuData[ key( $this->menuData ) ]['customInfluenceItemList']  ) );
			//print_r( $InfluenceList );
			//print_r( $tmpArr );
			//exit;
			$powerStr = $powerStr."<b>".$this->menuData[ key( $this->menuData ) ]['MenuName']."</b>权限管理<br><br>";
			$powerStr = $powerStr."<input type=hidden name=tmenuID[] value=\"". $this->menuData[ key( $this->menuData ) ]['MenuId']."\">";
			$powerStr = $powerStr."<input type=hidden name=customInfluenceItemList1[] value=\"". $this->menuData[ key( $this->menuData ) ]['customInfluenceItemList']."\">";
			$flag = false;//标识是否存在自定义的权限项
			while ( current( $InfluenceList ) !== false )
			{
				$checkedFlag = "";
				$checkedValue = 0;
				$tmp1 = current( $InfluenceList );

				if ( array_key_exists( key( $InfluenceList ), $tmpArray11 ))//若为非自定义权限字段
				{
					unset( $filterArray[ key( $InfluenceList ) ] );
					//print_r( $filterArray );
					//echo ":".key( $InfluenceList );
					//exit;
					if ( isset(  $tmpArr[ key( $InfluenceList ) ]  ) )
					{
						if ( $tmpArr[ key( $InfluenceList ) ] == 0 )//若无权限的话
						{
						//echo "l=".__LINE__.":".$tmpArr[ key( $InfluenceList ) ].":".$tmpArr['MenuEndFlag']."<br>";
							$checkedFlag = "";
							$checkedValue = '0';
						}
						else
						{

							$checkedFlag = " checked ";
							$checkedValue = '1';
						}
					}
					else
					{
						$checkedFlag = " checked ";
						$checkedValue = '1';
					}
					if ( $tmpArr['MenuEndFlag'] == 1 )//若为底层菜单,显示所有权限
					{
						if ( $tmp1[ 'value' ]  == 1 ) //若模块定义时提供权限选取功能的话就显示
						{
							$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=".key( $InfluenceList )."[] ".$tmpVal.$checkedFlag." onclick=\"javascript:chk_box2(this,".$i.",'',0,false);\">&nbsp;".$tmp1['name'];
						}
						$powerStr = $powerStr."<input type=hidden name=".key( $InfluenceList )."1[] value=\"".$checkedValue."\">";

					}
					else//若不是底层菜单则只显示是否显示菜单权限，同时置其它权限为空
					{
						if ( key( $InfluenceList ) == "menuFlag" )//若为菜单是否显示权限的话
						{
							$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=".key( $InfluenceList )."[] ".$tmpVal.$checkedFlag." onclick=\"javascript:chk_box2(this,".$i.",'',0,false);\">&nbsp;".$tmp1['name'];
							$powerStr = $powerStr."<input type=hidden name=".key( $InfluenceList )."1[] value=\"".$checkedValue."\">";
						}
						else
							$powerStr = $powerStr."<input type=hidden name=".key( $InfluenceList )."1[] value=\"0\">";
					}
				}
				else//自定义权限处理逻辑，i变量不自增
				{
					$flag = true;
					if ( $tmpArr['MenuEndFlag'] == 1 )//若为底层菜单则显示自定义权限，否则不显示自定义权限并置空值
					{
						if ( current( $tmp1 ) == 1 )
						{
							$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=".key( $InfluenceList )."[] checked onclick=\"javascript:chk_box2(this,".$i.",'".$tmp1['name']."',".$j.",true);\">&nbsp;".$tmp1['name'];
							$powerStr = $powerStr."<input type=hidden name=".key( $InfluenceList )."1[] value=\"1\">";
						}
						else
						{
							$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=".key( $InfluenceList )."[] onclick=\"javascript:;chk_box2(this,".$i.",'".$tmp1['name']."',".$j.", true);\">&nbsp;".$tmp1['name'];
							$powerStr = $powerStr."&nbsp;<input type=hidden name=".key( $InfluenceList )."1[] value=\"0\">";
						}
	
					}
					else
						$powerStr = $powerStr."&nbsp;<input type=hidden name=".key( $InfluenceList )."1[] value=\"0\">";
				}
				next( $InfluenceList );
			}
			//print_r( $filterArray );
			//exit;
			while ( current( $filterArray ) !== false )
			{
				//print_r( $filterArray );				
				$powerStr = $powerStr."&nbsp;<input type=hidden name=".key( $filterArray )."1[] value=\"0\">";
				next( $filterArray );
			}
			reset( $InfluenceList );

			$powerStr = $powerStr."<br><br>";
			if ( $flag )
				$j++;
			$i++;
			next( $this->menuData );
		}
		reset( $this->menuData );
		return $powerStr;
	}
	function __destruct()
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "f=".__FILE__.",l=".__LINE__."<br>";

		parent::__destruct();
	}
}
?>