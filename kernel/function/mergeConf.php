<?php

function mergeConf(&$GLOBAL=array(), $appConf=array())
{

	if ( isset( $appConf ) ) 
	{
		while ( current( $appConf ) )
		{
			if (  key( $appConf ) === "GLOBAL" )
			{
				$value1 = current( $appConf );

				while ( current( $value1 ) )
				{
					$tmpArray = explode( '.', key( $value1 ) );

						
					$i = count( $tmpArray );
					$tmp = '';
	
					if ( $i < 4 )
					{
						if ( isset( $tmpArray[ 2 ] ) )
						{
							$GLOBAL[ $tmpArray[ 0 ] ][ $tmpArray[ 1 ] ][ $tmpArray[ 2 ] ] = current( $value1 );	
						}
						elseif ( isset( $tmpArray[ 1 ] ) )
						{
							$GLOBAL[ $tmpArray[ 0 ] ][ $tmpArray[ 1 ] ] = current( $value1 );	
						}	
						else
						{
							if ( current( $value1 ) === 'off' )
								$GLOBAL[ key( $value1 ) ] = false;


						}
					}
					if ( current( $value1 ) == 'off' )
					{
								$GLOBAL[ key( $value1 ) ] = false;

					}
					next( $value1 );
				}
			}
			next( $appConf );
		}
//		reset( $appConf );	
	}
}
?>