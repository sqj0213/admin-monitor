<?php
class tmplClass
{
	private $tmplPath = "";
	private $replaceArray = array();
	private $tmplStr = "";
	private $runMsg = "success";
	public function __construct()
	{
		
	}
	public function resetArray( $replaceArr = array() )
	{
		$this->replaceArray = $replaceArr;	
	}
	public function initPara( $tmplPath, $replaceArr=array() )
	{
		$this->tmplPath = $tmplPath;
		$this->tmplStr =  file_get_contents( $tmplPath );
		if ( Empty( $this->tmplStr ) )
		{
			return 0;
		}
		$this->replaceArray = $replaceArr;
		if ( !Empty( $this->replaceArray ) )
			$this->replaceArray();

		return 1;
	}
	public function regexReplaceBySign(  $replaceArray, $regexSing )
	{
		if ( !Empty( $this->replaceArray ) )
			$this->replaceArray();

		//preg_match( '/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i', $html_body, $nodeStr );
		preg_match( $regexSing, $this->tmplStr, $nodeStr );
		//print_r( $nodeStr );
		//print_r( $replaceArray );
		//exit;
		$mapStr = "";
		while ( current( $replaceArray ) !== false )
		{
			$tmp = current( $replaceArray );
			//print_r( $tmp );
			//exit;
			$tmpStr = $nodeStr[2];
			//print_r( $mapStr );
			//exit;
			while ( current( $tmp ) !== false )
			{
				//$tmplSign = explode( '_', key( $tmp ) );
				$tmpStr = str_replace( key( $tmp ), current( $tmp ), $tmpStr  );
				next( $tmp );
			}
			$mapStr .= $tmpStr;
			//print_r( $mapStr );
			//exit;
			next( $replaceArray );
		}
		$this->tmplStr =  preg_replace( $regexSing, $mapStr, $this->tmplStr );		
	}
	private function replaceArray()
	{
		$arrayLen = count( $this->replaceArray );

		if ( $arrayLen !==0 )//若未传入参数则填加默认的return true函数
		for ( $i = 0; $i < $arrayLen; $i++ )
		{
			$this->tmplStr = str_ireplace( key( $this->replaceArray ), $this->replaceArray[key( $this->replaceArray )], $this->tmplStr );
			next( $this->replaceArray );
		}
		$this->replaceArray = array();
	}
	public function getHtmlCode(  )
	{
		if ( Empty( $this->tmplPath ) )
			return "模板未初始化!";

		$this->replaceArray();
		return $this->tmplStr;
	}
	public function __destruct()
	{
		
	}
}
?>