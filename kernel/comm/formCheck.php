<?php
/*
 * 作者：孙全军	email:sqj0213@163.com mobile:13910212452
 */
define('ABS_CUR_FORMCHECK_DIR_INC', dirname(__FILE__) . '/');
require_once (ABS_CUR_FORMCHECK_DIR_INC . '../baselib/baseClass.php');
require_once (ABS_CUR_FORMCHECK_DIR_INC . '../function/webOptCode.php');
class formCheck
{
    protected $checkScriptTypeArray = array("textboxen" => TEXTBOXEN,
        "textarea" => TEXTAREA,
        "telephone" => TELEPHONE,
        "checkCode" => CHECKCODE,
        "email" => EMAIL,
        "birthday" => BIRTHDAY,
        "postcode" => POSTCODE,
        "integer" => NUMBER,
        "datetime" => DATETIME,
        "integersplit" => NUMBERSPLIT,
        "negative" => NEGATIVE,
        "mobile" => MOBILE,
        "float" => FLOAT,
        "gainrate" => GAINRATE,
        "phone" => PHONE,
        "url" => URL,
        "checkbox" => CHECKBOX
    );
    private $regexData = array();
    private $regex = array();
    private $srcHtml = ''; //tmpl源码
    private $formArr = array(); //初始化表单数组
    private $filterFormArr = array(); //初始化表单数组
    private $formUnit = array(); //过滤后的标准结构数组，用于生成script脚本
    private $scriptString = '';
    private $desHtml = '';

    function __construct($arg = "", $REP_TMP = array())
    {
        global $GLOBAL;
        if (Empty($arg))
            $arg = $GLOBAL['htmlDefine']['tmplPath'];
        //echo $arg;
        if (Empty($REP_TMP))
            ;
        // $REP_TMP = $GLOBAL['htmlDefine']['replaceArray'];
        if (is_null($arg))
            throw new Exception('构造函数输入内容不能为空');
        if (is_file($arg))
            $this->srcHtml = file_get_contents($arg);
        else
        {
            $this->srcHtml = $arg;
            throw new Exception('file is not exist,info:' . $arg);
        }
        $out = array();
        //预先处理自定义的脚本与html代码的替换
        $arr_len = count($REP_TMP);
        if ($arr_len === 0) //若未传入参数则填加默认的return true函数
        {
            //echo "----------------------------------";
            //出于性能考虑需要注释掉此部分,自定义的js部分由程序员自己在模板里填加
            //2011-12-8去除
            /*
               $tmpstr = getDefaultJavascript();
               $this->srcHtml = str_ireplace("<body ", $tmpstr . "<body ", $this->srcHtml);
               $this->srcHtml = str_ireplace("< body ", $tmpstr . "<body ", $this->srcHtml);
               $this->srcHtml = str_ireplace("<body>", $tmpstr . "<body>", $this->srcHtml);
               */
            ;
        }
        else
            for ($i = 0; $i < $arr_len; $i++)
            {
                if (strrpos(key($REP_TMP), "__"))
                    $this->srcHtml = str_ireplace(key($REP_TMP), $REP_TMP[key($REP_TMP)], $this->srcHtml);
                next($REP_TMP);
            }
        preg_match_all(FORM_REG, $this->srcHtml, $out); //取得表单与表单里的元素
        //print_r($out[0] );
        //exit;

        $this->formArr = $out[0];
        global $GLOBAL;
        if ($GLOBAL['debugFlag'] == "on")
            echo "__construct,f=" . __FILE__ . ",l=" . __LINE__ . "<br>";
    }

    function __destruct()
    {
        global $GLOBAL;
        if ($GLOBAL['debugFlag'] == "on")
            echo "__destruct,f=" . __FILE__ . ",l=" . __LINE__ . "<br>";
        $this->srcHtml = '';
        $this->formArr = array();
        $this->filterFormArr = array();
        $this->formUnit = array();
        $this->scriptString = '';
        $this->desHtml = '';
    }

    public function replaceSrcCode($srcCode, $desCode)
    {
        $this->srcHtml = str_ireplace($srcCode, $desCode, $this->srcHtml);
        preg_match_all(FORM_REG, $this->srcHtml, $out); //取得表单与表单里的元素
        $this->formArr = array();
        $this->formArr = $out[0];
    }

    public function replaceMapDataByRegex(&$html_body, $repArr1 = array(), $regSign1 = array())
    {
        global $GLOBAL;
        if (Empty($repArr1) || Empty($regSign1))
            return $html_body;
        //echo "l=".__LINE__."<br>";
        while (current($regSign1) !== false)
        {
            //echo "l=".__LINE__."<br>";
            $repArr = current($repArr1);
            $regSign = current($regSign1);
            if (strstr($regSign, 'imgmapdata') !== false) {
                $cols = isset($GLOBAL['modulesInfo']['pageListType']['colsNum']) ? $GLOBAL['modulesInfo']['pageListType']['colsNum'] : 3;
                $this->getImageTableStr($html_body, $repArr, $regSign, $cols);
            }
            else
            {
                preg_match($regSign, $html_body, $nodeStr);
                $mapStr = "";
				$i = 0;//奇偶数显示不同颜色列
                if (is_array($repArr))
                    while (current($repArr) !== false)
                    {
                        $tmp = current($repArr);
                        $tmpStr = isset($nodeStr[2]) ? $nodeStr[2] : '';
                        $id = $tmp['__ID__'];
						if ( $i % 2 === 0 )
                            $tmpStr = str_replace("<tr>", "<tr bgcolor=#f5f5f5 height=25>", $tmpStr);
						else
                            $tmpStr = str_replace("<tr>", "<tr bgcolor=#f8f8f8 height=25>", $tmpStr);
						$i++;
                        while (current($tmp) !== false)
                        {
                            //$tmplSign = explode( '_', key( $tmp ) );
                            //$tmpStr = str_replace(  key( $tmp ), current( $tmp ), $tmpStr  );
                            if (isset($GLOBAL['modulesInfo']['primaryLink']['field']))
                                if (key($tmp) == $GLOBAL['modulesInfo']['primaryLink']['field']) {
                                    $tmpStr = str_replace('__URL__', $GLOBAL['modulesInfo']['primaryLink']['url'], $tmpStr);
                                    $tmpStr = str_replace('__ID__', $id, $tmpStr);
                                }
                            $tmpStr = str_replace(key($tmp), current($tmp), $tmpStr);


                            next($tmp);
                        }
                        $mapStr .= $tmpStr;
                        next($repArr);
                    }
                $html_body = preg_replace($regSign, $mapStr, $html_body);
            }
            next($repArr1);
            next($regSign1);
        }
    }

    private function replaceHtmlByMap($htmlBody, $map)
    {
        $arrLen = count($map);
        if (is_array($map)) {

            while (current($map) !== false)
            {
                if (strrpos(key($map), "__"))
                    $htmlBody = str_ireplace(key($map), current($map), $htmlBody);
                next($map);
            }

            reset($map);
        }
        return $htmlBody;
    }

    public function initRegexDataArray($para = array())
    {
        $tmpLen = count($this->regexData);
        $this->regexData[$tmpLen] = $para[0];
        $this->regex[$tmpLen] = $para[1];
    }

    public function getHtmlCode($formAction = '', $REP_TMP = array())
    {
        global $GLOBAL;
        if (Empty($formAction))
            $formAction = $GLOBAL['modulesInfo']['formAction'];
        if (isset($GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'])) {
            if (file_exists($GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__']))
                $GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'] = file_get_contents($GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__']);
            //print_r(  $GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'] );
            //print_r( $GLOBAL['htmlDefine']['replaceArray']['__HEADERFILE__'] );
            //echo "l=".__LINE__."<br>";
        }
        if (isset($GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__'])) {
            if (file_exists($GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__']))
                $GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__'] = file_get_contents($GLOBAL['htmlDefine']['replaceArray']['__FOOTERFILE__']);
        }
        //print_r( $formAction );
        //print_r( $GLOBAL[ 'modulesInfo' ] );
        //exit;
        if (Empty($REP_TMP) && isset($GLOBAL['modulesInfo']['comboxDefaultSelected'])) {
            $REP_TMP = $GLOBAL['modulesInfo']['comboxDefaultSelected'];
        }
        //print_r( $formAction );
        $this->getFieldKeyValue();
        $this->splitFormUnit();
        //print_r( $this->formUnit );
        $this->buildScript();
        $tmpStr = '<input type=hidden name=' . FORM_NAME . '><input type=hidden name=' . UPD_ID_NAME . ' value="__ID__">';
        if (isset($GLOBAL['modulesInfo']['unionField']))
            $tmpStr .= '<input type=hidden name=' . UNION_FIELD . ' value="' . $GLOBAL['modulesInfo']['unionField'] . '"><input type=hidden name=' . MENU_ID . ' value="' . $GLOBAL['runData']['menuID'] . '"></form';
        else
            $tmpStr .= '<input type=hidden name=' . MENU_ID . ' value="' . $GLOBAL['runData']['menuID'] . '"></form';
        if (!Empty($tmpStr)) {
            $this->desHtml = str_ireplace("</form", $tmpStr, $this->srcHtml); //设置表单名称的变量便于后端处理
            $this->desHtml = str_ireplace("</ form", $tmpStr, $this->desHtml); //设置表单名称的变量便于后端处理
        }
        else
            $this->desHtml = $this->srcHtml;
        $this->desHtml = $this->replaceHtmlByMap($this->desHtml, $GLOBAL['htmlDefine']['replaceArray']);

        if (!Empty($this->scriptString)) {
            $this->desHtml = str_ireplace("<body ", $this->scriptString . "<body ", $this->desHtml);
            $this->desHtml = str_ireplace("< body ", $this->scriptString . "<body ", $this->desHtml);
            $this->desHtml = str_ireplace("<body>", $this->scriptString . "<body>", $this->desHtml);
        }
        //print_r( $formAction );
        if (!Empty($formAction)) {
            $this->desHtml = str_ireplace("__FORMACTION__", $formAction, $this->desHtml);
            $this->desHtml = str_ireplace("__CHECKBOXONCLICK__", " onclick=\"javascript:chk_box(this);\"", $this->desHtml);
        }
        if (!Empty($REP_TMP))
            while (current($REP_TMP) !== false)
            { //负责替换下拉列表框里的选中项
                $this->desHtml = str_ireplace("__" . key($REP_TMP) . $REP_TMP[key($REP_TMP)] . "SELECTED__", "selected", $this->desHtml);
                $this->desHtml = preg_replace("/__" . key($REP_TMP) . "(\w+)*SELECTED__/", "", $this->desHtml);

                next($REP_TMP);
            }


        if (!Empty($this->regexData) && !Empty($this->regex)) {
            //echo "l=".__LINE__."<br>";
            $this->replaceMapDataByRegex($this->desHtml, $this->regexData, $this->regex);
        }
        return $this->desHtml;
    }

    private function getImageTableStr(&$htmlBody, $repArr = array(), $regSign = "(<!--imgmapdata-->)([\s\S]*?)(<!--imgmapdata-->)", $cols = 3)
    {
        $mapData = $repArr;
        $mapLen = count($mapData);
        $nodeStr = array();
        preg_match($regSign, $htmlBody, $nodeStr);

        $tmpStr = $nodeStr[2];
        $tdStrLenOld = strlen($tmpStr);
        $retStr = '';
        $tmpArray = $mapData[0]; //取得第二维数组的key
        for ($cursor = 0; $cursor < $mapLen; $cursor++)
        {
            for ($j = 0; $j < $cols; $j++)
            {
                $tdStr = $tmpStr;
                if (isset($mapData[$cursor])) {
                    $rowData = $mapData[$cursor];

                    while (current($rowData) !== false)
                    {
                        $tdStr = str_ireplace(key($rowData), current($rowData), $tdStr);
                        next($rowData);
                    }

                }

                if ($cursor >= $mapLen) {
                    while (current($tmpArray) !== false)
                    {
                        $tdStr = preg_replace('/<td>([\s\S]*?)<\/td>/', '<td></td>', $tdStr);
                        next($tmpArray);
                    }
                    reset($tmpArray);
                }
                else
                {
                    //若为最后一列,则cursor不加1
                    if ($j !== ($cols - 1))
                        $cursor++;
                }
                //如果没有了数据,把模板里的表单变量清空
                if ($tdStrLenOld === strlen($tdStr))
                    $retStr = $retStr . "<td></td>";
                else
                    $retStr = $retStr . $tdStr;
            }

            if ($cursor < $mapLen - 1)
                $retStr = $retStr . "</tr><tr>";
        }

        $htmlBody = preg_replace($regSign, $retStr, $htmlBody);
    }

    public function replaceArray($REP_TMP = array())
    {
        while (current($REP_TMP))
        {
            $arr_len = count($REP_TMP);
            for ($i = 0; $i < $arr_len; $i++)
            {
                $this->srcHtml = str_ireplace(key($REP_TMP), $REP_TMP[key($REP_TMP)], $this->srcHtml);
                next($REP_TMP);
            }
        }
        return $tmplStr;
    }

    private function getFieldKeyValue()
    {
        $form = $this->formArr;
        $array_len = count($form);
        for ($i = 0; $i < $array_len; $i++)
        {
            preg_match(FIELD_KEY_VALUE, $form[$i], $out1); //取得表单里所有元素的键与值
            if ($i == 0) {
                $form[$i] = str_replace(' ', '', $form[$i]);
                $form[$i] = str_replace('\t', '', $form[$i]);
                $form[count($form)] = substr($form[$i], strpos($form[$i], "return") + 6, strpos($form[$i], "(") - strpos($form[$i], "return") - 6); //取得form校验的javascript函数名
            }
            if (is_array($out1) && !Empty($out1)) {
                $form[$i] = substr($out1[0], strpos($out1[0], '=') + 1);
            }
            $form[$i] = str_replace('"', '', $form[$i]);
            $form[$i] = str_replace(' ', '', $form[$i]);
            $form[$i] = str_replace('\t', '', $form[$i]);
        }

        $this->filterFormArr = $form;
    }

    private function splitFormUnit()
    {
        $form = $this->filterFormArr;
        $j = 0;
        for ($i = 0; $i < count($form); $i++)
        {
            if (strpos($form[$i], TMPL_FORM_PRE) !== false) {

                if (isset($this->formUnit["form"]["formname"])) //若为多个表单的话
                {
                    if (is_array($this->formUnit["form"]["formname"])) {
                        $this->formUnit["form"]["formname"][count($this->formUnit["form"]["formname"])] = $form[$i];
                        $this->formUnit["form"]["split"][count($this->formUnit["form"]["split"])] = explode("_", $form[$i]);
                    }
                    else
                    {
                        $tmp = $this->formUnit["form"]["formname"];
                        $this->formUnit["form"]["formname"] = array();
                        $this->formUnit["form"]["formname"][0] = $tmp;
                        $this->formUnit["form"]["formname"][1] = $form[$i];
                        $tmp = $this->formUnit["form"]["split"];
                        $this->formUnit["form"]["split"] = array();
                        $this->formUnit["form"]["split"][0] = $tmp;
                        $this->formUnit["form"]["split"][1] = explode("_", $form[$i]);
                    }
                }
                else
                {
                    $this->formUnit["form"]["formname"] = $form[$i];

                    $this->formUnit["form"]["split"] = explode("_", $form[$i]);
                }
                continue;
            }

            if (strpos($form[$i], FORM_SCRIPT_PRE) !== false) {
                $this->formUnit['form']["script"] = $form[$i];
                continue;
            }
            $this->formUnit["formunit"][$j]["fieldname"] = $form[$i];
            $this->formUnit["formunit"][$j]["split"] = (explode("_", $form[$i]));

            if (isset($this->formUnit["unitcount"]))
                $this->formUnit["unitcount"] = $this->formUnit["unitcount"] + 1;
            else
                $this->formUnit["unitcount"] = 1;
            $j = $j + 1;
        }
    }

    function buildScript()
    {
        $formarr = $this->formUnit;

        $script_str = "";
        if (isset($formarr['form'])) {
            if ($formarr["form"] === 0)
                return '';
        }
        else
            return '';
        if (isset($formarr['unitcount'])) {
            if ($formarr["unitcount"] === 0)
                return '';
        }
        else
            return '';

        $script_str = $script_str . "\n<script language=\"javascript\">\n";
        $script_str = $script_str . "<!--\n";
        if(isset($formarr["form"]["script"]))
            $script_str = $script_str . "function " . $formarr["form"]["script"] . "(fm)\n{\n";
        for ($i = 0; $i < $formarr["unitcount"]; $i++)
        {
            $script_str = $script_str . $this->getFieldScript($formarr["formunit"][$i]["fieldname"], $formarr["formunit"][$i]["split"]);
        }

        $script_str = $script_str . "\tfm." . FORM_NAME . ".value = fm.name;\n";
        $script_str = $script_str . "return true;\n";
        $script_str = $script_str . "}\n//-->\n";
        $script_str = $script_str . "</script>\n";
        $this->scriptString = getWebCheckboxScript() . $script_str;
    }

    function getFieldScript($fieldname, $fieldarr)
    {
        $script = "";
        if (isset($fieldarr[5]))
            if ($fieldarr[5] == 1) {
                if (is_array($this->formUnit["form"]["formname"]))
                    $script = $script . "\tif ( fm." . $fieldname . " != undefined )\n";

                $script = $script . "\tif ( fm." . $fieldname . ".value == '' )\n";
                $script = $script . "\t{\n";
                $script = $script . "\t\talert('请输入" . $fieldarr[1] . "');\n";
                $script = $script . "\t\tif (fm." . $fieldname . ".type !='hidden')\n";
                $script = $script . "\t\tfm." . $fieldname . ".focus();\n";
                $script = $script . "\t\treturn false;\n\t}\n";

                if (is_array($this->formUnit["form"]["formname"]))
                    $script = $script . "\tif ( fm." . $fieldname . " != undefined )\n";
                $script = $script . "\tif ( ( fm." . $fieldname . ".value.length  < " . $fieldarr[3]
                        . " )||( fm." . $fieldname . ".value.length >" . $fieldarr[4] . " ) )\n";
                $script = $script . "\t{\n";
                $script = $script . "\t\talert('" . $fieldarr[1] . "长度必须为" . $fieldarr[3] . "-" . $fieldarr[4] . "之间!');\n";
                $script = $script . "\t\tif ( fm." . $fieldname . ".type != 'hidden' )\n\t{\n";

                $script = $script . "\t\tfm." . $fieldname . ".focus();\n";
                $script = $script . "\t\tfm." . $fieldname . ".select();\n\t}\n";
                $script = $script . "\t\treturn false;\n\t}\n";
                if (isset($this->checkScriptTypeArray[$fieldarr[2]])) //如果检查表达式已经定义，则进行检查
                {
                    if ($this->checkScriptTypeArray[$fieldarr[2]] === TEXTBOXEN)
                        $reg_script = str_replace(PHP_CH_REG, JS_CH_REG, $this->checkScriptTypeArray[$fieldarr[2]]);
                    else
                        $reg_script = $this->checkScriptTypeArray[$fieldarr[2]];
                    $script = $script . "\tvar myReg =" . $reg_script . ";\n";
                    if (is_array($this->formUnit["form"]["formname"]))
                        $script = $script . "\tif ( fm." . $fieldname . " != undefined )\n";

                    $script = $script . "\tvar myStr = fm." . $fieldname . ".value;\n";
                    if (is_array($this->formUnit["form"]["formname"]))
                        $script = $script . "\tif ( fm." . $fieldname . " != undefined )\n";

                    $script = $script . "\tif ( myReg.test( myStr ) != true )\n\t{\n";
                    $script = $script . "\t\talert('" . $fieldarr[1] . "含有非法字符请检查，请检查!');\n";

                    $script = $script . "\t\tif ( fm." . $fieldname . ".type != 'hidden' )\n\t{\n";
                    $script = $script . "\t\tfm." . $fieldname . ".focus();\n";
                    $script = $script . "\t\tfm." . $fieldname . ".select();\n\t}\n";
                    $script = $script . "\t\treturn false;\n";
                    $script = $script . "\t}\n";
                }
            }
        return $script;
    }
}
?>