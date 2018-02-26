<?php
class WMeta extends CWidget {
    public $model;
    public $name;
    public function run() {
        if(is_object($this->model)){

            $this->name=get_class($this->model);
            $meta  = Meta::model()->findByAttributes(
                array(
                    'parent_id'=>$this->model->id,
                    'module'=>$this->name,
                    'lang'=>Yii::app()->language
                )
            );
            if(!$meta){
                $meta = new Meta();
            }
            if(count($_POST['_meta'])>0){
                $meta->title = $_POST['_meta']['title'];
                $meta->keywords = $_POST['_meta']['keywords'];
                $meta->description = $_POST['_meta']['description'];
            }
            $this->render('wMeta',array('meta'=>$meta));

        }

    }

}