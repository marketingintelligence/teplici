<?php
class ExhibitionController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $exupload = Exupload::model()->findAll($criteria);
        $extext = Extext::model()->findAll($criteria);

        $this->pageTitle = "Теплицы";
        $this->render('index' , array("exupload" => $exupload, "extext" => $extext));
    }
}
?>


