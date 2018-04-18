<?php
class ExhibitionController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $exupload = Exupload::model()->findAll($criteria);
        $explan = Explan::model()->findAll($criteria);
        $extext = Extext::model()->findAll($criteria);
        $exprogram = Exprogram::model()->findAll($criteria);
        $partlist = Partlist::model()->findAll($criteria);

        $lang = Yii::app()->user->getState("lang");
        $this->pageTitle = "Теплицы";
        $this->render('index' , array("exupload" => $exupload, "extext" => $extext,"explan"=>$explan,"exprogram"=>$exprogram,"partlist"=>$partlist,"lang" => $lang));
    }
}
?>


