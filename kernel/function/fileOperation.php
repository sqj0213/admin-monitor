<?php

/*
 *作者:旭日
 *Email:54ano@163.com
 *个人网站:http://www.zhengjingde.com
 */

/*
 *@说明:目录和文件操作类
 *@类名:Dirs
 *@方法:mkDirs($dir),创建多重目录
 *@方法:rmDirs($dir,$rmself=true),删除及清空目录
 *@方法:delFile($file),删除文件
 *@方法:createFile($file,$content="",$mode="w"),创建文件
 *@方法:getFolders($dir),获取目录下的文件夹信息
 *@方法:getFiles($dir),获取目录下的文件信息
 *@方法:getFileSize($file)获取文件的大小
 *@属性:$mFolders,遍历目录下的文件夹信息的数组
 *@属性:$mFiles,遍历目录下的文件信息的数组
 */


class Dirs {

	/*
	*@创建多重目录
	*@mkDirs($dir)
	*@参数$dir:目录的绝对路径
	*@所创建的目录的权限全部为0777
	*@创建失败有提示,成功无返回
	*/
	function mkDirs( $dir )
	{
		$dir = str_replace( "\\", "/", $dir );
		$dirs = explode( '/', $dir );
		$total = count( $dirs );
		$temp = '';
		for ( $i = 0; $i < $total; $i++ )
		{
			$temp .= $dirs[ $i ] . '/';
			if ( !is_dir( $temp ) )
			{
				if ( !@mkdir( $temp ) ) exit( "不能建立目录 $temp" );
				// 改变目录权限 为0777
				@chmod($temp, 0777);
			}
		}
	}
	/*
	*@删除多重目录及文件
	*@清空目录下的所有子目录及文件
	*@rmDirs($dir, $rmself)
	*@参数$dir:目录的绝对路径
	*@参数$rmself:如果$rmself=false,则不删除本目录,否则删除本目录,默认$rmself=true
	*@删除成功返回true,否则返回false
	*/
	function rmDirs( $dir, $rmself = true )
	{
		//如果给定路径末尾包含"/",先将其删除
		if( substr( $dir, -1 ) =="/" )
			$dir=substr($dir,0,-1);
		
		//如给出的目录不存在或者不是一个有效的目录，则返回
		if( !file_exists( $dir ) || !is_dir( $dir ) )
			return false;
		//如果目录不可读，则返回
		elseif ( !is_readable( $dir ) )
			return false;
		else
		{
			//打开目录，
			$dirs= opendir( $dir );
			//当目录不空时，删除目录里的文件
			while ( false !== ( $entry = readdir( $dirs ) ) )
			{
				//过滤掉表示当前目录的"."和表示父目录的".."
				if ( $entry != "." && $entry != ".." )
				{
					$path = $dir . "/" . $entry;
					//为子目录，则递归调用本函数
					if ( is_dir( $path ) )
						$this->rmDirs( $path );
					//为文件直接删除
					else 
						unlink( $path );
				}
			}
			//关闭目录
			closedir($dirs);
			//当$rmself==false时,只清空目录里的文件及目录,$rmself=true时,也删除$dir目录
			if( $rmself )
			{
				//删除目录
				if(!rmdir($dir))
					return false;
				return true;
			}
		}
	}
	/*
	*@删除文件
	*@删除失败返回false,否则返回true
	*/
	function delFile( $file )
	{
		if ( !is_file( $file ) ) return false;
		@unlink( $file );
		return true;
	}
	/*
	*@创建文件
	*@方法:createFile ($file, $content, $mode);
	*@参数$file:文件的绝对路径
	*@参数$content:创建文件时添加入文件的内容
	*@参数$mode:$mode=w时,内容清空后添加进入,$mode=a,内容添加在已有内容的尾部,默认为w
	*@创建失败返回false,否则返回true
	*/
	function createFile( $file, $content = "", $mode = "w" )
	{
		if ( in_array( $mode, array( "w", "a" ) ) ) $mode = "w";
		if ( !$hd = fopen( $file, $mode ) ) return false;
		if ( !false === fwrite( $hd, $content ) ) return false;
		return true;
	}
	/*
	*@浏览目录
	*/
	function getFolders( $dir )
	{
		$mFolders = Array();

		//如果给定路径末尾包含"/",先将其删除
		if( substr( $dir, -1 ) == "/" )
			$dir=substr( $dir, 0, -1 );

		//如给出的目录不存在或者不是一个有效的目录，则返回
		if( !file_exists( $dir ) || !is_dir( $dir ) )
			return false;

		//打开目录，
		$dirs = opendir( $dir );
		//把目录下的目录信息写入数组
		$i = 0;

		while ( false !== ( $entry = readdir( $dirs ) ) ) 
		{
			//过滤掉表示当前目录的"."和表示父目录的".."
			if ( $entry != "." && $entry != ".." )
			{
				$path = $dir . "/" . $entry;
				//为子目录，则采集信息
				if( is_dir( $path ) )
				{
					$filetime = @filemtime( $path );
					$filetime = @date( "Y-m-d H-i-s", $filetime + 3600 * 8 );
					// 目录名
					$mFolders[ $entry ][ 'name'] = $entry;
					// 目录最后修改时间
					$mFolders[ $entry ][ 'filetime' ] = $filetime;
					// 目录大小,不计,设为0
					$mFolders[ $entry ][ 'filesize' ] = 0;
					$i++;
				}
			}
		}
		return $mFolders;
	}

	/*
	*@浏览文件
	*/
	function getFiles( $dir )
	{

		$mFiles = Array();
		//如果给定路径末尾包含"/",先将其删除
		if( substr( $dir,-1) == "/" )
			$dir = substr( $dir, 0, -1 );

		//如给出的目录不存在或者不是一个有效的目录，则返回
		if ( !file_exists( $dir ) || !is_dir( $dir ) )
			return false;
	
		//打开目录，
		$dirs= opendir( $dir );
		//把目录下的文件信息写入数组
		$i = 0;
		while ( false !== ( $entry = readdir( $dirs ) ) )
		{
		//过滤掉表示当前目录的"."和表示父目录的".."
			if ( $entry != "." && $entry != ".." )
			{
				$path=$dir."/".$entry;
				//为子目录，则采集信息
				if( is_file( $path ) )
				{
					$filetime = @filemtime( $path );
					$filetime = @date( "Y-m-d H-i-s", $filetime + 3600 * 8 );
					$filesize = Dirs::getFileSize( $path );
					$mFiles[ $entry ][ 'filesize' ] = $filesize;
					$mFiles[ $i ][ 'type' ] = 'f';
				}
				else
				{
					$filetime = @filemtime( $path );
					$filetime = @date( "Y-m-d H-i-s", $filetime + 3600 * 8 );
					$mFiles[ $entry ][ 'filesize' ] = 0;
					$mFiles[ $entry ][ 'type' ] = 'd';
				}
				// 文件名
				$mFiles[ $entry ][ 'name' ] = $entry;
				// 文件最后修改时间
				$mFiles[ $entry ][ 'filetime'] = $filetime;
				// 文件的大小
				$i++;
			}
		}
		return $mFiles;
	}
		/*
	*@获取文件的大小:字节,KB,MB,GB
	*/
	 function getFileSize( $file ) {
		if ( !is_file( $file ) ) return 0;
		$f1 = $f2 = "";
		$filesize = @filesize("$file");
		// 大于1GB以上的文件
		if ( $filesize > 1073741824 )
		{
		// 大于1MB以上的文件
		}
		elseif ( $filesize > 1048576 )
		{
			$filesize = $filesize / 1048576;
			list($f1, $f2) = explode(".",$filesize);
			$filesize = $f1.".".substr($f2, 0, 2)."MB";
			// 大于1KB小于1MB的文件
		} elseif ( $filesize > 1024 )
		{
			$filesize = $filesize / 1024;
			list($f1, $f2) = explode(".",$filesize);
			$filesize = $f1.".".substr($f2, 0, 2)."KB";
			// 小于1KB的文件
		} else
		{
			$filesize = $filesize."字节";
		}
		return $filesize;
	 }

}

