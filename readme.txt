webadmin 作者：孙全军 email:sqj0213@163.com mobile:13910212452
weibo:http://weibo.com/1915815754



1.后端数据模板：
	提供基于标准sql与存储过程的后端数据模板

2.缓存支持:文件类，mc类

3.表单模板：
	定义js校验模板
	定义后端校验模板
	定义sql与存储过程处理模板

4.post数据处理:
	依据module定义的模块配置与refer信息，确认请求的有效性
	依据表单定义的模板信息生成js,验证前端数据填写的有效性
	依据表单模板生成标准sql与存储过程，并完成数据处理请求
	依据module定义的模块配置，自动跳转到下一页面

5.模块:
	注册模块，为post请求提供有效性验证
	从存储提取数据表单显示的数据元，转化为数据表单的元素
	抽象了列表处理模板，集成了翻页，权限的控制

问题：
	模板的定义规则较多


     基于rest为各站点提供用户管理与权限认证

webadmin说明：
     webadmin-backend:
         超级管理员：
		 1.站点管理
		 2.站点审核
	 站点管理员：
		1.填加用户
		2.创建rest树形菜单
		3.定义角色
		4.依据rest-url与角色分配角色的权限
         daemon:
	        1.自动生成相应站点的nginx-plugin
		2.生成站点的signature->key
     webadmin-front:
         1.提供站点人员注册站点界面

     webadmin-plugin:
         1.用户注册的信息验证通过后，依据站点配置生成此站点的nginx-plugin
	 2.nginx-plugin:
		抓取webadmin-daemon的权限数据结构到站点内存
		第一次验证时：从webadmin-daemon主机验证此站点的合法性signature(key+requrestURL+expireTime+opt)
		以后验证时：从本地自行验证
    用户只需要点击鼠标与填写信息，即可完成复杂的用户，角色与权限的验证工作
里程碑：
	过去:webadmin-backend已经完成，基于rest-url的权限控制基础框架已经实现
	现状：nginx-plugin未完成,webadmin-front未完成,webadmin-daemon未完成



新特性:
pageList模组加入图像列表的分页显示
parseUrl模组加入uri参数转化为数组,数组转化为uriString的function
webadmin后台系统加入kernel.php模组便于各管理系统无需copy代码以实现不同的后台管理系统