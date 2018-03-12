<?php
class AssociationController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $count = Supplier::model()->count($criteria);
        $c_pages = ( $count/5 );

        $pages = new CPagination($count);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);

        $sup_count = Supplier::model()->count($criteria);
        $supplier = Supplier::model()->findAll($criteria);
        $combinates = Combinates::model()->findAll($criteria);

        $this->pageTitle = "Ассоциация";
        $this->render('index', array( "supplier" => $supplier, "combinates" => $combinates,"pages"=>$pages,"c_pages"=>$c_pages,"sup_count"=>$sup_count));
    }

    public function actionGetsuppliers(){

    }
}
?>
