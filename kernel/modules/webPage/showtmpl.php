<?php
define('ABS_CUR_DIR_WEBPAGE', dirname(__FILE__) . '/');
require_once(ABS_CUR_DIR_WEBPAGE . 'conf/conf.php');
require_once(ABS_CUR_DIR_WEBPAGE . '../../function/mergeConf.php');
mergeConf($GLOBAL, $appConf);

$htmlCode = false;
if ($htmlCode !== false) //取缓存里的数据，若不存在则取数据库数据
{
    echo $htmlCode;
}
else
{
    $webPage = new formCheck();

    if (!Empty($GLOBAL['modulesInfo']['userKey'])) {
        if (!isset($mapData)) {
            $pageHtml = new pageList(0, 0, '');
            $mapData = $pageHtml->getMapData();
        }

        if (!isset($GLOBAL['modulesInfo']['pageListType']['type']))
            $GLOBAL['modulesInfo']['pageListType']['type'] = 'pagelist';

        if ($GLOBAL['modulesInfo']['pageListType']['type'] === 'photo') {
            $webPage->initRegexDataArray(array(0 => $mapData, 1 => '/(<!--imgmapdata-->)([\s\S]*?)(<!--imgmapdata-->)/i'));
        }
        else
        {
            $webPage->initRegexDataArray(array(0 => $mapData, 1 => '/(<!--mapdata-->)([\s\S]*?)(<!--mapdata-->)/i'));
        }

        if (isset($debug)) {
            print_r($pageHtml->getTableSql());
            print_r($mapData);
            print_r($GLOBAL);
        }

        $GLOBAL['htmlDefine']['replaceArray']['__BUTTOMSTR__'] = $pageHtml->getTableButtom();
        $GLOBAL['htmlDefine']['replaceArray']['__JAVASCRIPT__'] = getPageScript();

    }
    $htmlBody = $webPage->getHtmlCode();
    echo $htmlBody;

//    $xhprof_data = xhprof_disable();

 //   $XHPROF_ROOT = "/usr/local/starsoftcomm/php/share/pear/";
  //  include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
   // include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

    //if (isset($module) && isset($app)) {
     //   $xhprof_runs = new XHProfRuns_Default();
      //  $run_id = $xhprof_runs->save_run($xhprof_data, $module . "_" . $app . ".html");
       // echo "http://" . $_SERVER['SERVER_NAME'] . "/xhprof/xhprof_html/index.php?run={$run_id}&source=" . $module . "_" . $app . ".html";
    //}
}
?>
