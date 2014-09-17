<?php
/*
 *对头菜单处理类
	1.提供右键树型菜单的增,删,改功能
	2.树形菜单支持无限级递归
	3.提供右键树型菜单的链接自定义功能
	4.与checkAuth属于紧耦合模块,与其协作可以实现不能的权限
	5.支持系统预置功能权限的定义
	6.支持系统自定义权限
 *
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */


define ( 'ABS_CUR_DIR_MENU_DATASTRUCT', dirname( __FILE__ )."/" );
require_once ABS_CUR_DIR_MENU_DATASTRUCT."../../../baselib/DBBaseClass.php";

class treeDBClass
{
	private $tree_pic = array(
							'plus_img_0'	=>'./cssimg/tree_plus.gif',	//中+
							'plus_img_1'	=>'./cssimg/tree_plus1.gif',	//底+
							'minus_img_0'	=>'./cssimg/tree_minus.gif',	//中-
							'minus_img_1'	=>'./cssimg/tree_minusl.gif',	//底-
							'blank_img_0'	=>'./cssimg/tree_blank.gif',	//中空
							'blank_img_1'	=>'./cssimg/tree_blank1.gif',	//底空
							'line_img'		=>'./cssimg/tree_line.gif',		//连接竖线
							'query_img_0'	=>'./cssimg/info_query.gif',		//未展开图标
							'query_img_1'	=>'./cssimg/info_query1.gif',		//展开后图标
							'query_img_2'	=>'./cssimg/info_query2.gif',		//叶子图标
							'css'			=>'./cssimg/style.css'
								);
	private $sqlstr= '';
	private $menuLevel = 0;									//默认菜单层级
	private $menuId = 0;									//默认菜单顶层id号
	private $selfMenu = 1;
	private $topMenuID = 1;									//顶层结点id号
	public $menuData=array(
						/*
						'MenuId'=>array(					//用menuId做为数组的下标
						'MenuId'=>0,								//用menuId做为数组的下标
						'MenuName'=>'test',						//菜单名称
						'MenuPId'=>0,						//菜单父id,即上一层菜单数组的下标，若为0，则表示一级菜单
						'MenuLevel'=>0,						//菜单的层级，为0表示一级
						'MenuEndFlag'=>1,					//菜单是否为最底层菜单,1表示度层,0表示非底层
						'MenuLink'=>'../blank.php?flag=1',	//菜单的链接地址
						'regTime'=>'2007-04-12 09:18:32',		//菜单的填加与修改时间
						'subTreeList'=>'',
						'lastNode'=>0						
						)*/
						);
	public $influenceID = 0;
	public $influenceArr = array(	0=>array	(	'id'=>0,
												'treemenuID'=>0,//菜单id号
												'influenceID'=>0,//角色id号
												'addFlag'=>0,//是否有填加权限
												'delFlag'=>0,//是否有删除权限
												'editFlag'=>0,//是否有编辑权限
												'readFlag'=>0,//是否有读取单个记录权限
												'listFlag'=>0,//是否有列表权限
												'menuFlag'=>0,//是否显示菜单
												'editPower'=>0,//是否显示分配权限按钮
												'InfluenceItemList'=>'',//是否显示菜单
												'customInfluenceItemList'=>'',
												'regTime'=>'2007-12-12 01-01-01'
											)
							);
	public $influenceData = array	( 
								'influenceID'=>0,//角色id号
								0=>array	(
												'treemenuID'=>0,//菜单id号
												'addFlag'=>0,//是否有填加权限
												'delFlag'=>0,//是否有删除权限
												'editFlag'=>0,//是否有编辑权限
												'readFlag'=>0,//是否有读取单个记录权限
												'listFlag'=>0,//是否有列表权限
												'menuFlag'=>0,//是否显示菜单
												'editPower'=>0,//是否显示分配权限按钮
												'InfluenceItemList'=>0,//是否显示菜单
												'customInfluenceItemList'=>'',
												'regTime'=>'2007-12-12 01-01-01'
											)
							);

	public function __construct( $MenuId=0, $subSqlStr="", $influenceID=0 )
	{

		global $GLOBAL;
		global $menu_pic;
		global $selfMenu;
		$this->topMenuID = $MenuId;
		$this->selfMenu = intval( $selfMenu );
		$this->tree_pic=$menu_pic;
		$this->sqlstr = $this->getSqlPre().$MenuId;
		$this->menuLevel = $GLOBAL['G_DB_OBJ']->getFieldValue( 'select MenuLevel from webadmin.treemenu where MenuId='.$MenuId.' '.$subSqlStr );
		$this->buildTreeArr( $this->getSqlPre().$MenuId, $subSqlStr );


		$this->mergeInfluenceData( $influenceID );

		if ( $this->menuLevel === '' )
		{
			 $this->menuLevel = 0;
		}
	}

	public function mergeInfluenceData( $influenceID1=0 )
	{
		global $GLOBAL;
//		if ( $this->influenceID !== $influenceID1 && $influenceID1 !==  -1 )
//		{
			$this->influenceID = $influenceID1;
			$this->influenceArr = array();
			$this->getUserPower( $influenceID1 );

//		}
		//echo "INFLUENCEID=".$influenceID."<BR><BR>";
		/*
		*/
		//print_r( $this->menuData );
		if ( $this->influenceID ==  -1 )
		{
			while ( current( $this->menuData ) !== FALSE )
			{
			//echo "INFLUENCEID=".$influenceID."<BR><BR>";
				$tmp = current( $this->menuData );
				$this->menuData[ key( $this->menuData ) ]['influenceID'] = $this->influenceID;
				$this->menuData[ key( $this->menuData ) ]['addFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['delFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['editFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['readFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['listFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['menuFlag'] = 1;
				$this->menuData[ key( $this->menuData ) ]['editPower'] = 1;
				//$this->menuData[ key( $this->menuData ) ]['InfluenceItemList'] = $GLOBAL['serverInfo']['influenceItemList'];
				//$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] = '';
				//$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] = '';
				$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] = '';
				
				next( $this->menuData );
			}
			reset( $this->menuData );
			return ;
		}
		if ( current( $this->influenceArr ) === FALSE )
		{
			while ( current( $this->menuData ) !== FALSE  )
			{
				$tmp = current( $this->menuData );
				 $this->menuData[ key( $this->menuData ) ]['influenceID'] = $this->influenceID;
				 $this->menuData[ key( $this->menuData ) ]['addFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['delFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['editFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['readFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['listFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['menuFlag'] = 0;
				 $this->menuData[ key( $this->menuData ) ]['editPower'] = 0;
				//$this->menuData[ key( $this->menuData ) ]['InfluenceItemList'] = $GLOBAL['serverInfo']['influenceItemList'];
				//业务逻辑改为权限只允许开发人员进行预置,不许产品人员参与
				//$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] = '';
				$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] = $tmp['customInfluenceItemList'];
				 next( $this->menuData );
			}
			reset( $this->menuData );
			return ;
		}
		while (	current( $this->influenceArr ) !== FALSE )
		{
			$tmpArr1 = current( $this->influenceArr );
			//print_r( $tmpArr1 );
			if ( isset( $this->menuData[ $tmpArr1['treemenuID'] ] ) )
			{
				//echo "INFLUENCEID1=".$influenceID1."<BR><BR>";

				$this->menuData[ $tmpArr1['treemenuID'] ]['influenceID'] = $this->influenceID;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['addFlag'] = $tmpArr1['addFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['delFlag'] = $tmpArr1['delFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['editFlag'] = $tmpArr1['editFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['readFlag'] = $tmpArr1['readFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['listFlag'] = $tmpArr1['listFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['listFlag'] = $tmpArr1['listFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['menuFlag'] = $tmpArr1['menuFlag'];
				 $this->menuData[ $tmpArr1['treemenuID'] ]['editPower'] = $tmpArr1['editPower'];
				//$this->menuData[ key( $this->menuData ) ]['InfluenceItemList'] = $tmpArr1['influenceItemList'];
				 if ( !Empty( $tmpArr1['customInfluenceItemList'] ) )
				 	$this->menuData[ $tmpArr1['treemenuID'] ]['customInfluenceItemList'] = $tmpArr1['customInfluenceItemList'];
			}else
			{
				 $this->menuData[ $tmpArr1['treemenuID'] ]['influenceID'] = $this->influenceID;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['addFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['delFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['editFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['readFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['listFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['menuFlag'] = 0;
				 $this->menuData[ $tmpArr1['treemenuID'] ]['editPower'] = 0;
				// $this->menuData[ key( $this->menuData ) ]['InfluenceItemList'] = $GLOBAL['serverInfo']['influenceItemList'];
				$this->menuData[ key( $this->menuData ) ]['customInfluenceItemList'] =  '';
			}
			 next( $this->influenceArr );
		}
		reset( $this->influenceArr );
	}

	public function getTreeNode( $MenuId )
	{
		return $this->menuData[$MenuId];
	}
	
	protected function getNodeTmpl()
	{
		return array(0=>array(					//用menuId做为数组的下标
					 0=>0,								//用menuId做为数组的下标
					'MenuName'=>'test',						//菜单名称
					'MenuPId'=>0,						//菜单父id,即上一层菜单数组的下标，若为0，则表示一级菜单
					'MenuLevel'=>0,						//菜单的层级，为0表示一级
					'MenuEndFlag'=>'1',					//菜单是否为最底层菜单,1表示度层,0表示非底层
					'MenuLink'=>'../blank.php?flag=1',	//菜单的链接地址
					'SortValue'=>1,	//显示顺序号
					'regTime'=>date(),		//菜单的填加与修改时间
					'subTreeList'=>'',
					'InfluenceItemList'=>'',
					'customInfluenceItemList'=>'',
					 'lastNode'=>0
						)
					);
	}
	
	protected function getDBNode( $MenuId )
	{
		//print_r ($this->menuData[$MenuId]);
		$tmp_arr = array();
		$tmp_arr['MenuName'] = $this->menuData[$MenuId]['MenuName'];
		$tmp_arr['MenuLevel'] = intval( $this->menuData[$MenuId]['MenuLevel'] );
		$tmp_arr['MenuEndFlag'] = $this->menuData[$MenuId]['MenuEndFlag'];
		$tmp_arr['InfluenceItemList'] = strval($this->menuData[$MenuId]['InfluenceItemList']);
		$tmp_arr['customInfluenceItemList'] = strval($this->menuData[$MenuId]['customInfluenceItemList']);
		
		$tmp_arr['MenuPId'] = intval( $this->menuData[$MenuId]['MenuPId'] );
		$tmp_arr['MenuLink'] = $this->menuData[$MenuId]['MenuLink'];
		$tmp_arr['SortValue'] = intval( $this->menuData[$MenuId]['SortValue'] );
		$tmp_arr['regTime'] = $this->menuData[$MenuId]['regTime'];
		return $tmp_arr;
	}
	
	private function delNode( $tmp_arr )
	{
		global $GLOBAL;

		$GLOBAL['G_DB_OBJ']->executeSql( $GLOBAL['G_DB_OBJ']->getDBSql( 'webadmin.treemenu', $tmp_arr, 'delete' ).' where MenuId='.$tmp_arr['MenuId'] );
		if ( $GLOBAL['G_DB_OBJ']->getFieldValue('select MenuId from webadmin.treemenu where MenuPid='.$tmp_arr['MenuPId']) === '' )
		{
			$GLOBAL['G_DB_OBJ']->executeSql('update webadmin.treemenu set MenuEndFlag=\'1\' where MenuId='.$tmp_arr['MenuPId'] ); 
		}
	}
	public function getUserPower( $influenceID=0 )
	{
		global $GLOBAL;
		$sqlStr = "select * from webadmin.userpower where influenceID=".$influenceID;//取用户权限表里的已经分配的权限数据
		$this->influenceArr = $GLOBAL['G_DB_OBJ']->executeSqlMap( $sqlStr );
	}

	public function getInfluenceArr1()
	{
		return $this->influenceArr;
	}
	private function insNode( $tmp_arr )
	{
		//print_r ( $tmp_arr );
		//echo $this->menuData[$tmp_arr['MenuPId']]['MenuEndFlag'].'<br><br>';
		//exit;
		global $GLOBAL;
		//print_r( $GLOBAL['G_DB_OBJ'] );
		$GLOBAL['G_DB_OBJ']->executeSql( $GLOBAL['G_DB_OBJ']->getDBSql( 'webadmin.treemenu', $tmp_arr, 'insert' ) );
		if ( intval( $tmp_arr['MenuPId'] ) !== 0 )
//		if ( isset( $this->menuData[$tmp_arr['MenuPId']]['MenuEndFlag'] ) )
		if ( intval( $this->menuData[$tmp_arr['MenuPId']]['MenuEndFlag'] ) === 1 )
			$GLOBAL['G_DB_OBJ']->executeSql( 'update webadmin.treemenu set MenuEndFlag=\'0\' where MenuId='.$tmp_arr['MenuPId'] );
	}

	private function updNode( $tmp_arr )
	{
		global $GLOBAL;
		//echo $this->getDBSql( 'treemenu', $tmp_arr, 'update' ).' where MenuId='.$tmp_arr['MenuId']."<BR><BR>";
		//print_r( $tmp_arr );
		//	exit;
		$GLOBAL['G_DB_OBJ']->executeSql( $GLOBAL['G_DB_OBJ']->getDBSql( 'webadmin.treemenu', $tmp_arr, 'update' ).' where MenuId='.$tmp_arr['MenuId'] );
	}
	
	//add,upd,del tree node to db
	public function updTreeNode( $node_arr, $opt_type )
	{
		//print_r( $node_arr );
		//exit;
		$tmp_arr =  $this->getDBNode( $node_arr['MenuId'] );
		switch ( $opt_type )
		{
			case MENU_ADD_SAVE:
				$tmp_arr['MenuName'] = $node_arr['MenuName'];
				$tmp_arr['MenuLink'] = $node_arr['MenuLink'];
				$tmp_arr['InfluenceItemList'] = $node_arr['InfluenceItemList'];
				$tmp_arr['customInfluenceItemList'] = $node_arr['customInfluenceItemList'];
				$tmp_arr['SortValue'] = $node_arr['SortValue'];

				$tmp_arr['regTime'] = date('Y-m-d H:m:s');
				$tmp_arr['MenuEndFlag'] = '1';
				$this->insNode( $tmp_arr );
				break;
			case MENU_ADD_SUB_SAVE:
				$tmp_arr['MenuName'] = $node_arr['MenuName'];
				$tmp_arr['MenuLink'] = $node_arr['MenuLink'];
				$tmp_arr['SortValue'] = $node_arr['SortValue'];
				$tmp_arr['InfluenceItemList'] = $node_arr['InfluenceItemList'];
				$tmp_arr['customInfluenceItemList'] = $node_arr['customInfluenceItemList'];
				$tmp_arr['MenuPId'] =  $node_arr['MenuId'];
				$tmp_arr['MenuEndFlag'] = '1';
				$tmp_arr['MenuLevel'] = $tmp_arr['MenuLevel'] + 1;
				$this->insNode( $tmp_arr );
				break;
			case MENU_UPD_SAVE:
				$tmp_arr['MenuName'] = $node_arr['MenuName'];
				$tmp_arr['MenuLink'] = $node_arr['MenuLink'];
				$tmp_arr['SortValue'] = $node_arr['SortValue'];
				$tmp_arr['InfluenceItemList'] = $node_arr['InfluenceItemList'];
				$tmp_arr['customInfluenceItemList'] = $node_arr['customInfluenceItemList'];
				$tmp_arr['MenuId'] = $node_arr['MenuId'];
				$this->updNode( $tmp_arr );
				break;		
			case MENU_DEL_SAVE:
				$tmp_arr['MenuId'] = $node_arr['MenuId'];
				if ( $tmp_arr['MenuEndFlag'] === '0' )
				{
					throw new Exception( 'this node have up 1 sub node ,can not be delete!' );
					return 0;
				}
				else
					$this->delNode( $tmp_arr );
				break;
		}
		return 1;
	}

	protected function getSqlPre()
	{
		return "select * from webadmin.treemenu where MenuPid=";
	}
	public function getTreeArr()
	{
		return $this->menuData;
	}
	public function buildTreeHtml( )
	{
		$htmlStr = '';
		$arrlen = count( $this->menuData );
		$arr = $this->menuData;
		//print_r( $arr );
		$pos = 0;
		while ( $pos < $arrlen )
		{
			//echo "l=".__LINE__."<br>";
			if ( $arr[ key( $arr ) ]['MenuPId'] == $this->topMenuID )
				$htmlStr = $htmlStr.$this->buildSubTreeHtml( key( $arr ) );

			$pos = $pos + 1;
			next($arr);
		}
		return $htmlStr;
	}
	public function buildSubTreeHtml( $menuid=1 )//传入菜单结点的id号
	{
		$arr  =  $this->menuData[ $menuid ];

		if ( intval( $arr['menuFlag'] ) == 1 ) 
		{

			$htmlStr = '<table class=white12 cellSpacing=0 cellPadding=0 border=0><TBODY>';

			for ( $j = 0; $j < $arr['MenuLevel']; $j++ )
				$htmlStr = $htmlStr.'<td><img src='.$this->tree_pic['line_img'].'></td>';
			
			$htmlStr = $htmlStr.'<td><img class=white12 id=Module'.$menuid.' src=';
			if ( intval( $arr[ 'MenuEndFlag' ] ) === 0 )
				$htmlStr = $htmlStr.$this->tree_pic['plus_img_0'];
			else if ( intval( $arr['lastNode'] ) === 1 )
				$htmlStr = $htmlStr.$this->tree_pic['blank_img_1'];
			else
				$htmlStr = $htmlStr.$this->tree_pic['blank_img_0'];
			$htmlStr = $htmlStr.' style=CURSOR:hand></td>';
			
			$htmlStr = $htmlStr.'<td><img id=Module'.$menuid.'1 alt='.$arr['MenuName'].' border=0 height=17 src=';
			if (  intval( $arr[ 'MenuEndFlag' ] ) === 0 )
				$htmlStr = $htmlStr.$this->tree_pic['query_img_0'];
			else
				$htmlStr = $htmlStr.$this->tree_pic['query_img_2'];

			$htmlStr = $htmlStr.' width=19></td>';

			$htmlStr = $htmlStr.'<td colSpan=3 class=white12><a href=\'';

			if (  intval( $arr[ 'MenuEndFlag' ] ) === 0 )
				if ( $this->selfMenu === 1 ) 
					$htmlStr = $htmlStr.'#&id='.$menuid.'\' onclick=Module'.$menuid.'.click();';
				else
					$htmlStr = $htmlStr.'#\' onclick=Module'.$menuid.'.click();';
			else
				$htmlStr = $htmlStr.$arr[ 'MenuLink' ].'&menuID='.$menuid.'\' target=mainFrame ';
			
			$htmlStr = $htmlStr.' class=white12 id='.$menuid;
			if ( $this->selfMenu === 1 )
			{
				//echo "assadlssasasas";
				$htmlStr = $htmlStr.' oncontextmenu=\'javascript:showmenuie5();\'';
			}
			$htmlStr = $htmlStr.' title=\''.$arr[ 'MenuName' ].'\'>&nbsp;'.$arr[ 'MenuName' ].'</a></td></tr></tbody></table>';

			if ( intval( $arr[ 'MenuEndFlag' ] ) === 0 )
			{
				$htmlStr = $htmlStr.'<table class=white12 id=Module'.$menuid.'d style=\'display:none\' cellSpacing=0 cellPadding=0 border=0></tbody><tr><td>';
				$subTree = split( ',', $arr[ 'subTreeList' ] );
				for ( $j = 0; $j < count( $subTree ); $j++ )
					$htmlStr = $htmlStr.$this->buildSubTreeHtml( $subTree[ $j ] );
			
				$htmlStr = $htmlStr.'</td></tr></tbody></table>';
				
			}
			return $htmlStr;
		}
		return "";
	}
	public function buildTreeArr( $sqlstr, $subSqlStr="" )
	{
		global $GLOBAL;
		$sqlstr1 = $sqlstr.$subSqlStr." order by sortValue asc;";
		$arr= $GLOBAL['G_DB_OBJ']->executeSqlMap( $sqlstr1 );
		$arr_len = count( $arr );
		$subTreeStr = '';
		for ( $i = 0; $i < $arr_len; $i++ )
		{
			//notice this line code very important
			$this->pushSubArray( $arr[ $i ] );
			if ( $i === $arr_len - 1 )
				$this->menuData[ $arr[ $i ]['MenuId'] ] ['lastNode'] = 1;
			if ( intval( $arr[ $i ]['MenuEndFlag'] ) === 0 )
			{
				$sqlstr1 = $this->getSqlPre().$arr[ $i ]['MenuId'];
				//notice this line code very important
				$this->menuData[ $arr[ $i ]['MenuId'] ] ['subTreeList']=$this->buildTreeArr( $sqlstr1, $subSqlStr );
			}
				if ( $i === 0 )
					$subTreeStr = $arr[ $i ]['MenuId'];
				else
					$subTreeStr = $subTreeStr.','.$arr[ $i ]['MenuId'];
		}

		return $subTreeStr;
	}
	protected function pushSubArray( $arr )
	{
		$this->menuData[ $arr['MenuId'] ] = array(	'MenuId' => intval( $arr['MenuId'] ),
													'MenuName'=>$arr['MenuName'],
													'InfluenceItemList'=>$arr['InfluenceItemList'],
													'customInfluenceItemList'=>$arr['customInfluenceItemList'],												'MenuPId'=>intval( $arr['MenuPId'] ),
													'MenuLevel'=>intval( $arr['MenuLevel']-$this->menuLevel ),
													'MenuEndFlag'=> $arr['MenuEndFlag'],
													'MenuLink'=>$arr['MenuLink'],
													'SortValue'=>intval( $arr['SortValue'] ),
													'regTime'=>$arr['regTime'],
													'subTreeList'=>isset($arr['subTreeList'])?$arr['subTreeList']:'',
													'lastNode'=>0
													);
	}

	function __destruct( )
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "f=".__FILE__.",l=".__LINE__."<br>";

	}
}
?>
