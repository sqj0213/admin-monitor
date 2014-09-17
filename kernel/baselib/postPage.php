<?php
/*
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 *
 * 此类供urlDiffluence.php使用，前端发生数据库请求时，自动启用此类
 */

define ( 'ABS_POSTPAGE_CUR_DIR', dirname( __FILE__ )."/" );
//require_once('base_class.php');
require_once( ABS_POSTPAGE_CUR_DIR.'../inc/conf.php');

class postPage
{
	protected $checkScriptTypeArray = array("textboxen" => TEXTBOXEN,
					"textarea"=>TEXTAREA,
				   "telephone"  => TELEPHONE,
				   "checkCode"  => CHECKCODE,
				   "email"	 => EMAIL,
				   "postcode" =>POSTCODE,
				   "birthday" =>BIRTHDAY,
				   "integer" =>NUMBER,
				   "datetime" =>DATETIME,
				   "integersplit" =>NUMBERSPLIT,
				   "negative" =>NEGATIVE,
				   "mobile" =>MOBILE,
				   "float" =>FLOAT,
				   "gainrate" =>GAINRATE,
				   "phone" =>PHONE,
				   "url" =>URL,
				   "checkbox" =>CHECKBOX
				   );
//表单结构体定义
	protected $formUnitArray = array(
						"form" => array("formname"=>"",
										"split" =>  array("name" => "", 
														  "dbname" => "",
														  "script" => ""
														 )
									   ),
						"formunit" => array(0 => array(	"fieldname" =>	"",
														"split" =>
														array ( "name" => "",
																"title" => "",
																"maxlen" => 0,
																"minlen" => 0,
																"flag" => 0 
																)
														)
											),//表单元素属性结构
						"unitcount" => 0//表单元素个数
						);
	//构造函数传时的样例程序中并未使用此变量
	private $post = Array	(
							'loginame_登录名称_textboxen_4_20_1' => "asdf",
							'passwd_登录密码_textboxen_4_20_1' => "asdf",
							'formname' => "form_0_systemuser"
							);
	//表单post后的对应的数据库结构与属性数组
	public $formPostToDBArray = array(
							"tablename"	=>"",
							"fieldarray"=>array(	0 => 
													array(	"inputname"	=> "",
															"property"	=>	array(	"column"	=>	"",
																					"title"		=>	"",
																					"checktype"	=> "",
																					"minlen"	=>	0,
																					"maxlen"	=>	0,
																					"chksign"		=>	0,
																					"accesssign" =>0//是否入库
																				),
															"inputvalue" =>""
														)
												),
							"id"=>0,//修改时要使用
							"columncount"=>0,
							"accesssign"=>0,//0为认证,1为列表,2为更改，3为删除
							"union_field"=>"id",//排重字段名称
							"only_chk"=>0//是否排重插入
						);

	public function getPostDataArr( )
	{
		$post_data_arr = array();
		$tmp_arr = $this->formPostToDBArray['fieldarray'];
//		print_r ($this->formPostToDBArray['fieldarray']);
		for ( $i = 0; $i< count( $tmp_arr ); $i++ )
//			echo $tmp_arr[$i][$property]['0'].":".$tmp_arr[$i]["inputvalue"]."<br><br>";
			$post_data_arr[ $tmp_arr[$i]['property'][0] ] = $tmp_arr[$i]['inputvalue'];
		return $post_data_arr;
	}
	protected function scriptTypeIsInteger( $val )
	{
		$script_type_array = $this->checkScriptTypeArray;
		$bool = false;
		while ( current( $script_type_array ) )
		{
			if ( ( strcmp( key( $script_type_array ), $val ) === 0 ) && ( strcmp( key( $script_type_array ), "integer" ) === 0 ) )
			{
				$bool =  true;
				break;
			}
			next ( $script_type_array );
		}
		reset( $script_type_array );
		return $bool;
	}

	public function getPostArray()
	{
		return $this->formPostToDBArray;
	}
	public function __construct( $post1 )
	{
		//print_r( $post1 );
		$post = $this->filterPost( $post1 );
		if ( is_array( $post ) === false )
			throw new Exception( '\$post 必须为数组!' );
		try
		{
			$this->formKeyChk( $post );
			$this->initPost( $post );
			if ( !Empty( $this->formPostToDBArray['tablename'] ) )
				$this->formValueChk(  );
		}
		catch (Exception $e) {throw new Exception( $e-> getMessage( ) );}
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__construct,f=".__FILE__.",l=".__LINE__."<br>";
	}

	public function __destruct( )
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "f=".__FILE__.",l=".__LINE__."<br>";
		$this->formPostToDBArray = array();
	}

	private function formValueChk( )
	{
		$checkScriptTypeArray = $this->checkScriptTypeArray;
		
		$fieldarr = $this->formPostToDBArray[ 'fieldarray' ];
		//print_r( $fieldarr );
		//print_r( $this->formPostToDBArray );
		//exit;
		for ( $i = 0; $i < $this->formPostToDBArray[ 'columncount' ]; $i++ )
		{
			$arr = $fieldarr[$i];
			//print_r( $arr );
			if ( Empty( $arr['fieldvalue'] ) && $arr['property']['5'] === 1  )
				throw new Exception( $arr['property'][1].' 不能为空!' );
			else
			{
				
				/*echo "aa=".$arr['inputvalue'].",a=".strlen( $arr['inputvalue'] )."<br>";
				echo "b=".$arr['property'][3]."<br>";
				echo  "arrvalue=".$arr['inputvalue']."<BR>";
				echo "c=".strlen( $arr['inputvalue'] )."<br>";
				echo "d=".$arr['property'][4]."<br>";
								
				*/
				//print_r( $arr );
				//print_r( $_POST );
				if ( strlen( strval($arr['inputvalue'] ) ) < $arr['property'][3] || strlen( strval($arr['inputvalue']) ) > $arr['property'][4] ) 
				{
					//print_r( $arr['property']);
					throw new Exception( $arr['property'][1].'('.strval($arr['inputvalue'] ).') 长度必须在 '.$arr['property'][3].'-'.$arr['property'][4].'之间!' );
				}
				//echo "--------------------------".$this->checkScriptTypeArray[ $arr['property'][2] ]."=====".$arr['property'][2]."<br>";
				if ( !is_array( $arr['inputvalue'] ) )
				{
					//输入框里未输入内容时,不做正则检查,如果输入了再做检查
					if ( strlen( $arr['inputvalue'] ) !== 0 ) 
					{
						if ( !preg_match( $this->checkScriptTypeArray[ $arr['property'][2] ], $arr['inputvalue'] ) )	
						{
							throw new Exception( '<br>('.$arr['property'][1].')=('.$arr['inputvalue'].')输入非法!,l='.__LINE__.'<br>' );	
						}
					}
				}
			}
		}
	}
	
	//用于检查post之前的表单里的元素的命名是否规则
	private function formKeyChk( $post )
	{
		while ( current( $post ) )
		{
			if ( !preg_match( OTHERFILTERFORM, key( $post ) ) )//若即不是表单，也不是id，也不是排重字段的话
			{
				if ( !preg_match( FILTERFORMREGEX, key( $post ) ) )
				{
					throw new Exception("您的数据请求非法，请确认!f=".__FILE__.",l=".__LINE__.":".key( $post ).":".INPUT_CHK_REG);
				}
			}
			else
			{
				//if ( strcmp( FORM_NAME, key( $post ) ) !== 0 && strcmp( UPD_ID_NAME, key( $post ) ) !== 0 && strcmp( UNION_FIELD, key( $post ) ) !== 0 && strcmp( MENU_ID, key( $post ) ) !== 0)//检查表单名与id的键名是否正确
				//	throw new Exception("您的数据请求非法，请确认!f=".__FILE__.",l=".__LINE__);
				//if ( !preg_match( FORM_CHK_REG,  $post[ key( $post ) ] ) && strcmp( UPD_ID_NAME, key( $post ) ) !== 0&& strcmp( UNION_FIELD, key( $post ) ) !== 0&& strcmp( MENU_ID, key( $post ) ) !== 0 )//检查表单名与id的键名是否正确
				//	throw new Exception("您的数据请求非法，请确认!f=".__FILE__.",l=".__LINE__);
			}
			next ( $post );
		}
	}
	private function initPost( $post )
	{
		$arrlen = count( $post );
		if ( $arrlen === 0 )
			throw new Exception('您所提交的表单内容为空!\n');

		$j = 0;
		$post_arr = count( $post );
		while ( current( $post ) || $j < $post_arr )
		{
			if ( !current( $post ) && $j < $post_arr )
			{
				if ( strpos( $post[ key( $post ) ], TMPL_FORM_PRE ) === false )
				{
					if ( strcmp( key( $post ), UPD_ID_NAME ) === 0 )//如果为id的话
						$this->formPostToDBArray['id'] = $post[ key( $post ) ];
					else
					{
						if (  strcmp( key( $post ), UNION_FIELD ) === 0  )//如果为union_field的话
							$this->formPostToDBArray['union_field'] =  $post[ key( $post ) ];
						else
							if ( strcmp( key( $post ), MENU_ID ) !== 0  ) //如果为menuid项的话
							{
								//echo "l=".__LINE__."<br>";
								$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['property'] = split( '_', key( $post ) );
								$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputname'] =  key( $post );
								$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputvalue'] =  $post[ key( $post ) ];
								$this->formPostToDBArray['columncount'] = $this->formPostToDBArray['columncount'] + 1;
							}
					}
				}
				$j = $j + 1;
				next ( $post );
				continue;
			}
			else
			{
				if ( is_string( $post[ key( $post ) ] ) )
				{
					if ( strpos( $post[ key( $post ) ], TMPL_FORM_PRE ) === false )
					{
						if (  strcmp( key( $post ), UPD_ID_NAME ) === 0  )//如果为id的话
							$this->formPostToDBArray['id'] = $post[ key( $post ) ];
						else
						{
							if (  strcmp( key( $post ), UNION_FIELD ) === 0  )//如果为union_field的话
								$this->formPostToDBArray['union_field'] =  $post[ key( $post ) ];
							else
								if ( strcmp( key( $post ), MENU_ID ) !== 0  ) //如果为menuid项的话
								{
									//echo "l=".__LINE__."<br>";
									$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['property'] = split( '_', key( $post ) );
									$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputname'] =  key( $post );
									$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputvalue'] =  $post[ key( $post ) ];
									$this->formPostToDBArray['columncount'] = $this->formPostToDBArray['columncount'] + 1;
								}
						}
					}
				}
				//如果为删除时的多选项,则执行此条件
				else if ( is_array( $post[ key( $post ) ] ) )
				{
					if ( strcmp( key( $post ), MENU_ID ) !== 0  ) //如果为menuid项的话
					{
						$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['property'] = split( '_', key( $post ) );
						$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputname'] =  key( $post );
						$this->formPostToDBArray['fieldarray'][$this->formPostToDBArray['columncount']]['inputvalue'] =  $post[ key( $post ) ];
						$this->formPostToDBArray['columncount'] = $this->formPostToDBArray['columncount'] + 1;
					}
				}
			}
			$j = $j + 1;
			next ( $post );
		}
		//echo "\n\n\n\n".FORM_NAME."\n\n\n\n";
		if ( !Empty( $post[ FORM_NAME ]  ) )
		{
			$tmp = split( '_', $post[ FORM_NAME ] );
			$this->formPostToDBArray['tablename'] = $tmp[2];//表名
			//print_r( $post );
			if ( isset($tmp[3]) )
				$this->formPostToDBArray['only_chk'] = intval  ( $tmp[ 3 ] );//插入时是否排重
			else
				$this->formPostToDBArray['only_chk'] =0;
			//echo "<br><BR>ASDF".$post[ FORM_NAME ]."ASDF<BR><BR>";
			$this->formPostToDBArray['accesssign'] = intval( $tmp[1] );//sql操作方式
		}
		//echo FORM_NAME."<br><br>";
		//print_r( $this->formPostToDBArray );
		//exit;
		//exit;
	}
	protected function getUnionFieldValue( $union_field )
	{
		$tmp = array();
		$fieldarr = $this->formPostToDBArray["fieldarray"];
		for ( $i = 0; $i < count( $fieldarr ); $i++ )
		{
			if ( $union_field === $fieldarr[$i]['property'][0] )
			{
				$tmp[0] = $fieldarr[$i]['inputvalue'];
				$tmp[1] = $fieldarr[$i]['property'][2];
			}
		}
		return $tmp;
	}
	public function getPostInfo()
	{
		/*
		          [2] => Array
                (
                    [property] => Array
                        (
                            [0] => passwd
                            [1] => 登录密码
                            [2] => textboxen
                            [3] => 4
                            [4] => 20
                            [5] => 1
                            [6] => 1
                        )

                    [inputname] => passwd_登录密码_textboxen_4_20_1_1
                    [inputvalue] => asdf
                )
*/
		$info = "";
		for ( $i = 0; $i < $this->formPostToDBArray['columncount']; $i++ )
		{
			if ( $i === 0 )
				$info = $this->formPostToDBArray["fieldarray"][$i]['property'][1];
			else
				$info = $info.",".$this->formPostToDBArray["fieldarray"][$i]['property'][1];
			if ( $this->formPostToDBArray["fieldarray"][$i]['property'][0] == "passwd" )
				$info = $info."[****]";
			else
			{
				if ( strlen( $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] ) <= 256 )
					$info = $info."[".$this->formPostToDBArray["fieldarray"][$i]['inputvalue']."]";
				else
					$info = $info."前16位字符[".substr( $this->formPostToDBArray["fieldarray"][$i]['inputvalue'], 0, 256 )."]";
			}
		}
		return $info;
	}
	public function get_string_from_post_array( &$errMsg )
	{
		//echo $this->formPostToDBArray['accesssign']."<br><br>";
		//print_r( $this->formPostToDBArray );
		//exit;
		$sqlstring = '';
		if ( $this->formPostToDBArray['accesssign'] === 0 )//若为认证
		{			
			$sqlstring = "select * from ".$this->formPostToDBArray["tablename"]." where ";

			$sqlstring = $sqlstring.$this->formPostToDBArray["fieldarray"][0]['property'][0]."=";
			//$is_int = $this->scriptTypeIsInteger( $this->formPostToDBArray["fieldarray"][0]['property'][2] );
			//if ( !( $is_int ) )
			//{
				$sqlstring = $sqlstring."'";
			//}

			$sqlstring = $sqlstring.$this->formPostToDBArray['fieldarray'][0]['inputvalue'];
			//if ( !( $is_int ) )
			//{
				$sqlstring = $sqlstring."'";
			//}

			for ( $i = 1; $i < $this->formPostToDBArray['columncount']; $i++ )
			{
				$sqlstring = $sqlstring." and ".$this->formPostToDBArray["fieldarray"][$i]['property'][0]."=";
				$is_int = $this->scriptTypeIsInteger( $this->formPostToDBArray["fieldarray"][$i]['property'][2] );
				if ( !( $is_int ) )
				{
					$sqlstring = $sqlstring."'";
				}
				$sqlstring = $sqlstring.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
				if ( !( $is_int ) )
				{
					$sqlstring = $sqlstring."'";
				}
			}
		}
		if ( $this->formPostToDBArray['accesssign'] === 1 )//若为插入记录
		{

			if ( $this->formPostToDBArray['union_field'] !== "__UNION_FIELD__" && $this->formPostToDBArray['union_field'] !== "" )
			{
				$field = substr( $this->formPostToDBArray['union_field'], 0, strpos( $this->formPostToDBArray['union_field'], "_" ) );
				$field_title = substr( $this->formPostToDBArray['union_field'], strpos( $this->formPostToDBArray['union_field'], "_" ) + 1 );
				$tmp = $this->getUnionFieldValue( $field );

				if ( count( $tmp ) > 1 )
				{
					if ( $tmp[1] === "integer" ) 
						$tmpsql = "select count(*) from ".$this->formPostToDBArray["tablename"]." where ".$field."=".$tmp[0];
					else
						$tmpsql = "select count(*) from ".$this->formPostToDBArray["tablename"]." where ".$field."='".$tmp[0]."'";
					global $GLOBAL;
					$tmpvalue = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpsql );
					if ( $tmpvalue !== "0" )
					{
						$errMsg = $field_title."为'".$tmp[0]."'的数据已经存在!";
						return;
					}
				}
			}
			$sqlstring = "insert into ".$this->formPostToDBArray["tablename"]." ";
			$sql_field = '(';
			$sql_value = 'values(';
			for ( $i = 0; $i < ($arrlen = $this->formPostToDBArray['columncount'] ); $i++ )
			{
				if ( $this->formPostToDBArray["fieldarray"][$i]['property'][6] == 1 )
				{
					$sql_field = $sql_field.$this->formPostToDBArray["fieldarray"][$i]['property'][0];
			//		$is_int = $this->scriptTypeIsInteger( $this->formPostToDBArray["fieldarray"][$i]['property'][2] );
			//		if ( !( $is_int ) )
			//		{
						$sql_value = $sql_value."'";
						$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
						$sql_value = $sql_value."'";
			//		}
			//		else
			//			$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
					if ( $i !== $arrlen - 1 ) {$sql_field = $sql_field.","; $sql_value = $sql_value.",";};
				}
			}
			if ( substr( $sql_field , -1 ) == "," && substr( $sql_value, -1 ) == "," )
			{
				$sql_field = substr( $sql_field, 0, -1 );
				$sql_value = substr( $sql_value, 0, -1 );
			}
			$sql_field = $sql_field.')';
			$sql_value = $sql_value.')';
			$sqlstring = $sqlstring.$sql_field.$sql_value;
		}
		if ( $this->formPostToDBArray['accesssign'] === 2 )//若为修改记录
		{		
			if ( $this->formPostToDBArray['union_field'] !== "__UNION_FIELD__" && $this->formPostToDBArray['union_field'] !== "" )
			{
				$field = substr( $this->formPostToDBArray['union_field'], 0, strpos( $this->formPostToDBArray['union_field'], "_" ) );
				$field_title = substr( $this->formPostToDBArray['union_field'], strpos( $this->formPostToDBArray['union_field'], "_" ) + 1 );
				$tmp = $this->getUnionFieldValue( $field );
				if ( count( $tmp ) > 1 )
				{
					if ( $tmp[1] === "integer" ) 
						$tmpsql = "select count(*) from ".$this->formPostToDBArray["tablename"]." where ".$field."=".$tmp[0]." and id<>".$this->formPostToDBArray['id'];
					else
						$tmpsql = "select count(*) from ".$this->formPostToDBArray["tablename"]." where ".$field."='".$tmp[0]."'"." and id<>".$this->formPostToDBArray['id'];
					global $GLOBAL;
					$tmpvalue = $GLOBAL['G_DB_OBJ']->getFieldValue( $tmpsql );
					
					if ( $tmpvalue !== "0" )
					{
						$errMsg = $field_title."为'".$tmp[0]."'的数据已经存在!";
						return;
					}
				}
			}
			$sqlstring = "update ".$this->formPostToDBArray["tablename"]." set ";
			$filed_value = '';
			for ( $i = 0; $i < ($arrlen = $this->formPostToDBArray['columncount'] ); $i++ )
			{
				$sql_field = '';
				$sql_value = '';
				if ( $this->formPostToDBArray["fieldarray"][$i]['property'][6] == 1 )
				{
					$sql_field = $sql_field.$this->formPostToDBArray["fieldarray"][$i]['property'][0];
					//$is_int = $this->scriptTypeIsInteger( $this->formPostToDBArray["fieldarray"][$i]['property'][2] );
					//if ( !( $is_int ) )
					//{
						$sql_value = $sql_value."'";
						$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
						$sql_value = $sql_value."'";
					//}
					//else
					//	$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
					if ( $i !== $arrlen - 1 )
						$filed_value = $filed_value.$sql_field."=".$sql_value.",";
					else
						$filed_value = $filed_value.$sql_field."=".$sql_value;
				}


			}
			if ( substr( $filed_value , -1 ) == "," )
				$filed_value = substr( $filed_value, 0, -1 );

			$sql_where = " where id=".$this->formPostToDBArray["id"];		
			$sqlstring = $sqlstring.$filed_value.$sql_where;
		}
		if ( $this->formPostToDBArray['accesssign'] === 3 )//若为删除记录
		{			
			//print_r( $this->formPostToDBArray );
			$sqlstring = "delete from  ".$this->formPostToDBArray["tablename"]." where id in ( ";
			for ( $i = 0; $i < ($arrlen = $this->formPostToDBArray['columncount'] ); $i++ )
			{
				if ( !is_array( $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] ) )
					$sqlstring = $sqlstring.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
				else
					$sqlstring=$sqlstring.implode( ",", $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] );
				if ( $i !== $arrlen - 1 )
					$sqlstring=$sqlstring.",";

			}
			$sql_value = $sql_value.')';
			$sqlstring = $sqlstring.$sql_field.$sql_value;
		}
			if ( $this->formPostToDBArray['accesssign'] === 4 )//若为存储过程调用
		{

			$sqlstring = "call ".$this->formPostToDBArray["tablename"]."(";
			//$sql_field = '(';
			$sql_value = '';//'values(';
			for ( $i = 0; $i < ($arrlen = $this->formPostToDBArray['columncount'] ); $i++ )
			{
				if ( $this->formPostToDBArray["fieldarray"][$i]['property'][6] == 1 )
				{
					//$sql_field = $sql_field.$this->formPostToDBArray["fieldarray"][$i]['property'][0];
			//		$is_int = $this->scriptTypeIsInteger( $this->formPostToDBArray["fieldarray"][$i]['property'][2] );
			//		if ( !( $is_int ) )
			//		{
						$sql_value = $sql_value."'";
						if ( is_array( $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] ) )
					{
							//echo 'l='.__LINE__.'<br>';
							//print_r( implode(  ',', $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] ) );
							//exit;
							$sql_value = $sql_value.implode(  ',', $this->formPostToDBArray["fieldarray"][$i]['inputvalue'] );
					}
						else
					{
							//echo 'l='.__LINE__.'<br>';
							$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
					}
						$sql_value = $sql_value."'";
			//		}
			//		else
			//			$sql_value = $sql_value.$this->formPostToDBArray["fieldarray"][$i]['inputvalue'];
					if ( $i !== $arrlen - 1 )
					{
						//$sql_field = $sql_field.",";
						$sql_value = $sql_value.",";
					};
				}
			}
			//if ( substr( $sql_field , -1 ) == "," && substr( $sql_value, -1 ) == "," )
			if ( substr( $sql_value, -1 ) == "," )
			{
				//$sql_field = substr( $sql_field, 0, -1 );
				$sql_value = substr( $sql_value, 0, -1 );
			}
			//$sql_field = $sql_field.')';
			//$sql_value = $sql_value;
			$sqlstring = $sqlstring."\"".$sql_value."\")";
		}
		return $sqlstring;
	}

	function filterPost( $post1 )
	{
		$post  =  $post1;
		$filter = array();
		$arrlen = count( $post );
		$pos = 1;
		//print_r( $post1 );
		while ( current( $post ) || $pos < $arrlen )
		{
			if ( preg_match( FILTERFORMREGEX, key( $post ), $tmp ) )//注意===与==的区别，带有类型检查
			{
				$filter[ key( $post ) ] = $post[ key( $post ) ];
			}
			else
			{
				if ( preg_match( OTHERFILTERFORM, key( $post ), $tmp ) && key( $post ) !== CLUBID )//注意===与==的区别，带有类型检查,clubID今有ID所以此条件成立
					$filter[ key( $post ) ] = $post[ key( $post ) ];		
			}
			$pos = $pos + 1;
			next($post);
		}
		//print_r( $filter );
		return $filter;
	}
}

?>