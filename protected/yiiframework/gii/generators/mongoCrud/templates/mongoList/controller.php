<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?> {
    public $layout = 'column2';

    public function actionIndex() {

        $result = <?php echo $this->modelClass; ?>::mongo()->find($this->filter); // Запрос
        if (is_array($this->sort)) $result->sort($this->sort); // Сортировка

        $pages = new CMongoPagination($result->count()); // Количество
        $pages->applyLimit($result); // Установка диапазона выборки

        $this->render('index', array('models' => $result, 'pages' => $pages));
    }


    public function actionCreate() {
        $id = Yii::app()->request->getParam('id');
        $model = new <?php echo $this->modelClass; ?>;
        $this->performAjaxValidation($model);
        if ($_POST['<?php echo $this->modelClass; ?>']) {
            $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
<?php $tf='';foreach($this->columns as $name=>$field) {
    if($field['type']=='image' || $field['type']=='file'){
        $tf.= "
            \$model->{$name} = \$this->saveFile('{$name}');";
    }

}
echo $tf."\n";
?>
            if ($model->save()) {
                if (isset($_POST['_saveAdd'])) $this->refresh(); else $this->redirect(array('index'));
            }
        } else {<?php
$t='';
foreach($this->columns as $name=>$field)
{
    if($field['type']=='date' || $field['type']=='datetime'){
        echo "
            \$model->{$name} = new MongoDate();";
        $t.="
        \$model->{$name} = SHelper::formDate(\$model->{$name});";
    }
}echo "\n";?>       }
        <?php echo $t."\n";?>
        $this->render('_form', array('model' => $model));
    }

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id');
        if ($id != null) {
            $mongo = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => new MongoId($id)));
            $model = new <?php echo $this->modelClass; ?>;
            $model->_id = new MongoId($id);
            $model->attributes = $mongo;

            $this->performAjaxValidation($model);
            if ($_POST['<?php echo $this->modelClass; ?>']) {
                $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
<? echo $tf."\n"; ?>
                if ($model->save()) {
                    if (isset($_POST['_saveAdd'])) $this->refresh(); else $this->redirect(array('index'));
                }
            }
            <?php echo $t."\n";?>
            $this->render('_form', array('model' => $model, 'update' => true));
        }

    }
 


    function actionAjax() {
        if (Yii::app()->request->isAjaxRequest) {

            $action = Yii::app()->request->getParam('action');
            $id = Yii::app()->request->getParam('id');

            switch ($action) {
                case 'on':
                case 'off':
                    $p = str_replace('change_', '', $id);
                    $p = explode('_', $p);
                    if ($p[0] != '' && $p[1] > 0) {
                        if ($action == 'on') {
                            <?php echo $this->modelClass; ?>::mongo()->update(array('_id' => new MongoId($p[1])), array('$set' => array($p[0] => '1')));
                        } elseif ($action == 'off') {
                            <?php echo $this->modelClass; ?>::mongo()->update(array('_id' => new MongoId($p[1])), array('$set' => array($p[0] => '0')));
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = new MongoId(Yii::app()->request->getParam('id'));
            <?php echo $this->modelClass; ?>::mongo()->remove(array('_id' => $id));
        }
    }

}