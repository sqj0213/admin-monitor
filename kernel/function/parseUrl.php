<?php
if (!function_exists('apache_request_headers')) {
    eval('
        function apache_request_headers() {
            foreach($_SERVER as $key=>$value) {
                if (substr($key,0,5)=="HTTP_") {
                    $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                    $out[$key]=$value;
                }
            }
            return $out;
        }
    ');
} 
	//ȡ��ǰһ������ĵ�ַ
	function getPreUrlPathQurey()
	{
		static $parse_url;//������ε���apache����
		if ( isset( $parse_url ) )
			return $parse_url;
		else
		{
			$head=apache_request_headers();
			//print_r( $head );
			$parse_url = parse_url( $head['Referer'] );
		}
		return $parse_url;
	}
	function getCurrentUrlPathQueryString()
	{
		$url = "";
		if ( isset( $_SERVER['HTTP_HOST'] ) )
		{
			$url = $url."http://".$_SERVER['HTTP_HOST'];

			if ( isset( $_SERVER['SERVER_PORT'] ) )
				$url = $url.":".$_SERVER['SERVER_PORT'];
			if ( isset( $_SERVER['REQUEST_URI'] ) )
				$url = $url.$_SERVER['REQUEST_URI'];
		}
		return $url;
	}
	//print_r( $_SERVER );
	function getUrlServer()
	{
		$url = "";
		if ( isset( $_SERVER['HTTP_HOST'] ) )
		{
			$url = $url."http://".$_SERVER['HTTP_HOST'];

			if ( isset( $_SERVER['SERVER_PORT'] ) )
				$url = $url.":".$_SERVER['SERVER_PORT'];
		}
		return $url;
	}
	function getUrlPathQuery()
	{
		return $_SERVER['REQUEST_URI'];
	}
	function removeQueryStringItem( $queryString, $key )
	{

		$tmpArr = parseQueryStringToArray( $queryString );

		if ( isset( $tmpArr[ $key ] ) )
		{
			unset( $tmpArr[ $key ] );
		}
		$retStr = parseQueryArrayToString( $tmpArr );
		return $retStr;
	}
	function replaceQueryStringItem( $queryString, $key, $value )
	{
		$tmpArr = parseQueryStringToArray( $queryString );
		if ( isset( $tmpArr[ $key ] ) )
		{
			 $tmpArr[ $key ] = $value;
		}
		return parseQueryArrayToString( $tmpArr );
		
	}
	function parseQueryArrayToString( $queryArray )
	{
		$retStr = '';
		//$queryArray = array_unique( $queryArray );

		while ( current( $queryArray ) !== false )
		{
			$tmpStr = key( $queryArray).'='.current( $queryArray );
			$retStr = $retStr.$tmpStr.'&';
			next( $queryArray );
		}
		return substr( $retStr, 0, -1 );
	}
	function parseQueryStringToArray( $queryString )
	{
		//print_r( $queryString );
		$retArr = array();
		if ( !Empty( $queryString ) )
			$queryString = str_replace( '?', '', $queryString );
		if ( !Empty( $queryString ) )
		{
			$tmpArr = explode( '&', $queryString );
			if ( !Empty( $queryString ) )
			while ( current( $tmpArr ) !== false )
			{
				$keyValue = explode( '=', current( $tmpArr ) );
				if ( !isset( $keyValue[0] ) )
				{
					next( $tmpArr );
					continue;
				}
				$retArr[ $keyValue[0] ] = $keyValue[1];
				next( $tmpArr );
			}
		}
		return $retArr;

	}
	function getUrlQueryString()
	{
		//echo $_SERVER['QUERY_STRING'];
		return "?".$_SERVER['QUERY_STRING'];
	}
?>
