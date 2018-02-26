<?php
$is_removed = false;
foreach($this->tableSchema->columns as $column){
	if($column->name=='is_removed') $is_removed = true;
}
?>
<?php echo "<?php\n"; ?>
class <?php echo $this->controllerClass; ?> extends <?=$this->baseControllerClass."\n"?>
{
    public $filterOption = array(
        'model'  => '<?=$this->modelClass; ?>',
        'fields' => array(            
            <?php foreach ($this->filter as $field=>$type):                        
              $add=false;  
              if($this->filterExpert[$field]!=''){
                $opt = explode('|',$this->filterExpert[$field]);
                $add = "array('type'=>'".$opt[0]."'";
                if($opt[1]){
                  $add .=",'title'=>'".$opt[1]."'";
                }
                if($opt[2]){
                  $add .=",'additional'=>'".$opt[2]."'";
                }
                $add .=')';
              }elseif($type!=''){
                $add = "array('type'=>'".$type."')";
              }    
              if($add){
                echo "'{$field}'=>{$add},\n\t\t\t";
              }          
            endforeach ?>            
        )
    );

    public $defaultAction = 'list';


    public function actionIndex() {
        $this->redirect('list');
    }

    public function actionList() {
        $model = new <?=$this->modelClass; ?>('search');
        $model->unsetAttributes();

        if (isset($_GET['<?=$this->modelClass; ?>'])) {
            $model->attributes = $_GET['<?=$this->modelClass; ?>'];
            Yii::app()->user->setState('_filter_<?=$this->modelClass; ?>', $_GET['<?=$this->modelClass; ?>']);
        } else
            if (Yii::app()->user->hasState('_filter_<?=$this->modelClass; ?>')) {
                $model->attributes = Yii::app()->user->getState('_filter_<?=$this->modelClass; ?>');
            }
        $this->filter = $model->attributes;
        if (isset($_GET['ajax'])) {
            $this->renderPartial(
                '_list', array(
                              'model' => $model,
                         ));
        } else
            $this->render(
                'list', array(
                             'model' => $model,
                        ));
    }

    /**
     * Создание модели
     */
    public function actionCreate() {
        $model = new <?=$this->modelClass; ?>;

        $this->performAjaxValidation($model);

        if (isset($_POST['<?=$this->modelClass; ?>'])) {
            $model->attributes = $_POST['<?=$this->modelClass; ?>'];
            <?php $time='';
  foreach($this->tableSchema->columns as $column):    
  	if(stripos($column->name,'_at')!==false) 
  		$time.="\n\t\t\t\$model->{$column->name} = time();";
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')!==false):?>
            $model-><?=$column->name?>=$this->saveFile($model,'<?=$column->name?>');
<?php endif;
  endforeach;?>            
            if ($model->save()) {
                $this->saveMeta($model, $_POST['_meta']);
                Yii::app()->user->setFlash('success', 'Сохранено');               
                $this->redirect(array('list'));
            } else {
                Yii::app()->user->setFlash('error', 'Ошибка при сохранении');

            }            
        } else {<?=$time?>            
        }
        $this->render(
            'create', array(
                           'model' => $model,
                      ));
    }

    /**
     * Редактирование
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $page = (int)Yii::app()->request->getParam('<?=$this->modelClass; ?>_page');

        if (isset($_POST['<?=$this->modelClass; ?>'])) {
            $model->attributes = $_POST['<?=$this->modelClass; ?>'];
            <?php
  foreach($this->tableSchema->columns as $column):      	
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')!==false):?>
            $model-><?=$column->name?>=$this->saveFile($model,'<?=$column->name?>');
<?php endif;
  endforeach;?>            
            if ($model->save()) {
                $this->saveMeta($model, $_POST['_meta']);
                Yii::app()->user->setFlash('success', 'Сохранено');               

                $this->redirect(
                    array(
                         'list',
                         '<?=$this->modelClass; ?>_page' => $page));
            } else {
                Yii::app()->user->setFlash('error', 'Ошибка при сохранении');
            }
        }        
        $this->render(
            'update', array(
                           'model' => $model,
                           'page'  => $page
                      ));
    }

    /**
     * Удаление модели
     */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id, true)->delete();
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('list'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Неверный запрос.');
        }
    }
<? if($is_removed):?>
    /**
     * Удаление моделив корзину
     */
    public function actionRemove($id) {
        $this->loadModel($id)->remove();
    }

    /**
     * Восстановление модели из корзины
     */
    public function actionRestore($id) {
        $this->loadModel($id, true)->restore();
    }
<? endif; ?>
    /**
     * Загрузка модели по ID
     *
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $removed = false) {
        <?if($is_removed):?>if ($removed)
            $model = <?=$this->modelClass; ?>::model()->withRemoved()->findByPk($id);
        else<?endif;?>
            $model = <?=$this->modelClass; ?>::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'Страница не существует.');
        }
        return $model;
    }

    /**
     * AJAX валидация
     *
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === '<?php echo $this->class2id($this->modelClass); ?>-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        if ($_GET['ajax'] === 'state')
            if (count($_GET['<?=$this->modelClass; ?>Check']) > 0) {
                foreach ($_GET['<?=$this->modelClass; ?>Check'] as $column => $value) {
                    foreach ($value as $id => $val) {
                        <?=$this->modelClass; ?>::model()->updateByPk((int)$id, array($column => (int)$val));
                    }
                }
                Yii::app()->end();
            }

        return parent::beforeAction($action);
    }
}


