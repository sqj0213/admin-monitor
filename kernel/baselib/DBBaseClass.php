<?php
/*
 *数据库抽象类
 *
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
define ( 'ABS_CUR_DIR_DBBBASELIB', dirname( __FILE__ )."/" );
require_once ABS_CUR_DIR_DBBBASELIB."../inc/conf.php";
require_once ABS_CUR_DIR_DBBBASELIB."baseClass.php";

//require_once ABSCURDIR.'../inc/global.php';

class DBBaseClass extends baseClass
{
	public $DBConn = false;
	private $dbHost = 'localhost';
	private $dbUser = 'root';
	private $dbPwd = '123qwe';
	private $dbName = 'swsuser';
	private $dbPort = 3306;
	private $dbCharset='utf8';


	public function __construct( &$dbLink = false )
	{
		parent::__construct();
		global $GLOBAL;
		$this->initDBPara(  $GLOBAL['serverInfo']['dbInfo'] );
		//$this->connectDB( $dbLink );
	}
	public function initPara( $paraName, $paraValue )
	{
		//echo $paraName.'='.$paraValue.'<br>';
		$this->$paraName = $paraValue;
		//exit;
	}
	public function initDBPara( $DBPara=array() )
	{
		//print_r( $DBPara );
		//exit;
		while ( current( $DBPara ) !== false )
		{
			$key = key( $DBPara );
			$this->$key = current( $DBPara );
			next ( $DBPara );
		}
			//exit;
	}
	public function connectDB( &$dbLink = false )
	{
		global  $GLOBAL;//-4Y@z()"
		if (  $dbLink !== false )//HA4?4})X4i
		{
			$this->DBConn = $dbLink;
		}
		else
		{
			//$this->DBConn = mysql_connect( $GLOBAL['serverInfo']['dbInfo']['dbHost'].":".$GLOBAL['serverInfo']['dbInfo']['dbPort'], $GLOBAL['serverInfo']['dbInfo']['dbUser'], $GLOBAL['serverInfo']['dbInfo']['dbPwd']);
			//print_r( $GLOBAL['serverInfo']['dbInfo'] );
			
			ini_set('zend.ze1_compatibility_mode', 0); //Trying to clone an uncloneable object of class mysqli 
			//print_r( $this );
			//exit;
			$this->DBConn = mysqli_connect( $this->dbHost, $this->dbUser, $this->dbPwd, $this->dbName, $this->dbPort );
			if ( Empty( $this->DBConn ) ) 
			{
				$this->writeLog( $this->errLog, 'db conn failed'.",F=".__FILE__.",L=".__LINE__ );
				//throw new Exception( mysql_error( ) );
				throw new Exception( "system db error!" );
			}
			else
			{
				//print_r( $GLOBAL['serverInfo']['dbInfo']['dbCharset'] );
				mysqli_query( $this->DBConn, "SET character_set_client='".$this->dbCharset."'");
				//echo 'aaa='.mysqli_error( $this->DBConn );
				mysqli_query( $this->DBConn, "SET character_set_results='".$this->dbCharset."'");
				//echo 'aaa='.mysqli_error( $this->DBConn );
				mysqli_query( $this->DBConn, "SET collation_connection='".$this->dbCharset."_bin'");
				//echo 'aaa='.mysqli_error( $this->DBConn );
				//exit;
			}
		}
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__construct,f=".__FILE__.",l=".__LINE__."<br>";
		
	}
	public function reConnect( &$dbLink = false )
	{
		if (  $this->DBConn !== false )
			return ;			
			
		$this->connectDB( $dbLink );
	}
	public function executeSql( $sqlString )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$row = array();

		$result = mysqli_query( $this->DBConn, $sqlString );
		if ( $result !== false )//?
		{

			if ( is_object( $result ) ) //F,}\nsertpdate^^"e
			{
				if ( ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) === false )//{m`RQe
				{
					mysqli_free_result( $result );
					return array( );
				}
			}
			else
				return 1;
		}
		else
		{
			$this->writeLog( $this->errLog,__FILE__."\tl=".__LINE__.",sql=".$sqlString."\tmysqlerr=".mysqli_error( $this->DBConn ) );
			throw new Exception( "system error" );
			//throw new Exception( mysql_error( ) );	
		}
		while ( mysqli_next_result( $this->DBConn ) )
		{
			$result = mysqli_use_result( $this->DBConn );
			if ( is_object( $result ) )
			mysqli_free_result( $result );
		}
		return $row;
	}
	
	public function executeMutiSqlTrans( $sqlString )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$row = array();
		$sqlArr = explode( ";", $sqlString );
		while ( current( $sqlArr ) !== FALSE )
		{
			if ( strlen( current( $sqlArr ) ) > 5 ) 
			{
				mysqli_query( 'start transaction;' );
				$result = mysqli_query( $this->DBConn, current( $sqlArr ) );
				if ( ( $result ) !== false )
				{	
					if ( is_object( $result ) ) 
					{
						if ( ( $row = mysqli_fetch_array( $result, MYSQL_NUM ) ) === false )//{m`RQe
						{
							mysqli_free_result( $result );
							return array( );
						}
					}
				}
				else
				{
					mysqli_query( 'rollback;' );
					$this->writeLog( $this->errLog,__FILE__.":".__LINE__.mysqli_error( $this->DBConn ).",sqlString=".current( $sqlArr ) );

					throw new Exception( "system error" );	
					exit;
				}
			}
			next( $sqlArr );
		}
		mysqli_query( 'commit;' );
		return $row;
	}
	public function executeMutiSql( $sqlString )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$row = array();
		$sqlArr = explode( ";", $sqlString );
		while ( current( $sqlArr ) !== FALSE )
		{
			if ( strlen( current( $sqlArr ) ) > 5 ) 
			{
				$result = mysqli_query( $this->DBConn, current( $sqlArr ) );
				if ( ( $result ) !== false )
				{	
					if ( is_object( $result ) ) 
					{
						if ( ( $row = mysqli_fetch_array( $result, MYSQL_NUM ) ) === false )//{m`RQe
						{
							mysqli_free_result( $result );
							return array( );
						}
					}
				}
				else
				{
					$this->writeLog( $this->errLog,__FILE__.":".__LINE__.mysqli_error( $this->DBConn ).",sqlString=".current( $sqlArr ) );

					throw new Exception( "system error" );	
					exit;
				}
			}
			next( $sqlArr );
		}
		return $row;
	}
	public function getDbSql( $table, $node_arr,$opt_type )
	{
		$sql='';
		switch ( $opt_type )
		{
			case 'insert':
				//echo "asdfasdf";
				$sql =  'insert into '.$table.' set ';
				$sql=$sql.$this->getSqlFieldValue( $node_arr );
				break;
			case 'update':
				$sql =  'update '.$table.' set ';
				$sql=$sql.$this->getSqlFieldValue( $node_arr );
				break;
			case 'delete':
				$sql =  'delete from '.$table;
				break;
		}

		return $sql;
	}
	private function getSqlFieldValue( $node_arr )
	{
		$sql='';
		$arrlen = count( $node_arr );
		$pos = 0;
		while ( current( $node_arr ) || $pos < $arrlen )
		{
			$sql = $sql.key( $node_arr ).'=';
			if ( $pos !== $arrlen - 1 )
				$tmp=',';
			else
				$tmp='';
			if ( is_int( $node_arr[key($node_arr)] ) )
				$sql=$sql.'\''.strval( $node_arr[key($node_arr)] ).'\''.$tmp;
			else
				$sql=$sql.'\''.strval( $node_arr[key($node_arr)] ).'\''.$tmp;
			$pos = $pos + 1;
			next($node_arr);
		}
		//echo "sql=".$sql."<br><br>";
		return $sql;
	}
/*
	$userPageTitle=array(
						'tableName'=>TABLE_NAME_USERMANAGER,
						'userKey'=>array	(
							'id'=>'id',
							'loginame'=>''Z',
							'password'=>'5',
							'name'=>'?',
							'number'=>'"&'',
							'sex'=>'C',
							'tel'=>'q"C=',
							'email'=>'email',
							'department'=>')',
							'(select name from influence where influence.id='.TABLE_NAME_USERMANAGER.'.influenceid)'=>'Y',
							'lastLoginTime'=>''',
							'regTime'=>'	%='
												),
							'pageSize'=>USERMANAGER_PAGE_SIZE,
							'pageNum'=>1
						);
	*/
	public function getBaseSql( $userkey, $subSql, $tableName )
	{
		$sql='select ';

		$arr_cnt = count( $userkey );

		$i = 0;
		if ( $arr_cnt === 0 )
			$sql = $sql."* ";
		else
			while( current( $userkey ) )
			{
				if ( $arr_cnt - 1 === $i )
					$sql = $sql.key($userkey)." as '".$userkey[key($userkey)]."'";
				else
					$sql = $sql.key($userkey)." as '".$userkey[key($userkey)]."',";
				$i++;
				next( $userkey );
			}
		$sql = $sql." from ".$tableName." ";

		$sql = $sql." ".$subSql;

		return $sql;
	}
	public function getSqlFromKeyAsKeyArr( $userPageTitle, $subSql="" )
	{

		$sql = $this->getBaseSql( $userPageTitle['userKey'], $subSql, $userPageTitle['tableName'] );
		$sql = $sql.( isset( $userPageTitle['orderSubSql'] )?$userPageTitle['orderSubSql']:' order by id desc ' ) ;
		$sql = $sql." limit ".$userPageTitle['pageSize']*($userPageTitle['pageNum']-1).",";
		$sql = $sql.$userPageTitle['pageSize'];

		return $sql;
	}
	public function executeSqlMap( $sqlString, $flag = 0 )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$map = array();
		$i = 0;
		$row = array();
		$result = mysqli_query( $this->DBConn, $sqlString  );
		if ( ( $result ) !== false )
		{
			if ( is_object( $result ) ) 
			{
				if ( mysqli_num_rows( $result ) !== 0 )
				{
					while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) )//{m`RQe
					{
						if ( $flag === 0 )//{GAmap(=
							$map[ $i ] = $row;
						else
							if ( count( $row ) === 1 )//{GAD5
								$map[ $i ] = $row[0];
							else//{GA
							{
								$map = $row;
								return $map;
							}
						$i++;
					}

				}
				else
					return $map;
			}
			else
				return $map;
		}
		else
		{
			$this->writeLog( $this->errLog,"sqlstr=".$sqlString.",".__FILE__.":".__LINE__.":".mysqli_error( $this->DBConn ) );
			throw new Exception( "system error" );	
			return $map;
		}
		mysqli_free_result( $result );
		return $map;
	}
	public function getFieldValue( $sqlString )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$result = mysqli_query( $this->DBConn, $sqlString );
		$row = array();
		$row[0] = "";
		if ( is_object( $result ) )
		{
			if ( mysqli_num_rows( $result ) != 0 )
				$row = mysqli_fetch_array( $result,  MYSQLI_BOTH );
			mysqli_free_result($result);
			return $row[0];
		}
		else
		{
			$this->writeLog( $this->errLog,"sqlstr=".$sqlString.",".__FILE__.":".__LINE__.":".mysqli_error( $this->DBConn ) );
			throw new Exception( "system error" );
			return "";
		}
		return $row[0];
	}

	public function getMutiRowFieldValue( $sqlString )
	{
		$this->reConnect();
		$sqlString = $this->sqlFilter( $sqlString );
		$result = mysqli_query( $this->DBConn, $sqlString );
		//print_r( $sqlString );
		$tmpValue = "";
		if ( $result !== false )
		{
			if ( is_object( $result ) )
			{
				$row = mysqli_fetch_array( $result, MYSQLI_NUM );
				//print_r( $row );
				$tmpValue .= $row[0];
				mysqli_free_result($result);
			}
		}
		else
		{
			$this->writeLog( $this->errLog,"sqlstr=".$sqlString.",".__FILE__.":".__LINE__.":".mysqli_error( $this->DBConn ) );
			throw new Exception( "system error" );
			return "";
		}
			while ( mysqli_next_result( $this->DBConn ) )
			{
				//echo "l=".__LINE__."<br>";
				$result = mysqli_use_result( $this->DBConn );
				if ( is_object( $result ) )
					mysqli_free_result( $result );
			}	
				
		return $tmpValue;
	}

	function __destruct( )
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__destruct,f=".__FILE__.",l=".__LINE__."<br>";
		if ( is_null( $this->DBConn ) !== false )
			mysqli_close( $this->DBConn );
		parent::__destruct();
	}
	private function sqlFilter( $sqlString )
	{
		$tmpStr = $sqlString;
		return $tmpStr;
	}
}
//$ddd= new db_base_class();
//print_r( $ddd );
?>