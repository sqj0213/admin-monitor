<?php
define( 'HASH_COUNT', 8 );//在相应的cache创建HASH_COUNT个子目录
define( 'CACHE_EXPIRETIME', 0 );//永不过期
class cache
{
	private $expireTime = CACHE_EXPIRETIME;
	private $cacheRootDir = './temp/';
	private $errMsg;
	function __construct( $_cacheRootDir='' )
	{
		global $GLOBAL;
		if ( Empty( $_cacheRootDir ) )
		{

			$cacheConf = explode( "|", $GLOBAL[ 'serverInfo' ][ 'cacheConf' ] );
			$this->cacheRootDir = $cacheConf[ 1 ];		
		}
		else
			$this->cacheRootDir = $_cacheRootDir;
		//print_r( $this->cacheRootDir );
		$this->init();
	}
	function __destruct()
	{
		//global $GLOBAL;
		//$GLOBAL[ 'G_DB_OBJ' ]->writeLog( $GLOBAL[ 'G_DB_OBJ' ]->errLog, $this->errMsg );	
	}
    function checkInitStatus()
    {
    	if ( is_dir( $this->cacheRootDir.'/1' ) && is_dir( $this->cacheRootDir.'/'.( HASH_COUNT - 1) ) )
    		return true;
    	else
    		return false;
    }
	function init()
	{
		if ( !$this->checkInitStatus() )
		{
			$i = 0;
			for ( $i = 0; $i < HASH_COUNT; $i++ )
			{
				$tmpDir = $this->cacheRootDir.'/'.$i;
				mkdir( $tmpDir );
			}
		}
	}
	
	function getKeyFilePath( $key='' )
	{
		$hashKey = abs( crc32( $key ) )%HASH_COUNT;
		if ( !is_dir( $this->cacheRootDir.'/'.$hashKey.'/'.$this->expireTime ) )
			mkdir( $this->cacheRootDir.'/'.$hashKey.'/'.$this->expireTime );
		return $this->cacheRootDir.'/'.$hashKey.'/'.$this->expireTime.'/'.md5($key);
	}
	function buildCache( $key='', $value='' )
	{
		if ( file_put_contents( $this->getKeyFilePath( $key ), $value ) > 0 )
		{
			return true;
		}
		else
		{
			$this->errMsg = 'build cache failed!info('.$this->getKeyFilePath( $key ).')';
			return false;	
		}	
	}
	function getCache( $key )
	{
		return @file_get_contents( $this->getKeyFilePath( $key ) );
	}
	function resetCache()
	{
		
		
	}
}
?>