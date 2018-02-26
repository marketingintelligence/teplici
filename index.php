<?php
error_reporting(E_NONE);
ini_set('display_errors',0);

$adress = $_SERVER["HTTP_HOST"];
$link = $_SERVER["REQUEST_URI"];


if (strstr($_SERVER["REQUEST_URI"],"'")){
    $request_uri = str_replace("'","",$_SERVER["REQUEST_URI"]);
    //header("Location: http://".$_SERVER["HTTP_HOST"].$request_uri."");
}
else {
    header ('Content-type: text/html; charset=utf-8');
    $yii = dirname(__FILE__) . '/protected/yiiframework/YiiBase.php';
    $config = dirname(__FILE__) . '/protected/config/main.php';

    require_once ($yii);
    class Yii extends YiiBase {
        public static function app() {        
            return parent::app();
        }
    }
    Yii::createWebApplication($config)->run();
}



?>