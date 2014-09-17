<?php
/*
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 *
 * 根据数组生成xml
 */
class XML 
{
	private $charSet = "utf-8";
	private $xslPath = "";
	public function __construct()
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__construct,f=".__FILE__.",l=".__LINE__."<br>";
	
	}
	public function __destruct()
	{
		global $GLOBAL;
		if ( $GLOBAL['debugFlag'] == "on" )
			echo "__destruct,f=".__FILE__.",l=".__LINE__."<br>";

	}
	public function setCharSet( $_charSet = "utf-8" )
	{
		$this->charSet = $_charSet;
	}
	public function getCharSet( )
	{
		return $this->charSet;
	}
	public function setXSLTPath( $_xslPath = "" )
	{
		$this->xslPath = $_xslPath;
	}
	public function getXSLPath( )
	{
		return $this->_xslPath;
	}

	private function printXMLHeader( )
	{
		header( "Content-type:text/xml;charset=".$this->charSet."\n" );
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	}
	private function printXSLTHeader( )
	{
		if ( !Empty( $this->xslPath ) )
			echo "<?xml:stylesheet type=\"text/xsl\" href=\"".$this->xslPath."\"?>\n";
	}
	public function getXML( $xmlData=array(), $prtFlag=0 )
	{
		$xmlStr = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"."<dataStore>\n".$this->getXMLData( $xmlData )."</dataStore>\n";
		if ( $prtFlag )
		{
			$this->printXMLHeader();
			$this->printXSLTHeader();
			echo "<dataStore>\n".$this->getXMLData( $xmlData )."</dataStore>";
		}
		return $xmlStr;
	}
	public function getXMLBody( $rootItem="dataStroe", $xmlData=array() )
	{
			return "<".$rootItem.">".$this->getXMLData_v1( $xmlData )."</".$rootItem.">";
	}
	public function parseFields ( $xmlData='' )
	{
	    // read the XML database of fields
	    $parser = xml_parser_create();
	    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	    xml_parse_into_struct($parser, $xmlData, $values, $tags);
	    xml_parser_free($parser);
	    $fields = null;
	
	    // loop through the structures
	    $fieldIndices = $tags['ITEM'];

	    for ( $i = 0; $i < count( $fieldIndices ); $i++ )
	    {
	        $fieldInfo = $values[ $fieldIndices[ $i ] ];
	       // print_r( $fieldInfo );

	        $fields[ $fieldInfo[ 'attributes' ][ 'KEY' ] ] = $fieldInfo[ 'attributes' ][ 'VALUE' ];
	    }
	    return $fields;
	}
	
	public function getArrayFromXml( $xml )
	{
		$xml = implode( "", explode('\n',$xml) );
		$parser = xml_parser_create( 'utf-8' ); // For Latin-1 charset
		xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 ); // Dont mess with my cAsE sEtTings
		xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 ); // Dont bother with empty info
		//print_r( xml_set_element_handler($parser, 'SERVICE', 'SERVICE') ); 

		xml_parse_into_struct( $parser, $xml, $values, $tags );

		xml_parser_free($parser);
		$return = array(); // The returned array
		$stack = array(); // tmp array used for stacking
		foreach ( $values as $val )
		{
			if( $val[ 'type' ] == "open" )
			{
				array_push($stack, $val['tag']);
			}
			elseif( $val[ 'type' ] == "close" )
			{
				array_pop( $stack );
			} elseif( $val['type'] == "complete" )
			{
				array_push( $stack, $val[ 'tag' ] );
				$this->setArrayValue( $return, $stack, $val[ 'value' ] );
				array_pop( $stack );
			}
		}
		return $return;
	}
		
	private function setArrayValue( &$array, $stack, $value )
	 {
		if ( $stack )
		{
			$key = array_shift( $stack );
			$this->setArrayValue( $array[ $key ], $stack, $value );
			return $array;
		}
		else
		{
			$array = $value;
		}
	}
	public function getXMLData_v1( $para=array() )
	{
		$XMLStr = "";
		$value = "";

		while( 1 )
		{
			$tmp = each( $para ); 
			$val1 = $tmp['key'];
			
			if ( $tmp  === false )
				return $XMLStr;
			if ( is_array( $para[ $val1 ] ) )
			{
				if ( is_int( $val1 ) )
					$XMLStr .= "<item>";
				else
					$XMLStr .= "<".$val1.">";

				$XMLStr .= $this->getXMLData_v1( $para[ $val1 ] );
				
				if ( is_int( $val1 ) )
					$XMLStr .= "</item>";
				else
					$XMLStr .= "</".$val1.">";
			}
			else
			{
					if ( is_int( $val1 ) )
					{
						$XMLStr .= "<item>".preg_replace( "/\&/", "&amp;", $para[ $val1 ] )."</item>";
					}
					else
					{
						$XMLStr .= "<".$val1.">".preg_replace( "/\&/", "&amp;", $para[ $val1 ] )."</".$val1.">";
					}
			}

		//	next( $para );
		}
		
		return $XMLStr;
	}

	public function getXMLData( $para=array() )
	{
		$XMLStr = "";
		$value = "";

		while( 1 )
		{
			$tmp = each( $para ); 
			$val1 = $tmp['key'];
			
			if ( $tmp  === false )
				return $XMLStr;
			if ( is_array( $para[ $val1 ] ) )
			{
				if ( is_int( $val1 ) )
					$XMLStr .= "<item>\n";
				else
					$XMLStr .= "<".$val1.">\n";

				$XMLStr .= $this->getXMLData( $para[ $val1 ] );
				
				if ( is_int( $val1 ) )
					$XMLStr .= "</item>\n";
				else
					$XMLStr .= "</".$val1.">\n";
			}
			else
			{
					if ( is_int( $val1 ) )
					{
						$XMLStr .= "\t<item>".preg_replace( "/\&/", "&amp;", $para[ $val1 ] )."</item>\n";
					}
					else
					{
						$XMLStr .= "\t<".$val1.">".preg_replace( "/\&/", "&amp;", $para[ $val1 ] )."</".$val1.">\n";
					}
			}

		//	next( $para );
		}
		
		return $XMLStr;
	}
}

?>