<?php
	$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH.'/kernel.php'] = array(
											'opt=addFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>'opt=listFlag',
														'type'=>'location',
														'info'=>'���ϵͳ�û�'
																	),
											'opt=delFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>'opt=listFlag',
														'type'=>'location',
														'info'=>'ɾ��ϵͳ�û�'
																	),														
											'opt=resetPwd'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>'module=usermanager&app=showtmpl&flag=1&opt=listFlag&menuID=84',
														'type'=>'location',
														'info'=>'��������'
																	),
											'opt=resetPwd'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>'module=usermanager&app=showtmpl&flag=2&opt=listFlag&menuID=85',
														'type'=>'location',
														'info'=>'��������'
																	),
											'opt=listFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>'module=usermanager&app=showtmpl&flag=1&opt=listFlag&id=1&menuID=84',
														'type'=>'location'
																	),
	//http://localhost:81//cgi/backend/usermanager/'showtmpl.php'?opt=page&pagenum=15
											'opt=editFlag'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',

														'to_query'=>'opt=editFlag',
														'type'=>'location',
														'info'=>'�༭ϵͳ�û�'
																	),
											'opt=editFlag&editFlag=menu'=>array	(
														'to_path'=>GLOBAL_ROOT_PATH.'kernel.php',
														'to_query'=>"flag=1&opt=editFlag&editFlag=menu&menuID=40",
														'type'=>'location',
														'info'=>'�û��༭'
																	)
										);

?>