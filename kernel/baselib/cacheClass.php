<?php
class cacheClass
{
	private $cacheKey = "";
	static $supportObjectList = "formCheck,postPage,pagelist,xmlClass,db_base_class";
	private $cacheType = array( 'staticHtml', '');
	public function __construct()
	{
	
	}
	public function __destruct()
	{
		
	}
}
?>