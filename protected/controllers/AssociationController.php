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

        $comb_count = Combinates::model()->count($criteria);

        $supplier = Supplier::model()->findAll($criteria);
        $combinates = Combinates::model()->findAll($criteria);

        $this->pageTitle = "Ассоциация";
        $this->render('index', array( "supplier" => $supplier, "combinates" => $combinates,"pages"=>$pages,"c_pages"=>$c_pages,"comb_count"=>$comb_count ));
    }

    public function actionGetsuppliers(){

    }
    public function actionGetcombines(){
        $serial_number = $_POST['id'];

        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1 AND serial_number = '$serial_number' ";
        $com = Combinates::model()->find($criteria);

        echo $com->full_bigtexteditor;
    }
}
?>
