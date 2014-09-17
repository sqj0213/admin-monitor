<?php

/*
 * 数据库列表展现类,具备依据权限显示不能功能按钮的功能,自动显示分页,自动呈现列表,同时提供图片的多行多列显示功能
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
define('ABS_CUR_PAGELIST_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_PAGELIST_DIR . '../function/webOptCode.php');
require_once(ABS_CUR_PAGELIST_DIR . '../function/parseUrl.php');

class pageList
{
    private $sqlStr = '';
    private $tableTitle = array(); 
    private $pageTitle = array();
    private $pageList = array(
        'tableName' => '',
        'userData' => array(0 => array('id' => 1,
                                       '登录名称' => 'test',
                                       '密码' => 'asdf',
                                       '姓名' => '孙全军',
                                       '用户编号' => 1819,
                                       '性别' => '男',
                                       '联系电话' => '010-62675600',
                                       'email' => 'quanjun@staff.sina.com.cn',
                                       '部门' => '无部门',
                                       '角色' => '普通用户',
                                       '登录时间' => '2007-04-26 12:33:20',
                                       '注册时间' => '2007-04-01 10:01:01'
        )
        ),
        'totalRecord' => 0,
        'pageCount' => 0,
        'pageSize' => 0,
        'pageNum' => 1
    );
    private $influenceArr = array();
    private $menuID = 0;
    private $subSql = " where 1=1 ";

    function __construct($pageNum = 0, $menuID = 0, $subSql = "", $influenceCheck = array(
		
			'selectAll' => 0, //全选按钮是否显示
			'antiSelectAll' => 0, //反选按钮是否显示
			'readFlag' => 0, //是否有查看明细的权限
			'addFlag' => 0, //是否有填加的按钮
			'delFlag' => 0, //是否有删除的按钮
			'listFlag' => 0, //是否有列表的权限
			'menuFlag' => 0, //是否有显示菜单的权限
			'customInfluenceItemList' => 0, //是否有定制权限的权限
			'editFlag' => 0, //是否有显示 修改按钮
			'editPower' => 0 //是否显示编辑权限按钮

		)
		)
    {
        //parent::__construct();
        global $GLOBAL;
        if (Empty($pageNum))
            $pageNum = $GLOBAL['modulesInfo']['pageNum'];
        if (Empty($menuID))
            $menuID = $GLOBAL['runData']['menuID'];

        if (Empty($subSql) && isset($GLOBAL['modulesInfo']['subSql']))
            $subSql = $GLOBAL['modulesInfo']['subSql'];
		
       // if ( Empty( $influenceCheck ) )
            $influenceCheck = isset( $GLOBAL['runData']['influenceData'] ) ? $GLOBAL['runData']['influenceData'] :array();
        //	print_r($GLOBAL['runData']['influenceData'] );
        //	exit;
        //global	$list_data_struct;
        $this->menuID = $menuID;
        $this->influenceArr = $influenceCheck;


        $str = '';
		if ( !isset( $this->influenceArr['delFlag']['value'] ) )
			 $this->influenceArr['delFlag']['value'] = 0; 
		if ( !isset( $this->influenceArr['editFlag']['value'] ) )
			$this->influenceArr['editFlag']['value'] = 0; 


        $this->pageTitle = $GLOBAL['modulesInfo'];
        //$this->pageTitle['userKey'] = array();
        $this->pageTitle['userKey'] = $GLOBAL['modulesInfo']['userKey'];
        if (!Empty($GLOBAL['htmlDefine']['tmplPath']))
            $this->pageTitle['tmplPath'] = $GLOBAL['htmlDefine']['tmplPath'];

        if (!Empty($subSql))
            $this->subSql = " " . $this->subSql . " and " . $subSql;

        //print_r(  $GLOBAL['modulesInfo']['tableName'] );

        $this->pageList['tableName'] = $GLOBAL['modulesInfo']['tableName'];
        if (isset($GLOBAL['modulesInfo']['powerList'])) {
            $tmp = $GLOBAL['modulesInfo']['powerList'];
            if (is_array($tmp))
                while (current($tmp) !== false)
                {
                    $this->pageTitle['powerList'][key($tmp)] = intval(current($tmp));
                    next($tmp);
                }
        }
        if (isset($GLOBAL['modulesInfo']['buttomStr']))
            $this->pageTitle['buttomStr'] = $GLOBAL['modulesInfo']['buttomStr'];
        if (isset($GLOBAL['modulesInfo']['pageSize'])) //若子模块定义了列表大小的话
        {
            $this->pageList['pageSize'] = intval($GLOBAL['modulesInfo']['pageSize']);
            $this->pageTitle['pageSize'] = intval($GLOBAL['modulesInfo']['pageSize']);
        }
        else
        {
            $this->pageList['pageSize'] = intval($GLOBAL['listDefaultValue']['pageSize']);
            $this->pageTitle['pageSize'] = intval($GLOBAL['listDefaultValue']['pageSize']);
        }
        $this->pageList['totalRecord'] = intval($GLOBAL['G_DB_OBJ']->getFieldValue("select count(*) from " . $this->pageList['tableName'] . $this->subSql));
        if (($this->pageList['totalRecord'] % $this->pageList['pageSize']) === 0)
            $this->pageList['pageCount'] = $this->pageList['totalRecord'] / $this->pageList['pageSize'];
        else
            $this->pageList['pageCount'] = intval($this->pageList['totalRecord'] / $this->pageList['pageSize']) + 1;

        if ($pageNum > $this->pageList['pageCount'])
            $pageNum = $this->pageList['pageCount'];
        if ($pageNum < 1)
            $pageNum = 1;
        $this->pageList['pageNum'] = $pageNum;

        $this->tableTitle = $this->pageTitle['userKey'];
        $this->initTitleSql($GLOBAL['modulesInfo'], $pageNum);
        $this->sqlStr = $GLOBAL['G_DB_OBJ']->getSqlFromKeyAsKeyArr($this->pageTitle, $this->subSql);
        $this->setButtomLink();
    }

    public function getRecordCount()
    {
        return $this->pageList['totalRecord'];
    }

    public function getTopData()
    {
        return $this->pageList['userData'][0];
    }

    public function replaceMapDataByRegex( &$html_body, $repArr = array(), $regSign )
    {
        //preg_match( '/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i', $html_body, $nodeStr );
        //		print_r( $repArr );
        global $GLOBAL;
        preg_match( $regSign, $html_body, $nodeStr );
        $mapStr = "";

        while ( current( $repArr ) !== false )
        {
            $tmp = current( $repArr );
            $tmpStr = $nodeStr[ 2 ];
            //print_r( $mapStr );
            //exit;
            $id = $tmp['__ID__'];
            while ( current( $tmp ) !== false)
            {
                //$tmplSign = explode( '_', key( $tmp ) );
                //echo key( $tmp ).$GLOBAL['modulesInfo']['primaryLink']['field']."<br>";
                if ( isset( $GLOBAL[ 'modulesInfo' ][ 'primaryLink' ][ 'field' ] ) )
                    if (key($tmp) == $GLOBAL[ 'modulesInfo' ][ 'primaryLink' ][ 'field' ] ) {
                        $tmpStr = str_replace( '__URL__', $GLOBAL[ 'modulesInfo' ][ 'primaryLink' ][ 'url' ], $tmpStr );
                        $tmpStr = str_replace( '__ID__', $id, $tmpStr );
                    }
                $tmpStr = str_replace( key( $tmp ), current( $tmp ), $tmpStr );
                next( $tmp );
            }
            $mapStr .= $tmpStr;
            //exit;
            next( $repArr );
        }
        //print_r( $mapStr );

        return preg_replace( $regSign, $mapStr, $html_body );
    }

    public function getMapData($sqlStr = "")
    {
        global $GLOBAL;
        if (Empty($sqlStr))
            $this->pageList['userData'] = $GLOBAL['G_DB_OBJ']->executeSqlMap($this->sqlStr);
        else
            return $GLOBAL['G_DB_OBJ']->executeSqlMap($sqlStr);
        //print_r( $this->sqlStr );
        return $this->pageList['userData'];
    }

    public function getNodeData() //取数据库一条记录
    {
        global $GLOBAL;
        $tmp = $this->pageTitle;
        $tmp['pageSize'] = 1;
        if (isset($GLOBAL['modulesInfo']['comboxDefaultSelected'])) {
            while (current($GLOBAL['modulesInfo']['comboxDefaultSelected'])) //合并关联数据的id号，便于显示时替换
            {
                $tmp['userKey'][key($GLOBAL['modulesInfo']['comboxDefaultSelected'])] = current($GLOBAL['modulesInfo']['comboxDefaultSelected']);
                next($GLOBAL['modulesInfo']['comboxDefaultSelected']);
            }
            reset($GLOBAL['modulesInfo']['comboxDefaultSelected']);
        }
        $tmp_sql_str = $GLOBAL['G_DB_OBJ']->getSqlFromKeyAsKeyArr($tmp, $this->subSql);
        $tmp1 = $this->pageTitle['userKey'];
        $tmp2 = $GLOBAL['G_DB_OBJ']->executeSqlMap($tmp_sql_str, 2);
        while (current($tmp2) !== FALSE)
        {
            //if ( current( $tmp1 ) === FALSE )
            //	$tmp1[key($tmp2)] = $tmp2[key( $tmp2 )];
            //else
            if (isset($tmp1[key($tmp1)]) == 1)
                $tmp1[key($tmp1)] = $tmp2[key($tmp2)];
            if (isset($GLOBAL['modulesInfo']['comboxDefaultSelected'])) {
                if (current($GLOBAL['modulesInfo']['comboxDefaultSelected']))
                    if (key($GLOBAL['modulesInfo']['comboxDefaultSelected']) === key($tmp2)) {
                        $GLOBAL['modulesInfo']['comboxDefaultSelected'][key($GLOBAL['modulesInfo']['comboxDefaultSelected'])] = $tmp2[key($tmp2)]; //修改关联数据的值,便于替换select的值
                        next($GLOBAL['modulesInfo']['comboxDefaultSelected']);
                    }
            }
            next($tmp1);
            next($tmp2);
        }
        return $tmp1;
    }

    protected function initTitleSql($user_page_title, $pageNum)
    {
        $this->pageTitle['tableName'] = $user_page_title['tableName'];
        $this->pageTitle['userKey'] = $user_page_title['userKey'];
        $this->pageTitle['primaryLink'] = $user_page_title['primaryLink'];
        $this->pageTitle['formAction'] = $user_page_title['formAction'];
        $this->pageTitle['splitPageLink'] = $user_page_title['splitPageLink'];
        $this->pageTitle['pageNum'] = $pageNum;

    }

    protected function setButtomLink()
    {
        $this->pageTitle['buttomStr'] = str_ireplace('__PAGELINK__', $this->pageTitle['splitPageLink'], $this->pageTitle['buttomStr']);
        $this->pageTitle['buttomStr'] = str_ireplace('__TOTALRECORD__', $this->pageList['totalRecord'], $this->pageTitle['buttomStr']);
        $this->pageTitle['buttomStr'] = str_ireplace('__PAGECOUNT__', $this->pageList['pageCount'], $this->pageTitle['buttomStr']);
        $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUM__', $this->pageList['pageNum'], $this->pageTitle['buttomStr']);
        $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMFIRST__', 1, $this->pageTitle['buttomStr']);
        if ($this->pageList['pageNum'] > 1)
            $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMPRE__', $this->pageList['pageNum'] - 1, $this->pageTitle['buttomStr']);
        else
            $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMPRE__', 1, $this->pageTitle['buttomStr']);

        if ($this->pageList['pageNum'] < $this->pageList['pageCount'])
            $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMNEXT__', $this->pageList['pageNum'] + 1, $this->pageTitle['buttomStr']);
        else
            $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMNEXT__', $this->pageList['pageCount'], $this->pageTitle['buttomStr']);
        $this->pageTitle['buttomStr'] = str_ireplace('__PAGENUMLAST__', $this->pageList['pageCount'], $this->pageTitle['buttomStr']);
    }

    public function getTableButtom()
    {
        return $this->pageTitle['buttomStr'] . $this->getButtonHtml();
    }

    public function getTableSql()
    {
        return $this->sqlStr;
    }

    public function getPrintHtml($pageSize = 10, $title = "", $buttom = "")
    {
        global $GLOBAL;
        $str = $this->getTableTitle();
        $this->pageList['userData'] = $GLOBAL['G_DB_OBJ']->executeSqlMap($this->sqlStr);
        $str = $str . $this->getTableBody();
        return $this->getPrintBody($str, $pageSize, $title, $buttom);
    }

    private function getTableStr()
    {
		echo "l=".__LINE__."<br>";
        global $GLOBAL;
        $str = "<form name=form_3_" . $this->pageTitle['tableName'] . " method=post action=\"" . $this->pageTitle['formAction'] . "\">";
        $str = $str . "<table width=\"98%\" align=center border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#87AAD0\" id=\"commtable\">";
        $str = $str . $this->getTableTitle();
        $this->pageList['userData'] = $GLOBAL['G_DB_OBJ']->executeSqlMap($this->sqlStr);
        $str = $str . $this->getTableBody();
        $str = $str . "</table>";
        $str = $str . "<table width=\"100%\"><tr><td align=center>";
        $str = $str . $this->getTableButtom();
        $str = $str . "</td></tr></table>";
        $str = $str . "<input type=hidden name=formname value=form_3_" . $this->pageTitle['tableName'] . ">";
        $str = $str . "</form>";
        return $str;

    }

    public function getHtmlStr($regexStr = '/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i')
    {
		echo "l=".__LINE__."<br>";
        global $GLOBAL;
        $REP_TMP = $GLOBAL['htmlDefine']['replaceArray'];
        $html_body = file_get_contents($this->pageTitle['tmplPath']);
        //$html_body = str_ireplace( "__CSSFILEPATH__",	$this->getTableStr(), $html_body );
        //$html_body = str_ireplace( '__PAGEHTML__',	$this->getTableStr(), $html_body );
        $html_body = $this->replaceMapDataByRegex($html_body, $this->getMapData(), $regexStr);
        $html_body = str_ireplace("</form", '<input type=hidden name=' . MENU_ID . ' value=__MENU_ID__></form', $html_body); //设置表单名称的变量便于后端处理

        if ($formAction !== "")
            $html_body = str_ireplace($this->pageTitle['formAction'], $formAction, $html_body);

        $html_body = str_ireplace("< /form", '<input type=hidden name=' . MENU_ID . ' value=__MENU_ID__></form', $html_body); //设置表单名称的变量便于后端处理

        $html_body = str_ireplace('__MENU_ID__', $this->menuID, $html_body);
        $arr_len = count($REP_TMP);
        if ($arr_len !== 0) //若未传入参数则填加默认的return true函数
            for ($i = 0; $i < $arr_len; $i++)
            {
                $html_body = str_ireplace(key($REP_TMP), $REP_TMP[key($REP_TMP)], $html_body);
                next($REP_TMP);
            }

        $html_body = str_ireplace('__BUTTOMSTR__', $this->pageTitle['buttomStr'] . $this->getButtonHtml(), $html_body);
        $html_body = str_ireplace('</body>', getNoRightMenuScript() . "</body>", $html_body);
        return str_ireplace('__JAVASCRIPT__', getPageScript(), $html_body);
    }

    public function getButtomStr()
    {
        return $this->pageTitle['buttomStr'] . $this->getButtonHtml();
    }

    public function getHtmlString( $regexStr = '/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i', $mapData = array() )
    {
        global $GLOBAL;
        $REP_TMP = $GLOBAL['htmlDefine']['replaceArray'];
        $html_body = file_get_contents($this->pageTitle['tmplPath']);
        //$html_body = str_ireplace( "__CSSFILEPATH__",	$this->getTableStr(), $html_body );
        $html_body = str_ireplace('__PAGEHTML__', $this->getTableStr(), $html_body);
        if ( strstr( $regexStr, 'imgmapdata' ) !== false )
		{
			$cols = isset( $GLOBAL[ 'modulesInfo' ][ 'pageListType' ][ 'colsNum' ] ) ? $GLOBAL[ 'modulesInfo' ][ 'pageListType' ][ 'colsNum' ] : 3;
            $this->getImageTableStr( $html_body, $regSign );
		}
		else
			$this->replaceMapDataByRegex( $html_body, $mapData, $regexStr );
			
        $html_body = str_ireplace("</form", '<input type=hidden name=' . MENU_ID . ' value=__MENU_ID__></form', $html_body); //设置表单名称的变量便于后端处理
        $html_body = str_ireplace("</form", '<input type=hidden name=' . FORM_NAME . '><input type=hidden name=' . UPD_ID_NAME . ' value="__ID__"><input type=hidden name=' . UNION_FIELD . ' value="' . $GLOBAL['modulesInfo']['unionField'] . '"><input type=hidden name=' . MENU_ID . ' value="' . $GLOBAL['runData']['menuID'] . '"></form', $html_body); //设置表单名称的变量便于后端处理

        if ($formAction !== "")
            $html_body = str_ireplace($this->pageTitle['formAction'], $formAction, $html_body);

        $html_body = str_ireplace("< /form", '<input type=hidden name=' . MENU_ID . ' value=__MENU_ID__></form', $html_body); //设置表单名称的变量便于后端处理

        $html_body = str_ireplace('__MENU_ID__', $this->menuID, $html_body);
        $arr_len = count( $REP_TMP );
        if ($arr_len !== 0) //若未传入参数则填加默认的return true函数
            for ($i = 0; $i < $arr_len; $i++)
            {
                $html_body = str_ireplace(key($REP_TMP), $REP_TMP[key($REP_TMP)], $html_body);
                next($REP_TMP);
            }
		echo "l=".__LINE__."<br>";

        //$html_body = str_ireplace( '</body>', getNoRightMenuScript()."</body>", $html_body );
        $html_body = str_ireplace('__BUTTOMSTR__', $this->pageTitle['buttomStr'] . $this->getButtonHtml(), $html_body);
        return str_ireplace('__JAVASCRIPT__', getPageScript(), $html_body);
    }
	private function getImageTableStr( &$htmlBody, $repArr=array(), $regSign="(<!--imgmapdata-->)([\s\S]*?)(<!--imgmapdata-->)", $cols=3 )
	{
		$mapData = $repArr;
		$mapLen = count( $mapData  );
		$row = ( ( $mapLen % $cols ) === 0 ) ? ( $mapLen % $cols ) : $mapLen + 1;
		$nodeStr = array();
        preg_match( $regSign, $htmlBody, $nodeStr );
        $mapStr = "";

		$tmpStr = $nodeStr[ 2 ];
		$tdStrLenOld = strlen( $tmpStr );
		$cursor = 0;
		$retStr = '';
		$totalTD = $row * $cols;
		$tmpArray = $mapData[ 0 ];//取得第二维数组的key
		for ( $cursor = 0; $cursor < $mapLen; $cursor++ )
		{
			for ( $j = 0; $j < $cols; $j++ )
			{
				$tdStr = $tmpStr;
				if ( isset( $mapData[ $cursor ] ) )
				{
					$rowData =  $mapData[ $cursor ];

					while ( current( $rowData ) !== false )
					{
						$tdStr = str_ireplace( key( $rowData ), current( $rowData ), $tdStr );
						next( $rowData );
					}

				}

				if ( $cursor >= $mapLen )
				{
					while ( current( $tmpArray ) !== false )
					{
						$tdStr = preg_replace( '/<td>([\s\S]*?)<\/td>/', '<td></td>', $tdStr );
						next ( $tmpArray );
					}
					reset( $tmpArray );
				}
				else
				{
					//若为最后一列,则cursor不加1
					if ( $j !== ( $cols - 1 ) )
						$cursor++;//notice
				}
				//如果没有了数据,把模板里的表单变量清空
				if ( $tdStrLenOld === strlen( $tdStr ) )
					$retStr = $retStr."<td></td>";
				else
					$retStr = $retStr.$tdStr;
			}

			if ( $cursor < $mapLen - 1 )
				$retStr = $retStr."</tr><tr>";
		}

		$htmlBody = preg_replace( $regSign, $retStr, $htmlBody );
	}
	private function getTableBody()
    {
        $tableBody = $this->pageList['userData'];
        $str = '';
        echo "l=".__LINE__."<br>";
        for ($i = 0; $i < count($tableBody); $i++)
        {
            $table_line = $tableBody[$i];
            if ($i % 2 == 0)
			{
		//echo "l=".__LINE__."<br>";
                $str = $str . "<tr class=tablec1>";
			}
            else
                $str = $str . "<tr class=tablec2>";
            $col = 0;
            while (current($table_line) !== false) //NOTICE VALUE HAVE ZERO VALUE
            {

                if ((key($table_line) === $this->pageTitle['primaryKey']) && ($this->influenceArr['delFlag']['value'] == 1 || $this->influenceArr['editFlag']['value'] == 1)
                )
                    //influenceid_用户角色_integer_1_10_1_1
                    $str = $str . "<td class=text2><INPUT type=checkbox name=id_编号_integer_1_10_0_0[] value=\"" . $table_line[key($table_line)] . "\"</td>";
                else
                {
                    if (key($table_line) !== $this->pageTitle['primaryKey'])
                        if ($this->pageTitle['primaryLink']['field'] === key($table_line)) {
                            $str = $str . "<td class=text2><a href=\"" . str_ireplace('__ID__', $table_line[$this->pageTitle['primaryKey']], $this->pageTitle['primaryLink']['url']) . "\">" . $table_line[key($table_line)] . "</a></td>";
                        }
                        else
                            $str = $str . "<td class=text2>" . $table_line[key($table_line)] . "</td>";
                }
                next($table_line);
                $col++;
            }
            while ($col < count($table_line))
            {
                $str = $str . "<td class=text2>&nbsp;</td>";
                $col++;
            }
            $str = $str . "</tr>";
        }
        return $str;
    }
    private function getTableTitle()
    {
        $str = "<tr class=\"tablett\">";
        while (current($this->tableTitle))
        {
            if ((($this->influenceArr['delFlag']['value'] == 0 && $this->influenceArr['editFlag']['value'] == 0))) {
                if (key($this->tableTitle) !== "id")
                    $str = $str . "<td>" . $this->tableTitle[key($this->tableTitle)] . "</td>";
            }
            else
                $str = $str . "<td>" . $this->tableTitle[key($this->tableTitle)] . "</td>";

            next($this->tableTitle);
        }
        $str = $str . "</tr>";

        return $str;
    }

    private function getButtonHtml()
    {
        global $GLOBAL;
        $tmp = "";


        $str = '';
        if ( $this->pageTitle['powerList']['selectAll'] !== 0 
			&& ($this->influenceArr['delFlag']['value'] == 1 
			|| $this->influenceArr['editFlag']['value'] == 1 ) ) {
            $str = $str . "&nbsp;&nbsp;<INPUT onclick=\"javascript:allchose();\" type=button value=全选 name=B2>";
            $str = $str . "&nbsp;&nbsp;";
        }
      if ($this->pageTitle['powerList']['antiSelectAll'] !== 0 && ($this->influenceArr['delFlag']['value'] == 1 || $this->influenceArr['editFlag']['value'] == 1)) {
            $str = $str . "<INPUT onclick=\"javascript:antichose();\" type=button value=反选 name=B3>";
            $str = $str . "&nbsp;&nbsp;";
        }
        //print_r( $_SESSION );
        //print_r( $this->pageTitle['powerList'] );
        //exit;
        if (isset($this->influenceArr)) {

			$tmpStr2 = substr( $this->pageTitle['splitPageLink'], 0, strpos( $this->pageTitle['splitPageLink'], '?' )+1  );

			$tmpStr1 = substr($this->pageTitle['splitPageLink'], strpos( $this->pageTitle['splitPageLink'], '?' )+1, strlen($this->pageTitle['splitPageLink']) );


           while (current($this->influenceArr) !== false)
            {
                $tmp = current($this->influenceArr);
				if ( !isset( $tmp['value'] ) )
				{
					next( $this->influenceArr );
					continue;
				}
				//若模块未定义要去除此功能的话，则系统自动认为支持，同时要检查用户是否有此权限
                //分为系统级与用户级的双向检查
                if (!isset($this->pageTitle['powerList'][key($this->influenceArr)]))
                    $this->pageTitle['powerList'][key($this->influenceArr)] = 1;
                

                if ($tmp['value'] == 1 && $this->pageTitle['powerList'][key($this->influenceArr)] !== 0) {

                    if (!Empty($GLOBAL['htmlDefine']['optStyle'][$tmp['style']])) {
						//print_r(  $this->pageTitle['splitPageLink'] );
						//print_r( key($this->influenceArr) );
                        $url = $tmpStr2.replaceQueryStringItem( $tmpStr1, "opt", key($this->influenceArr) );

                       //$url = preg_replace('/.php[?0-9=a-z&]{1,100}/i', '.php', $this->pageTitle['splitPageLink']) . str_ireplace("&opt=listFlag", "", getUrlQueryString()) . "&opt=" . key($this->influenceArr);
                        $str = $str . "<input name=\"button\" type=\"button\" id=\"button\" value=\"" . $tmp['name'] . "\" onclick=\"" . str_replace("__URL__", $url, $GLOBAL['htmlDefine']['optStyle'][$tmp['style']]) . "\">";
                    }
                }
                next($this->influenceArr);
            }
            reset($this->influenceArr);
        }
        return $str;
    }

    function __destruct()
    {
        $user_page_title['pageNum'] = 1;
        $this->pageList['pageNum'] = 1;
        $this->sqlStr = '';
        //parent::__destruct();
    }
}

?>