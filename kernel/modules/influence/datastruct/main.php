<?php
define('ABS_CUR_DIR_USERMANAGER_DATASTRUCT',dirname(__FILE__).'/');
require_once(ABS_CUR_DIR_USERMANAGER_DATASTRUCT.'../conf/conf.php');
//require_once(ABS_CUR_DIR_USERMANAGER_DATASTRUCT.'../../comm/pagelist.php');
//require_once(ABS_CUR_DIR_USERMANAGER_DATASTRUCT."../../baselib/db_base_class.php");

class influence extends tree_db_class
{

	function __construct( $influenceID )
	{
		parent::__construct( 0,"", $influenceID );

	}
	public function getPostData( $post=array() )
	{
		$this->influenceData['influenceID'] = $post['influenceID'];
	   print_r( $post );
	   exit;
		for ( $i = 0; $i < count( $post['tmenuID'] ); $i++ )
		{
			$this->influenceData[ $i ] = array();
			$this->influenceData[ $i ]['treemenuID'] = $post['tmenuID'][ $i ];
			$this->influenceData[ $i ]['readFlag'] = $post['readFlag1'][ $i ];
			$this->influenceData[ $i ]['editFlag'] = $post['editFlag1'][ $i ];
			$this->influenceData[ $i ]['delFlag'] = $post['delFlag1'][ $i ];
			$this->influenceData[ $i ]['addFlag'] = $post['addFlag1'][ $i ];
			$this->influenceData[ $i ]['listFlag'] = $post['listFlag1'][ $i ];
			$this->influenceData[ $i ]['checkFlag'] = $post['checkFlag1'][ $i ];
			$this->influenceData[ $i ]['menuFlag'] = $post['menuFlag1'][ $i ];
			$this->influenceData[ $i ]['editPower'] = $post['editPower1'][ $i ];
			$this->influenceData[ $i ]['advanceFlag'] = $post['advanceFlag1'][ $i ];
			$this->influenceData[ $i ]['balanceFlag'] = $post['balanceFlag1'][ $i ];
			$this->influenceData[ $i ]['prtFlag'] = $post['prtFlag1'][ $i ];
			$this->influenceData[ $i ]['openFlag'] = $post['openFlag1'][ $i ];
			$this->influenceData[ $i ]['closeFlag'] = $post['closeFlag1'][ $i ];
			$this->influenceData[ $i ]['editDispatchFlag'] = $post['editDispatchFlag1'][ $i ];
			$this->influenceData[ $i ]['prtFlag'] = $post['prtFlag1'][ $i ];
			$this->influenceData[ $i ]['resetPwd'] = $post['resetPwd1'][ $i ];
			$this->influenceData[ $i ]['siteFlag'] = $post['siteFlag1'][ $i ];
		}
		return $this->influenceData;
	}
	public function getSetUserPowerSql( $post=array() )
	{
		$this->getPostData( $post );
		$influenceID = $this->influenceData['influenceID'];
		$sqlStr = "delete from userpower where influenceID=".$influenceID.";";
		//print_r( $this->influenceData );
		//exit;
		while ( current( $this->influenceData ) !== FALSE )
		{
			if ( key( $this->influenceData ) !== "influenceID" )
			{
				$sqlStr=$sqlStr."insert into userpower (treemenuID,influenceID,readFlag,editFlag,delFlag,addFlag,listFlag,checkFlag,menuFlag,editPower,advanceFlag,balanceFlag,prtFlag,resetPwd,openFlag,closeFlag,editDispatchFlag,siteFlag) values(".$this->influenceData[ key( $this->influenceData ) ]['treemenuID'].",".$influenceID.",".$this->influenceData[ key( $this->influenceData ) ]['readFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['editFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['delFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['addFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['listFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['checkFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['menuFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['editPower'].",".$this->influenceData[ key( $this->influenceData ) ]['advanceFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['balanceFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['prtFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['resetPwd'].",".$this->influenceData[ key( $this->influenceData ) ]['openFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['closeFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['editDispatchFlag'].",".$this->influenceData[ key( $this->influenceData ) ]['siteFlag'].");";
			}
			next( $this->influenceData );
			echo $sqlStr."<br><br>";
		}
		//exit;
		reset( $this->influenceData );
		return $sqlStr;
	}

	public function getMergeDataHtml( $readonly=1 )
	{

		//$menuClass = new tree_db_class( 0, " and influenceFlag = 1 " );
		//echo "aaaaaaaaaaaaaaaaaaaaaaaaa<br><br>";

		print_r( $this->menuData );
		echo "aaaaaaaaaaaaaaaaaaaaaaaaa<br><br>";
		//exit;
		//echo "aaaaaaaaaaaaaaaaaaaaaaaaa<br><br>";
		$powerStr = "";

		if ( $readonly === 0 )
			$tmpVal = "disabled=true";
		else
			$tmpVal = "";
			$i = 0;
			//print_r( $this->menuData );
		while ( current( $this->menuData ) !== FALSE )
		{
			$tmpArr = current( $this->menuData );
			$powerStr = $powerStr."<b>".$this->menuData[ key( $this->menuData ) ]['MenuName']."</b>权限管理<br><br>";
			if ( $tmpArr['readFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=readFlag[] ".$tmpVal." onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;读权限";
				$powerStr = $powerStr."<input type=hidden name=readFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=readFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;读权限";
				$powerStr = $powerStr."<input type=hidden name=readFlag1[] value=\"1\">";
			}
			$powerStr = $powerStr."<input type=hidden name=tmenuID[] value=\"". $this->menuData[ key( $this->menuData ) ]['MenuId']."\">";
			if ( $tmpArr['editFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;编辑权限";
				$powerStr = $powerStr."<input type=hidden name=editFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;编辑权限";
				$powerStr = $powerStr."<input type=hidden name=editFlag1[] value=\"1\">";
			}
			if ( $tmpArr['delFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=delFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;删除权限";
				$powerStr = $powerStr."<input type=hidden name=delFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=delFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;删除权限";
				$powerStr = $powerStr."<input type=hidden name=delFlag1[] value=\"1\">";
			}
			if ( $tmpArr['addFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=addFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;填加权限";
				$powerStr = $powerStr."<input type=hidden name=addFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=addFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;填加权限";
				$powerStr = $powerStr."<input type=hidden name=addFlag1[] value=\"1\">";
			}
			if ( $tmpArr['listFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=listFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;列表权限";
				$powerStr = $powerStr."<input type=hidden name=listFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=listFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;列表权限";
				$powerStr = $powerStr."<input type=hidden name=listFlag1[] value=\"1\">";
			}
			if ( $tmpArr['checkFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=checkFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;审核权限";
				$powerStr = $powerStr."<input type=hidden name=checkFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=checkFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;审核权限";
				$powerStr = $powerStr."<input type=hidden name=checkFlag1[] value=\"1\">";
			}
			if ( $tmpArr['menuFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=menuFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;显示菜单权限";
				$powerStr = $powerStr."<input type=hidden name=menuFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=menuFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;显示菜单权限";
				$powerStr = $powerStr."<input type=hidden name=menuFlag1[] value=\"1\">";
			}
			if ( $tmpArr['editPower'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editPower[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许编辑权限";
				$powerStr = $powerStr."<input type=hidden name=editPower1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editPower[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许编辑权限";
				$powerStr = $powerStr."<input type=hidden name=editPower1[] value=\"1\">";
			}
			//print_r( $tmpArr );
			//exit;
			if ( $tmpArr['advanceFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=advanceFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许预存话费";
				$powerStr = $powerStr."<input type=hidden name=advanceFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=advanceFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许预存话费";
				$powerStr = $powerStr."<input type=hidden name=advanceFlag1[] value=\"1\">";
			}
			if ( $tmpArr['balanceFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=balanceFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许结算";
				$powerStr = $powerStr."<input type=hidden name=balanceFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=balanceFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;允许结算";
				$powerStr = $powerStr."<input type=hidden name=balanceFlag1[] value=\"1\">";
			}
			if ( $tmpArr['prtFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=prtFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;打印";
				$powerStr = $powerStr."<input type=hidden name=prtFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=prtFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;打印";
				$powerStr = $powerStr."<input type=hidden name=prtFlag1[] value=\"1\">";
			}
			if ( $tmpArr['resetPwd'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=resetPwd[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;重置密码";
				$powerStr = $powerStr."<input type=hidden name=resetPwd1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=resetPwd[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;重置密码";
				$powerStr = $powerStr."<input type=hidden name=resetPwd1[] value=\"1\">";
			}
			if ( $tmpArr['openFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=openFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;开启用户";
				$powerStr = $powerStr."<input type=hidden name=openFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=openFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;开启用户";
				$powerStr = $powerStr."<input type=hidden name=openFlag1[] value=\"1\">";
			}
			if ( $tmpArr['closeFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=closeFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;关闭用户";
				$powerStr = $powerStr."<input type=hidden name=closeFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=closeFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;关闭用户";
				$powerStr = $powerStr."<input type=hidden name=closeFlag1[] value=\"1\">";
			}
			if ( $tmpArr['editDispatchFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editDispatchFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;分配网段";
				$powerStr = $powerStr."<input type=hidden name=editDispatchFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=editDispatchFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;分配网段";
				$powerStr = $powerStr."<input type=hidden name=editDispatchFlag1[] value=\"1\">";
			}
			if ( $tmpArr['siteFlag'] == 0 )
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=siteFlag[] ".$tmpVal."  onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;站点定义";
				$powerStr = $powerStr."<input type=hidden name=siteFlag1[] value=\"0\">";
			}
			else
			{
				$powerStr = $powerStr."&nbsp;&nbsp;<input type=checkbox name=siteFlag[] ".$tmpVal."  checked onclick=\"javascript:chk_box2(this,".$i.");\">&nbsp;站点定义";
				$powerStr = $powerStr."<input type=hidden name=siteFlag1[] value=\"1\">";
			}
			$powerStr = $powerStr."<br><br>";
			$i++;
			next( $this->menuData );
		}
		reset( $this->menuData );
		return $powerStr;
	}
	function __destruct()
	{
		parent::__destruct();
	}
}
?>