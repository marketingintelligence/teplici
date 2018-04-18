<?php
class AboutController extends Controller {
    public function actionIndex() {

        $criteria = new CDbCriteria();
        $criteria->offset = 0;
        $criteria->limit = 1;
        $pages = Pages::model()->findAll($criteria);

        $lang = Yii::app()->user->getState("lang");
        $this->pageTitle = "Теплицы";
        $this->render('index' ,array("lang" => $lang,"pages" => $pages));
    }
}
?>
