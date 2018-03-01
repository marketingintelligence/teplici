<?php
class AssociationController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $count = Supplier::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);

        $supplier = Supplier::model()->findAll($criteria);
        $combinates = Combinates::model()->findAll($criteria);

        $this->pageTitle = "Ассоциация";
        $this->render('index', array( "supplier" => $supplier, "combinates" => $combinates,"pages"=>$pages));
    }
    public function actionGetsuppliers(){

    }
}
?>
