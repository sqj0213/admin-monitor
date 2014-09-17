<?php
define( 'ABS_CUR_APPCLASS_DIR', dirname(__FILE__).'/' );
require_once( ABS_CUR_APPCLASS_DIR.'../../../kernel/baselib/baseClass.php' );
class sendCMD extends baseClass
{
	private	$cmdSN = '';
	private	$cmd = '';
	private $serverIPList = '';
	private $cmdPara = array();

	private $listObj = null;
	private $_dbObj = null;
	private $conf = '';
	private $taskData = '';
	public function __construct()
	{
		parent::__construct();
	}
	public function init( $_cmdSN, $_cmd, $_serverIPList, $_cmdPara, $_dbObj, $_conf )
	{
		$this->cmdSN = $_cmdSN;
		$this->cmd = $_cmd;
		$this->serverIPList = $_serverIPList;
		$this->cmdPara = $_cmdPara;
		$this->conf = $_conf;
		$this->_dbObj = $_dbObj;
		$this->listObj =  new Redis( );
		$this->listObj->connect($this->conf['sendcmd']['host'], $this->conf['sendcmd']['port'], intval( $this->conf['sendcmd']['dbIndex'] ) );
		$this->listObj->select( intval( $this->conf['sendcmd']['dbIndex'] ) );
	}
	private function buildSendCMDList()
	{
		$arrLen = count( $this->serverIPList );

		if ( $arrLen === 0 )
		{
			$this->_dbObj->writeLog( $this->_dbObj->errLog, 'ip list is empty!(f='.__FILE__.',l='.__LINE__.')' );
			return ;
		}

		for ( $i = 0; $i < $arrLen; $i++ )
		{
			$this->taskData[ $this->serverIPList[ $i ][ 'ip' ] ] = json_encode( array( 'cmdSN'=>$this->cmdSN, 'cmdStr'=>$this->cmd, 'para'=>$this->cmdPara ) );
		}
		$this->_dbObj->writeLog( $this->_dbObj->accLog, 'buildCMDList ok!(f='.__FILE__.',l='.__LINE__.')' );
	}

	public function sendCMD()
	{
		$this->buildSendCMDList();

		$tmpSqlStr = str_replace( '__CMDSN__', $this->cmdSN, $this->conf['mysqlSQL']['cmdSQLDetailTmpl'] );
		while( current( $this->taskData ) )
			{
				$this->listObj->lpush( $this->conf['sendcmd']['listPrefixStr'].key( $this->taskData ), current( $this->taskData ) );
				$this->_dbObj->writeLog( $this->_dbObj->accLog, 'sendCMD ok!listKey:'.$this->conf['sendcmd']['listPrefixStr'].key( $this->taskData ).',listValue:'.current( $this->taskData ).'(f='.__FILE__.',l='.__LINE__.')' );

				$sqlStr = str_replace( '__IP__', key( $this->taskData ), $tmpSqlStr );
				$sqlStr = str_replace( '__CMDSTR__', current( $this->taskData ), $sqlStr );
				$this->_dbObj->executeSql( $sqlStr );
				next( $this->taskData );
			}
			reset( $this->taskData );
	}
	public function __destruct()
	{
		$this->listObj->close();
		parent::__destruct();
	}

}
?>