<?php
//填加权限:style=popUp:addFlag=1|删除权限:style=mulSele:delFlag=1|修改权限:style=singleSele:editFlag=1|只读权限:style=null:readFlag=1|列表权限:style=null:listFlag=1|菜单显示权限:style=null:menuFlag=1|自定义权限:style=auto:customInfluenceList=1
	function parseStr( $srcStr )
	{
		//echo ( $srcStr );
		$retArr = array();
//		print_r( $srcStr );
		$tmpArr1 = explode( "|" , $srcStr );
		$j = 0;
		for ( $i = 0; $i < count( $tmpArr1 ); $i++ )
		{
//			print_r( $tmpArr1 );
			if ( isset($tmpArr1 ) )
				$tmpArr2 = explode( ":", $tmpArr1[ $i ] );
			else
				continue;
			//style=popUp:addFlag=1
			if ( isset( $tmpArr2[1] ) )
				$tmpArr3 = explode( "=", $tmpArr2[1] );
			else
				continue;	
			if ( isset( $tmpArr2[2] ) )

			$tmpArr4 = explode( "=", $tmpArr2[2] );
			if ( isset( $tmpArr4[ 0 ] ) )
			{
				$retArr[ $tmpArr4[ 0 ]][ 'value' ] = $tmpArr4[ 1 ];
				$retArr[ $tmpArr4[ 0 ]][ 'name' ] = $tmpArr2[ 0 ];
				$retArr[ $tmpArr4[ 0 ]][ $tmpArr3[ 0 ] ] = $tmpArr3[ 1 ];
			}
			else
				continue;
	
			
		}
			//print_r( $retArr );
			//exit;
		return $retArr;
	}

?>