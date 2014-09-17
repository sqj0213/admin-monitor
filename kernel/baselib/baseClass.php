<?php
/*派生类的基础类,提供日志的记录功能
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
define('ABS_CUR_DIR_BASELIB',dirname(__FILE__).'/');
require_once( ABS_CUR_DIR_BASELIB.'../inc/conf.php' );
//抽象类不能被实例化，即不能创建对象
abstract class baseClass{


	public $errLog = array();//这里不能引用外部变量
	public $accLog = array();
	public $notLog = array();
	public $appLog = array();

	public function __construct( )
	{
		global $GLOBAL;
		$this->errLog[0] = $GLOBAL['serverInfo']['logInfo']['errLog'];
		$this->accLog[0] = $GLOBAL['serverInfo']['logInfo']['accLog'];
		$this->notLog[0] = $GLOBAL['serverInfo']['logInfo']['notLog'];
		$this->appLog[0] = $GLOBAL['serverInfo']['logInfo']['appLog'];
		//$this->accLog[1] = fopen( $this->accLog[0] ,"a+" );
		//$this->errLog[1] = fopen( $this->errLog[0] ,"a+" );
		//$this->notLog[1] = fopen( $this->notLog[0] ,"a+" );
		//$this->appLog[1] = fopen( $this->appLog[0] ,"a+" );
		//$this->writeLog($this->accLog,'base classs begin.F='.__FILE__.',L='.__LINE__);
		//$this->writeLog($this->errLog,'base classs begin.F='.__FILE__.',L='.__LINE__);
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__construct,f=".__FILE__.",l=".__LINE__."<br>";
	}

	public function __call($name,$arguments)
	{
			//example
		//if( $name == 'foo' ) 
		//{
		//	if( is_int( $arguments[0] ) ) $this->foo_for_int( $arguments[ 0 ] );
		//	if( is_string( $arguments[0] ) ) $this->foo_for_string( $arguments[ 0] );
		//}
	} 
	public function __set($name,$val)
	{
		// if($y==0) throw new Exception("cannot divide by zero");
		throw new Exception ("Hello, you tried to put $val in $name,but $name is not in this class.");
	}
	public function getPrintBody( $tableBody="", $pageSize=10, $title="", $buttom="" )
	{
		$tmplStr = file_get_contents( ABS_PRINT_TMPL_FILE );
		$tmplStr = str_replace( "__PAGESIZE__", $pageSize, $tmplStr );
		$tmplStr = str_replace( "__TITLE__", $title, $tmplStr );
		$tmplStr = str_replace( "__TABLEBODY__", $tableBody, $tmplStr );
		$tmplStr = str_replace( "__BUTTOM__", $buttom, $tmplStr );
		return $tmplStr;
	}

	public function __get($name)
	{
		throw new Exception ("Hello, you asked for $name,but $name is not in this class");
	}
	/*
	protected function getScriptTypeKey( $val )
	{
		$script_type_array = $this->checkScriptTypeArray;
		while ( current ( $script_type_array ) )
			if ( key( $script_type_array ) === $val )
				return key( $script_type_array );
		return NULL;
	}
	*/
	//protected只允许本对象及子派生对象进行访问
	public function writeLog( &$fp, $msg )
	{
        $requestURI = $_SERVER['REQUEST_URI'];
        $msg = $msg . "....Request URI = " . $requestURI;

		if ( !isset( $fp[ 1 ] ) )
		{
			$fp[1] = fopen( $fp[0], 'a+' );
			if ( !$fp )
			{
				throw new Exception ("$fp[0] open is failed, info:writeLog($fp, $msg )\n");
				return ;
			}
			else
			{
				//global $GLOBAL;
				//		print_r( $GlOBAL );

				//print_r( $fp );
				//exit;
				$format = '%d/%m/%Y %H:%M:%S';
				$time = strftime( $format );
				if ( $len = fwrite( $fp[1], $time.":".$msg."\n" ) !== strlen($time.":".$msg."\n") )
					throw new Exception ("write to ".$fp[0]." length is failed, msg length is $len, but write len is $len\n");
			}
		}
		else
		{
			$format = '%d/%m/%Y %H:%M:%S';
			$time = strftime( $format );
			if ( $len = fwrite( $fp[1], $time.":".$msg."\n" ) !== strlen($time.":".$msg."\n") )
				throw new Exception ("write to ".$fp[0]." length is failed, msg length is $len, but write len is $len\n");
		}
	}
	public function __destruct(  )
	{
		//$this->errLog[0] = $cfg['Servers']['errLog'];
		//$this->accLog[0] = $cfg['Servers']['accLog'];
		//$this->writeLog($this->accLog,'base classs end.F='.__FILE__.',L='.__LINE__);
		//$this->writeLog($this->errLog,'base classs end.F='.__FILE__.',L='.__LINE__);
		//echo "asdfasdf<br>";
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__destruct,f=".__FILE__.",l=".__LINE__."<br>";
		if ( isset( $this->accLog[1] ) )
		if ( $this->accLog[1] )
			fclose( $this->accLog[1] );
		if ( isset( $this->errLog[1] ) )
		if ( $this->errLog[1] )
			fclose( $this->errLog[1] );
		if ( isset( $this->notLog[1] ) )
		if ( $this->notLog[1] )
			fclose( $this->notLog[1] );
		if ( isset( $this->appLog[1] ) )
		if ( $this->appLog[1] )
			fclose( $this->appLog[1] );
	}
}
?>