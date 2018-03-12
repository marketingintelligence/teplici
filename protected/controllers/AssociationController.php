<?php
class AssociationController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $count = Supplier::model()->count($criteria);
        $s_pages =  ceil($count/5);

        $pages = new CPagination($count);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);

        $comb_count = Combinates::model()->count($criteria);

        $supplier = Supplier::model()->findAll($criteria);
        $combinates = Combinates::model()->findAll($criteria);

        $this->pageTitle = "Ассоциация";
        $this->render('index', array( "supplier" => $supplier, "combinates" => $combinates,"pages"=>$pages,"s_pages"=>$s_pages,"comb_count"=>$comb_count ));
    }

    public function actionGetsuppliers(){
        $numbers = $_POST['numbers'];

        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> offset = $numbers;
        $criteria -> limit = 5;

        $supplier = Supplier::model()->findAll($criteria);

        $var ='';
        foreach ($supplier as $key=>$value) {
            $img = json_decode($value->image,true);
            $var = $var.'
                <div class="assoc-item2">
                    <div class="item2-flex">
                        <div class="item2-img">
                            <img src="/upload/Supplier/full/'.$img[0].'">
                        </div>
                        <div class="item2-text">
                            <p>'.$value->name_text.'</p>
                        </div>
                    </div>
                    <div class="item2-body">
                        <span>'.$value->short_bigtext.'</span>
                    </div>
                </div>';
        }

        echo $var;
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
