<?php

function create_sess_id($len = 32)
{
    if (!is_numeric($len) || ($len > 32) || ($len < 16)) {
        return;
    }
    list($u, $s) = eXPlode(' ', microtime());
    $time = (float)$u + (float)$s;
    $rand_num = rand(100000, 999999);
    $rand_num = rand($rand_num, $time);
    mt_srand($rand_num);
    $rand_num = mt_rand();
    $sess_id = md5(md5($time) . md5($rand_num));
    $sess_id = substr($sess_id, 0, $len);
    return $sess_id;
}


function create_check_code($len = 4)
{
    if (!is_numeric($len) || ($len > 6) || ($len < 1)) {
        return;
    }

    $check_code = substr(create_sess_id(), 16, $len);
    return strtoupper($check_code);
}


function create_check_image($length)
{
    session_start();

    $im = imagecreate(60, 25);
    $gray = ImageColorAllocate($im, 234, 234, 234);
    $black = ImageColorAllocate($im, 0, 0, 0);
    imagefill($im, 60, 25, $black);

    $key = "";
    $str = "012345678901234567890123456789"; //字符池
    for ($i = 0; $i < $length; $i++) {
        $randNum = floor(mt_rand(0, 29));
        $key = $key . $str[$randNum];
    }

    $_SESSION["checkCode"] = $key;

    imagestring($im, 5, 8, 3, $key, $black);
    for ($i = 0; $i < 200; $i++)
    {
        $randColor = ImageColorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
        imagesetpixel($im, rand() % 70, rand() % 30, $randColor);
    }
    Header("Content-type: image/PNG");
    ImagePNG($im);
    ImageDestroy($im);
}


//���мӼ�������֤��
function create_check_image_v1($v)
{
    session_start();
    $sessionvar = 'checkCode'; //Session�������
    $digit = 2;
    $width = intval($digit) * 50; //ͼ����
    $height = 26; //ͼ��߶�
    $result = 0;

    $operator = '+-*'; //�����

    $code = array();
    $code[] = mt_rand(1, 9);
    for ($i = 0; $i < ($digit - 1); $i++) {
        $code[] = $operator{mt_rand(0, 2)};
        $code[] = mt_rand(1, 9);
    }
    eval("\$result = " . implode('', $code) . ";");
    $code[] = '=';

    $_SESSION[$sessionvar] = $result;

    $img = ImageCreate($width, $height);
    ImageColorAllocate($img, mt_rand(230, 250), mt_rand(230, 250), mt_rand(230, 250));
    //$color = ImageColorAllocate($img, 0, 0, 0);

    $offset = 0;
    foreach ($code as $char) {
        $offset += 20;
        $txtcolor = ImageColorAllocate($img, mt_rand(0, 255), mt_rand(0, 150), mt_rand(0, 255));
        ImageChar($img, mt_rand(3, 5), $offset, mt_rand(1, 5), $char, $txtcolor);
    }

    for ($i = 0; $i < 100; $i++) {
        $pxcolor = ImageColorAllocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        ImageSetPixel($img, mt_rand(0, $width), mt_rand(0, $height), $pxcolor);
    }

    header('Content-type: image/png');
    ImagePng($img);
    ImageDestroy($img);
}

?>
