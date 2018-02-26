<?php
class NewsController extends Controller {
    public function actionIndex() {
        $this->pageTitle = "Теплицы";
       /* $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";
        $page = Pages::model()->findAll($criteria);*/

        $this->render('index' );
    }

    public function actionShow() {
        $this->pageTitle = "Теплицы";
        /* $criteria = new CDbCriteria();
         $criteria -> condition = " status_int = 1";
         $criteria -> order = " serial_number";
         $page = Pages::model()->findAll($criteria);*/

        $this->render('show' );
    }
}
?>
