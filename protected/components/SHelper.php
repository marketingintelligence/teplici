<?php

class SHelper {
    static function getLan($name) {
        $lang = Yii::app()->user->getState("lang");
        if ( $lang == "" ) {
            include('languages/ru.php');
        }elseif ( $lang == "eng" ) {
            include('languages/eng.php');
        }
        echo $arraylang[$name];
    }
}
