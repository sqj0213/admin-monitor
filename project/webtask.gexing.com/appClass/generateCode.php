<?php
define('ABS_CLASS_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CLASS_LOGIN_DIR . '../../../kernel/comm/openSource/snoopy/Snoopy.class.php');
require_once(ABS_CLASS_LOGIN_DIR . '../../../kernel/inc/global.php');
/**
 * Created by JetBrains PhpStorm.
 * User: Zhenqiang.du
 * Date: 11-12-6
 * Time: 上午11:20
 */

class generateCode extends DBBaseClass
{

    function __contruct()
    {
        global $GLOBAL;

        parent::__construct();
        $this->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);
    }

    function randomKeys($length, $spacer = "")
    {
        $key = "";
        $str = '0123456789ABCDEFGHJKLMNPQRTUVWXYZ'; //字符池
        for ($i = 0; $i < $length; $i++) {
            $randNum = floor(mt_rand(0, 32));
            $key = $key . $str{$randNum}; //生成php随机数

            if ($spacer != "") {
                if (($i > 0) && ($i != ($length - 1)) && ($i % 4 == 3))
                    $key = $key . "-";
            }
        }
        return $key;
    }

    //生成随机数标签码
    function randomNums($prefix, $length)
    {
        global $appConf;

        $key = "";
        $str = '012345678901234567890123456789'; //字符池

        $length = intval($length) - 3;
        for ($i = 0; $i < $length; $i++) {
            $randNum = floor(mt_rand(0, 29));
            $key = $key . $str{$randNum}; //生成php随机数

        }

        //生成一位校验码
        $letterArray = explode(",", $appConf["Code"]["LetterStr"]);
        $checkLetter = $letterArray[(intval($prefix) + intval($key)) % 24];

        $key = str_pad($prefix, 2, '0', STR_PAD_LEFT) . $checkLetter . $key;

        return $key;
    }

    /**
     * 生成标签码
     * @param $nums 生成个数
     * @return void
     */
    function createTagCodes($beginSerialNum, $tagName, $tagType)
    {
        global $GLOBAL;

        $GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);

        $createNum = $_REQUEST['createNum'];
        $oem = $_REQUEST['oem'];
        $batchId = $_REQUEST['batchId'];
        $tagFlag = $_REQUEST['tagFlag'];
        $tagTime = $_REQUEST['tagTime'];
        $expireTime = $_REQUEST['expireTime'];
        $codeLength = $_REQUEST['codeLength'];
        $physicalType = $_REQUEST['physicalType'];

        $sqlStr = $this->getSQLStr($oem, $batchId, $tagName, $tagType, $tagFlag, $tagTime, $expireTime, $physicalType);

        for ($i = 0; $i < $createNum; $i++) {
            $executeSql = $sqlStr;
            if ($tagName == 1) {
                $tagCode = $this->randomNums($oem, $codeLength);

                if ($tagType == 1) { //电子码
                    $tableName = "sales.salesElectronicTagCode";
                    $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where tagCode = '$tagCode' limit 1");

                    while (intval($codeId) > 0) {
                        $tagCode = $this->randomNums($oem, $codeLength);
                        $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where tagCode = '$tagCode' limit 1");
                    }
                } else if ($tagType == 2) { //实物码
                    $tableName = "sales.salesPhysicalCode";
                    $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where physicalCode = '$tagCode' limit 1");

                    while (intval($codeId) > 0) {
                        $tagCode = $this->randomNums($oem, $codeLength);
                        $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where physicalCode = '$tagCode' limit 1");
                    }
                }

                $executeSql .= "'$tagCode')";
            } else if ($tagName == 2) {
                $nowTime = time();
                $front = substr($beginSerialNum, 0, 3);
                $backend = substr($beginSerialNum, 3);
                $backend = intval($backend) + $i;
                $backend = str_pad($backend, 7, '0', STR_PAD_LEFT);
                $serialNum = $front . $backend;

                $tagCode = $this->randomKeys(16, '-');

                if ($tagType == 1) { //电子激活码
                    $tableName = "sales.salesElectronicActivitionCode";
                    $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where activitionCode = '$tagCode' limit 1");

                    while (intval($codeId) > 0) {
                        $tagCode = $this->randomNums($oem, $codeLength);
                        $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where activitionCode = '$tagCode' limit 1");
                    }
                } else if ($tagType == 2) { //实物激活码
                    $tableName = "sales.salesPhysicalActivitionCode";
                    $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where activitionCode = '$tagCode' limit 1");

                    while (intval($codeId) > 0) {
                        $tagCode = $this->randomNums($oem, $codeLength);
                        $codeId = $GLOBAL['G_DB_OBJ']->getFieldValue("select id from " . $tableName . " where activitionCode = '$tagCode' limit 1");
                    }
                }

                $executeSql .= "'$serialNum', '$tagCode', '$nowTime')";
            }
            $GLOBAL['G_DB_OBJ']->executeSql($executeSql);
        }
    }

    function updateBatch()
    {
        global $GLOBAL;

        $beginSerialNum = $_REQUEST['beginSerialNum'];
        $nums = $_REQUEST['nums'];
        $batchId = $_REQUEST['batchId'];
        $tagName = $_REQUEST['tagName'];
        $tagType = $_REQUEST['tagType'];
        $serialNum = intval($beginSerialNum) + $nums - 1;

        //如果是生成激活码，更新批次表中的起始序列号和结束序列号
        if ($tagName == 2) {
            $tableName = "";
            if ($tagType == 1) { //电子码
                $tableName = "salesElectronicActivitionBatch";
            } else if ($tagType == 2) { //实物码
                $tableName = "salesPhysicalActivitionBatch";
            }

            if ($tableName != "")
                $GLOBAL['G_DB_OBJ']->executeSql("update " . $tableName . " set beginSerial = '$beginSerialNum', endSerial = '$serialNum' where id = '$batchId'");
        }
    }

    function getSQLStr($oem, $batchId, $tagName, $tagType, $tagFlag, $tagTime, $expireTime, $physicalType)
    {
        $sqlStr = "";
        $fields = "";
        $values = "";
        $tableName = "";
        if ($tagName == 1) { //人工编码
            if ($tagType == 1) { //电子码
                $tableName = "sales.salesElectronicTagCode";
                $sqlStr = "insert into " . $tableName . "(oemId, batchId, tagCode) values ($oem, $batchId, ";
            } else if ($tagType == 2) { //实物码
                $tableName = "sales.salesPhysicalCode";
                $sqlStr = "insert into " . $tableName . "(oemId, batchId, physicalCodeType, physicalCode) values ($oem, $batchId, $physicalType, ";
            }
        } else if ($tagName == 2) { //激活码
            if ($tagType == 1) { //电子码
                $tableName = "sales.salesElectronicActivitionCode";
                $fields = "oemId, batchId, expireTime, timeLength, codeFlag, serialNumber, activitionCode, createTime";
                $values = "'$oem', '$batchId', '$tagTime', '$expireTime', $tagFlag,";
            } else if ($tagType == 2) { //实物码
                $tableName = "sales.salesPhysicalActivitionCode";
                $fields = "oemId, batchId, expireTime, timeLength, codeFlag, serialNumber, activitionCode, createTime";
                $values = "'$oem', '$batchId', '$tagTime', '$expireTime', $tagFlag,";
            }
            $sqlStr = "insert into " . $tableName . "(" . $fields . ") values (" . $values . " ";
        }

        return $sqlStr;
    }

    function createBatch()
    {
        global $GLOBAL;

        $oem = $_REQUEST['oem'];
        $batch = $_REQUEST['batch'];
        $note = $_REQUEST['note'];
        $tagName = intval($_REQUEST['tagName']);
        $tagType = intval($_REQUEST['tagType']);
        $nums = $_REQUEST['nums'];
        $nowTime = time();

        $tableName = "";
        if ($tagName == 1) { //人工编码
            if ($tagType == 1) { //电子码
                $tableName = "salesElectronicTagCodeBatch";
            } else if ($tagType == 2) { //实物码
                $tableName = "salesPhysicalBatch";
            }
        } else if ($tagName == 2) { //激活码
            if ($tagType == 1) { //电子码
                $tableName = "salesElectronicActivitionBatch";
            } else if ($tagType == 2) { //实物码
                $tableName = "salesPhysicalActivitionBatch";
            }
        }

        $batchId = 0;
        if ($tableName != "") {
            $GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);

            $GLOBAL['G_DB_OBJ']->executeSql("insert into " . $tableName . "(oemId, batch, note, createNum, createTime) values ('$oem', '$batch', '$note', '$nums', $nowTime)");
            $batchId = $GLOBAL['G_DB_OBJ']->executeSql("select max(id) as batchId from " . $tableName);
        }

        return $batchId["batchId"];
    }

    function checkBeginSerialNum($beginSerialNum, $tagName, $tagType)
    {
        global $GLOBAL;

        $GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['salesDBInfo']);

        $batchId = 0;
        $tableName = "";

        if ($tagName == 2) { //激活码
            if ($tagType == 1) { //电子码
                $tableName = "salesElectronicActivitionBatch";
            } else if ($tagType == 2) { //实物码
                $tableName = "salesPhysicalActivitionBatch";
            }
            $batchId = $GLOBAL['G_DB_OBJ']->executeSql("select id from " . $tableName . " where beginSerial = '$beginSerialNum'");
        }
        return $batchId["id"];
    }

    function __destruct()
    {
        parent::__destruct();
    }
}

?>