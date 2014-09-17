<?php
function getWinCloseScriptNoReload($altmsg = NULL)
{
    $str = '<script language=javascript>';

    if (!is_null($altmsg))
        $str = $str . 'alert(\'' . $altmsg . '\');';

    $str = $str . 'window.close();';

    $str = $str . '</script>';

    return $str;
}

function getDefaultJavascript()
{
    $str = "<script langauge=javascript>\n";
    $str = $str . "<!--\n";
    $str = $str . "function frm_chk()\n";
    $str = $str . "{return true;}\n";
    $str = $str . "//-->\n";
    $str = $str . "</script>\n";
    return $str;
}

function webSearchSql()
{
    global $webSearchSqlKey, $webSearchDenyChar;

    $searchSql = '';
    $tmpArr = array();
    $fieldList = array();
    //print_r( $_POST );
    //exit;
    $retArr = array();
	//print_r( $_REQUEST );
    $retArr['searchList'] = '';
    while (current($_REQUEST) !== false)
    {
        $tmpStr = '';
        if (preg_match(WEB_SEARCH_ITEM_ROLE, key($_REQUEST), $tmpArr)) {

            $fieldArr = preg_split('/_/', key($_REQUEST));

            if (strlen(current($_REQUEST)) !== 0) {
                array_push($fieldList, $fieldArr[0] . " " . str_replace('_VAL_', current($_REQUEST), $webSearchSqlKey[$fieldArr[1]]));
                $retArr['searchList'] .= key($_REQUEST) . '=' . current($_REQUEST) . '&';
            }

        }
		else
		{
			if ( strlen( $_REQUEST[ key( $_REQUEST ) ] ) !== 0 )
                $retArr['searchList'] .= key($_REQUEST) . '=' . current($_REQUEST) . '&';
		}

        next($_REQUEST);
    }
    if (!Empty($retArr['searchList']))
        $retArr['searchList'] = substr($retArr['searchList'], 0, -1);
    if (count($fieldList) > 1)
        $retArr['subSql'] = implode(' and ', $fieldList);
    else if (count($fieldList) == 1)
        $retArr['subSql'] = $fieldList[0];
    else
        $retArr['subSql'] = '';
    return $retArr;
}

function getWinCloseScript_parent($altmsg = NULL)
{
    $str = '<script language=javascript>';

    if (!is_null($altmsg))
        $str = $str . 'alert(\'' . $altmsg . '\');';

    $str = $str . 'parent.window.close();';

    $str = $str . '</script>';

    return $str;
}

function getWinAlert($altmsg = NULL)
{
    $str = '<script language=javascript>';

    if (!is_null($altmsg))
        $str = $str . 'alert(\'' . $altmsg . '\');';

    $str = $str . '</script>';

    return $str;
}

function getWebLocationScript($url, $altmsg = NULL, $obj = "")
{
    $str = '<script language=javascript>';

    if (!is_null($altmsg))
        $str = $str . 'alert(\'' . $altmsg . '\');';
    if ($obj != "")
        $str = $str . $obj . '.location.href=\'' . $url . '\';';
    else
        $str = $str . 'location.href=\'' . $url . '\';';

    $str = $str . '</script>';

    return $str;
}

function getErrorTmplLocation($errMsg = "", $url)
{
    global $GLOBAL;
    $tmplPath = $GLOBAL['htmlDefine']['errTmplPath'];
    $tmplHtml = file_get_contents($tmplPath);
    $tmplHtml = str_replace("__ERRMSG__", $errMsg, $tmplHtml);
    $errMsg = "";
    $errMsg = $errMsg . "<a href=\"" . $url . "\">返回</a>\n";
    $tmplHtml = str_replace("__JAVASCRIPT__", $errMsg, $tmplHtml);
    return $tmplHtml;
}

function getNoRightMenuScript()
{
    $script_str = "\n<script language=\"javascript\">\n";
    $script_str = $script_str . "<!--\n";
    $script_str = $script_str . "function Click()";
    $script_str = $script_str . "{";
    $script_str = $script_str . "window.event.returnValue = false;";
    $script_str = $script_str . "}";
    $script_str = $script_str . "document.body.oncontextmenu = Click;//-->";
    $script_str = $script_str . "</script>\n";
    return $script_str;
}

function getErrorTmpl($errMsg = "")
{
    global $GLOBAL;
    $tmplPath = $GLOBAL['htmlDefine']['errTmplPath'];
    $tmplHtml = file_get_contents($tmplPath);
    $tmplHtml = str_replace("__ERRMSG__", $errMsg, $tmplHtml);
    $errMsg = "";
    $errMsg = $errMsg . "<a href=\"#\" onclick=\"javascript:back();\">返回</a>\n<script language=javascript>\n";
    $errMsg = $errMsg . "<!--\n";
    $errMsg = $errMsg . "function back()\n";
    $errMsg = $errMsg . "{\n";
    $errMsg = $errMsg . "history.back();\n";
    $errMsg = $errMsg . "}\n//-->\n</script>";
    $tmplHtml = str_replace("__JAVASCRIPT__", $errMsg, $tmplHtml);
    return $tmplHtml;
}

function getHistoryBackScript($altmsg = NULL)
{
    $str = "<script type='text/javascript'>\n";
    if (!is_null($altmsg))
        $str = $str . "alert(\"" . $altmsg . "\");\n";
    $str = $str . "history.back();\n";
    $str = $str . "</script>";

    return $str;
}

function getWinCloseScript($altmsg = NULL)
{
    $str = '<script language=javascript>';

    if (!is_null($altmsg))
        $str = $str . 'alert(\'' . $altmsg . '\');';

    $str = $str . 'window.opener.location.reload();';
    $str = $str . 'window.close();';

    $str = $str . '</script>';

    return $str;
}

//example:'__INFLUENCE__'=>getComboxFromSql( 'influenceid_用户角色_integer_1_10_1_1', 'select id,name from influence '.$influenceStr.' order by id desc', $influenceID ),//需要调用数据库进行再次查询并替换的变量
function getComboxFromSql($name, $sql, $defaultValue = "", $onChange = false, $key = "", $value = -1, $selectAttribute = "")
{
    global $GLOBAL;
    if ($onChange)
        $str = "<select name=\"" . $name . "\" id=\"" . $name . "\" " . $selectAttribute . " onChange=\"javascript:this.form.action='__FORMACTION__';if ( options[selectedIndex].value != '0' ) { this.form.submit();}\">\n";
    else
        $str = "<select name=\"" . $name . "\" id=\"" . $name . "\" " . $selectAttribute . " >\n";

    if (Empty($defaultValue))
        $str = $str . "<option value=\"\">--请选择--</option>\n";
    if ($value != -1)
        $str = $str . "<option value=" . $value . ">" . $key . "</option>\n";
    //print_r( $GLOBAL['G_DB_OBJ'] );
    $row = $GLOBAL['G_DB_OBJ']->executeSqlMap($sql);
    //print_r( $sql  );
    //print_r( $row );
    while (current($row) !== false) //若未找到任何记录则返回
    {
        $tmpArr = current($row);
        if ($defaultValue == current($tmpArr))
            $str = $str . "<option value=\"" . current($tmpArr) . "\" selected>" . array_pop($tmpArr) . "</option>\n";
        else
            $str = $str . "<option value=\"" . current($tmpArr) . "\">" . array_pop($tmpArr) . "</option>\n";
        //$str=$str."<option value=\"".current( $tmpArr )."\" __".substr( $name, 0, strpos( $name, "_" ) ).current( $tmpArr )."SELECTED__>".array_pop( $tmpArr )."</option>\n";
        next($row);
    }

    $str = $str . "</select>\n";
    return $str;
}

function getComboxFromArray_v1($name, $mapData, $defaultValue = "", $onChange = false, $key = "", $value = -1, $selectAttribute = "")
{
    global $GLOBAL;
    if ($onChange)
        $str = "<select name=\"" . $name . "\" id=\"" . $name . "\" " . $selectAttribute . " onChange=\"javascript:this.form.action='__FORMACTION__';if ( options[selectedIndex].value != '0' ) { this.form.submit();}\">\n";
    else
        $str = "<select name=\"" . $name . "\" id=\"" . $name . "\" " . $selectAttribute . " >\n";

    if (Empty($defaultValue))
        $str = $str . "<option value=\"\">-请选择-</option>\n";
    if ($value != -1)
        $str = $str . "<option value=" . $value . ">" . $key . "</option>\n";
    //print_r( $GLOBAL['G_DB_OBJ'] );
    //print_r( $sql  );
    //print_r( $row );
    while (current($mapData) !== false) //若未找到任何记录则返回
    {
        if ($defaultValue == current($mapData))
            $str = $str . "<option value=\"" . key($mapData) . "\" selected>" . current($mapData) . "</option>\n";
        else
            $str = $str . "<option value=\"" . key($mapData) . "\">" . current($mapData) . "</option>\n";
        //$str=$str."<option value=\"".current( $tmpArr )."\" __".substr( $name, 0, strpos( $name, "_" ) ).current( $tmpArr )."SELECTED__>".array_pop( $tmpArr )."</option>\n";
        next($mapData);
    }

    $str = $str . "</select>\n";
    return $str;
}

function getComboxFromArray($name, $mapData, $defaultValue = "", $onChange = false, $key = "", $value = -1, $selectAttribute = "")
{
    global $GLOBAL;
    if ($onChange)
        $str = "<select name=\"" . $name . "\" " . $selectAttribute . " onChange=\"javascript:this.form.action='__FORMACTION__';if ( options[selectedIndex].value != '0' ) { this.form.submit();}\">\n";
    else
        $str = "<select name=\"" . $name . "\" " . $selectAttribute . " >\n";

    if (Empty($defaultValue))
        $str = $str . "<option value=\"0\">-请选择-</option>\n";
    if ($value != -1)
        $str = $str . "<option value=" . $value . ">" . $key . "</option>\n";
    //print_r( $GLOBAL['G_DB_OBJ'] );
    $row = $mapData;
    //print_r( $sql  );
    //print_r( $row );
    while (current($row) !== false) //若未找到任何记录则返回
    {
        $tmpArr = current($row);
        if ($defaultValue == current($tmpArr))
            $str = $str . "<option value=\"" . current($tmpArr) . "\" selected>" . array_pop($tmpArr) . "</option>\n";
        else
            $str = $str . "<option value=\"" . current($tmpArr) . "\">" . array_pop($tmpArr) . "</option>\n";
        //$str=$str."<option value=\"".current( $tmpArr )."\" __".substr( $name, 0, strpos( $name, "_" ) ).current( $tmpArr )."SELECTED__>".array_pop( $tmpArr )."</option>\n";
        next($row);
    }

    $str = $str . "</select>\n";
    return $str;
}

//select id, name, status from cubeandperson where cubeid=18
function getCheckBoxBySql($name, $sql, $clickScript = "")
{
    global $GLOBAL;

    $row = $GLOBAL['G_DB_OBJ']->executeSqlMap($sql);
    //print_r( $sql  );
    //print_r( $row );
    while (current($row) !== false) //若未找到任何记录则返回
    {
        $tmpArr = current($row);
        $value = current($tmpArr);
        $item = next($tmpArr);
        $str = $str . "<input type=checkbox name=\"" . $name . "\" tmpValue=\"" . $item . "\" value=\"" . $value . "\" " . $clickScript . ">" . $item . "\n";
        //$str=$str."<option value=\"".current( $tmpArr )."\" __".substr( $name, 0, strpos( $name, "_" ) ).current( $tmpArr )."SELECTED__>".array_pop( $tmpArr )."</option>\n";
        next($row);
    }
    return $str;
}

/*	*/

function getInfluenceArray($name, $sql)
{
    global $GLOBAL;
    $str = "<select name=\"" . $name . "\">\n";
    $str = $str . "<option value=\"\">-请选择-</option>\n";
    $row = $GLOBAL['G_DB_OBJ']->executeSqlMap($sql);
    while (current($row) !== false) //若未找到任何记录则返回
    {
        $tmpArr = current($row);
        $str = $str . "<option value=\"" . current($tmpArr) . "\" __" . substr($name, 0, strpos($name, "_")) . current($tmpArr) . "SELECTED__>" . array_pop($tmpArr) . "</option>\n";
    }

    $str = $str . "</select>\n";
    return $str;
}

function getWebCheckboxScript()
{
    $str = "<script language=javascript>\n";
    $str = $str . "function chk_box(theBox)\n";
    $str = $str . "{\n";
    $str = $str . "var tmp1 = theBox.name.substr( 0, theBox.name.length - 1 )+'1';\n";
    $str = $str . "var tmp2 = theBox.form[tmp1];\n";
    $str = $str . "\tif ( theBox.value == 0 )\n";
    $str = $str . "{\t\ttheBox.value = 1;\n";
    $str = $str . "\t\ttmp2.value = 1;\n}";
    $str = $str . "\telse\n";
    $str = $str . "{\t\ttheBox.value = 0;\n";
    $str = $str . "\t\ttmp2.value = 0;\n}";
    $str = $str . "}\n";
    $str = $str . "</script>\n";

    return $str;
}

function getPageScript()
{

    $str = "<script language=javascript>\nvar del_prompt=\"您确定要删除记录吗？\";\n";
    $str = $str . "var aud_prompt=\"您确定要审核记录吗？\";\n";
    $str = $str . "var only_selected_one=\"您必须选择一条进行编辑\";\n";
    $str = $str . "var delall_prompt=\"您确定要删除全部记录吗？\";\n";
    $str = $str . "var sub_prompt=\"您确定提交吗？\";\n";
    $str = $str . "var save_prompt=\"您确定保存吗？\";\n";
    $str = $str . "var up_prompt=\"您确定修改吗？\";\n";
    $str = $str . "var sub_dig=\"对不起，请输入整数！\";\n";
    $str = $str . "var sub_err=\"对不起，此项不能为空！\";\n";
    $str = $str . "var sub_nobody=\"您没有选择任何记录！\";\n";
    $str = $str . "var prompt =\"对不起，您输入的页码超过了最大页码！\";\n";
    $str = $str . "var prompt1 =\"对不起，您输入的页码超过了最小页码！\";\n";
    $str = $str . "var permit=\"您没有该菜单的权限！\";\n";

    $str = $str . "\tfunction checkform(form_prompt)\n";
    $str = $str . "{\n";
    $str = $str . "var y=confirm(form_prompt);\n";
    $str = $str . "if(y)\n";
    $str = $str . "\treturn true;\n";
    $str = $str . "else\n";
    $str = $str . "return false;\n";
    $str = $str . "}\n";
    $str = $str . "function checkchose()\n";
    $str = $str . "{\n";
    $str = $str . "var chosed=0; \n";
    $str = $str . "with(document.all.tags(\"INPUT\"))\n";
    $str = $str . "{\n";
    $str = $str . "for(i=0;i<length;i++)\n";
    $str = $str . "{\n";
    $str = $str . "if(item(i).checked==true&&item(i).type=='checkbox')\n";
    $str = $str . "chosed++;\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "if(chosed==0)\n";
    $str = $str . "{\n";
    $str = $str . "alert(sub_nobody);\n";
    $str = $str . "return false;\n";
    $str = $str . "}\n";
    $str = $str . "else\n";
    $str = $str . "return true;\n";
    $str = $str . "}\n";

    $str = $str . "function chk_box_status(cnt)\n";
    $str = $str . "{\n";
    $str = $str . "var chosed=0; \n";
    $str = $str . "with(document.all.tags(\"INPUT\"))\n";
    $str = $str . "{\n";
    $str = $str . "for(i=0;i<length;i++)\n";
    $str = $str . "{\n";
    $str = $str . "if(item(i).checked==true&&item(i).type=='checkbox')\n";
    $str = $str . "chosed++;\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "if(chosed!=1&&cnt!=1)\n";
    $str = $str . "{\n";
    $str = $str . "alert(only_selected_one);\n";
    $str = $str . "return false;\n";
    $str = $str . "}\n";
    $str = $str . "else\n";
    $str = $str . "return true;\n";
    $str = $str . "}\n";


    $str = $str . "function get_menu_id(obj)\n";
    $str = $str . "{\nvar theForm = obj.form;\n";
    $str = $str . "return theForm.menuID.value;\n";
    $str = $str . "}\n";

    $str = $str . "function get_chk_box_value( )\n";
    $str = $str . "{\n";
    $str = $str . "var chosed=0; \n";
    $str = $str . "with(document.all.tags(\"INPUT\"))\n";
    $str = $str . "{\n";
    $str = $str . "for(i=0;i<length;i++)\n";
    $str = $str . "{\n";
    $str = $str . "if(item(i).checked==true&&item(i).type=='checkbox')\n";
    $str = $str . "{chosed++;\n";
    $str = $str . "return item(i).value;\n}\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "if(chosed==0)\n";
    $str = $str . "{\n";
    $str = $str . "return 0;\n";
    $str = $str . "}\n";

    $str = $str . "}\n";

    $str = $str . "function allchose()\n";
    $str = $str . "{\n";
    $str = $str . "for(i=0;i<document.forms.length;i++)\n";
    $str = $str . "{\n";
    $str = $str . "for(j=0;j<document.forms[i].elements.length;++j)\n";
    $str = $str . "{if(document.forms[i].elements[j].disabled==false)\n";
    $str = $str . "if(document.forms[i].elements[j].type==\"checkbox\")\n";
    $str = $str . "document.forms[i].elements[j].checked=true;\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "}\n";

    $str = $str . "function antichose()//反选\n";
    $str = $str . "{\n";
    $str = $str . "for(i=0;i<document.forms.length;i++)\n";
    $str = $str . "{\n";
    $str = $str . "for(j=0;j<document.forms[i].elements.length;++j)\n";
    $str = $str . "{\n";
    $str = $str . "if(document.forms[i].elements[j].type==\"checkbox\")\n";
    $str = $str . "{if(document.forms[i].elements[j].disabled==false){\n";
    $str = $str . "if(document.forms[i].elements[j].checked==true)\n";
    $str = $str . "document.forms[i].elements[j].checked=false;\n";
    $str = $str . "else\n";
    $str = $str . "document.forms[i].elements[j].checked=true;\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "}\n";
    $str = $str . "</script>\n";
    return $str;
}

function getDateTimeCombox($year1 = '', $month1 = '', $day1 = '')
{

    $tmp = array(
        '__YEAR__' => array(),
        '__MONTH__' => array(),
        '__DAY__' => array()
    );
    $year = intval(date("Y"));
    $month = intval(date("m"));
    $day = intval(date("d"));
    $tmp['__YEAR__'] = "<select name=year><option value=0>请选择</option>";
    for ($i = 2008; $i <= $year; $i++)
        if ($i === $year1)
            $tmp['__YEAR__'] = $tmp['__YEAR__'] . "<option value=" . $i . " selected>" . $i . "</option>";
        else
            $tmp['__YEAR__'] = $tmp['__YEAR__'] . "<option value=" . $i . ">" . $i . "</option>";

    $tmp['__YEAR__'] = $tmp['__YEAR__'] . "</select>";

    $tmp['__MONTH__'] = "<select name=month><option value=0>请选择</option>";
    for ($i = 1; $i <= 12; $i++)
        if ($i === $month1)
            $tmp['__MONTH__'] = $tmp['__MONTH__'] . "<option value=" . $i . " selected>" . $i . "</option>";
        else
            $tmp['__MONTH__'] = $tmp['__MONTH__'] . "<option value=" . $i . ">" . $i . "</option>";
    $tmp['__MONTH__'] = $tmp['__MONTH__'] . "</select>";

    $tmp['__DAY__'] = "<select name=day><option value=0>请选择</option>";

    for ($i = 1; $i <= 31; $i++)
        if ($i === $day1)
            $tmp['__DAY__'] = $tmp['__DAY__'] . "<option value=" . $i . " selected>" . $i . "</option>";
        else
            $tmp['__DAY__'] = $tmp['__DAY__'] . "<option value=" . $i . ">" . $i . "</option>";

    $tmp['__DAY__'] = $tmp['__DAY__'] . "</select>";
    return $tmp;

}

?>