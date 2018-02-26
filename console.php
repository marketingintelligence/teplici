<?php


$yii = dirname(__FILE__) . '/protected/framework1.10/YiiBase.php';
$config = dirname(__FILE__) . '/protected/config/console.php';

require_once($yii);

require_once($ru);

class Yii extends YiiBase {
    /**
     * @static
     * @return CWebApplication
     */
    public static function app() {
        return parent::app();
    }
}


Yii::createConsoleApplication($config)->run();


