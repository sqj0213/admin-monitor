<?php
function getClientIP()
{
	if ( !Empty( $_SERVER['HTTP_X_CLIENT_ADDRESS'] )	 )
		$ip = $_SERVER["HTTP_X_CLIENT_ADDRESS"];
	elseif ( ( isset( $HTTP_SERVER_VARS ) ? $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]: 0 ) )
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	elseif ( ( isset( $HTTP_SERVER_VARS ) ? $HTTP_SERVER_VARS["HTTP_CLIENT_IP"]: 0 ))
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	elseif ( ( isset( $HTTP_SERVER_VARS ) ? $HTTP_SERVER_VARS["REMOTE_ADDR"] : 0 ) )
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	elseif (getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	elseif (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	elseif (getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else
		$ip = "Unknown";
	return $ip;
}
?>