<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$modelClass=$this->modelClass;
$image=false;
$file=false;
$parent=false;
$weight=false;
foreach($this->tableSchema->columns as $column):
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')!==false):
            if(stripos($column->name,'image')!==false){
                $image=$column->name;
            }
            if(stripos($column->name,'file')!==false){
                $file=$column->name;
            }

            if(!is_dir('upload/'.$modelClass)){
                mkdir('upload/'.$modelClass);
                chmod('upload/'.$modelClass, 0777);
            }
            if(stripos($column->name,'image')!==false){
                if(!is_dir('upload/'.$modelClass.'/sm')){
                    mkdir('upload/'.$modelClass.'/sm');
                    chmod('upload/'.$modelClass.'/sm', 0777);
                }
            }
    endif;
    if($column->name=='parent_id'){
        $parent=true;
    }
    if($column->name=='weight'){
        $weight=true;
    }
endforeach;

?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new <?php echo $this->modelClass; ?>;
		
		$this->performAjaxValidation($model);
		
		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
                    if($_POST['_addAgain']){
                        Yii::app()->user->setState('_addAgain',1);
                    }else{
                        Yii::app()->user->setState('_addAgain',0);
                    }
                    $model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
		

<?php $time='';$times='';
  foreach($this->tableSchema->columns as $column):
    if(stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false):
      $time.='$model->'.$column->name.'=date("d-m-Y",$model->'.$column->name.');'."\n";
      $times.='$model->'.$column->name.'=date("d-m-Y");'."\n";
    endif;
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')!==false):?>
      $model-><?=$column->name?>=$this->saveFile($model,'<?=$column->name?>');
    <?php endif; 
  endforeach;?>

    if($model->save()){
        if(Yii::app()->user->getState('_addAgain')){
            $this->redirect(array('create'));
        }else
            $this->redirect(array('index'));
    }

      <?=$time?>
        }<? if($times!=''):?>else{<?=$times?>        
        }<?endif;?>

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		
		$this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			<?php $time='';$times='';
  foreach($this->tableSchema->columns as $column):
    if(stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false):
      $time.='$model->'.$column->name.'=date("d-m-Y",$model->'.$column->name.');'."\n";      
    endif;
    if(stripos($column->name,'image')!==false || stripos($column->name,'file')!==false):?>
      $model-><?=$column->name?>=$this->saveFile($model,'<?=$column->name?>');
    <?php endif; 
  endforeach;?>
                
        
        
			if($model->save())
				$this->redirect(array('index'));
		}
    <?=$time?>
		$this->render('update',array(
			'model'=>$model,
		));
	}



    /**
     * Сохранение файла/изображения модели
     */
<?
    $model=CActiveRecord::model($modelClass);

    $options=$model->modelOptions();

    if($image || $file):
     ?>
    public function saveFile($model,$name=null){
        $tmp=$_POST[$name.'-src'];
        $delete=true;
        if($name!==null){
            $UPimage=CUploadedFile::getInstance($model,$name);
            if($UPimage!==NULL) {
                if(<?php echo $modelClass; ?>::model()->count("`{$name}`='{$tmp}'")>0){$delete=false;}
                if(strstr($UPimage->type,'image')) {
                    $path=pathinfo($UPimage->name);
                    $fileName='<?php echo $modelClass; ?>-'.time().'.'.$path["extension"];                    
                    $UPimage->saveAs('upload/tmp_<?php echo $modelClass; ?>_'.$fileName); // save the uploaded file
                    Yii::import('application.extensions.image.Image');
                    $image = new Image('upload/tmp_<?php echo $modelClass; ?>_'.$fileName);
<?
$delete=array();

$size=explode('x',$options['images']['full']);

if(is_array($size) && $options['images']['full']!=''){
    echo "\t\t\$w=\$image->width;\$h=\$image->height;\n";
    echo "\t\t if(\$w>{$size[0]} || \$h>{$size[1]})\n";
    echo "\t\t\$image->resize({$size[0]},{$size[1]});\n";
    echo "\t\t\$image->save('upload/{$modelClass}/'.\$fileName);\n";
}else{
    echo "\t\t\$image->save('upload/{$modelClass}/'.\$fileName);\n";
}
echo "\t\t if(\$delete){if(is_file('upload/{$modelClass}/'.\$tmp))unlink('upload/{$modelClass}/'.\$tmp);}\n";
$delete[]='/';
if(is_array($options['images'])){
    foreach($options['images'] as $key=>$val){        
        if($key!='full' && $key!='sm'){
            
            if(!is_dir('upload/'.$modelClass.'/'.$key)){
                mkdir('upload/'.$modelClass.'/'.$key);
                chmod('upload/'.$modelClass.'/'.$key, 0777);
            }
            $size=explode('x',$val);
            echo "\t\t if(\$w>{$size[0]} || \$h>{$size[1]})\n";
            echo "\t\t\$image->resize({$size[0]},{$size[1]});\n";
            echo "\t\t\$image->save('upload/{$modelClass}/{$key}/'.\$fileName);\n";
            $delete[]='/'.$key.'/';
            //echo "\t\tif(is_file('upload/{$modelClass}/{$key}/'.\$tmp))\n\t\t\tunlink('upload/{$modelClass}/{$key}/'.\$tmp);\n";
            echo "\t\t if(\$delete){if(is_file('upload/{$modelClass}/{$key}/'.\$tmp))unlink('upload/{$modelClass}/{$key}/'.\$tmp);}\n";
            echo "\n";

        }

  }
    $size=explode('x',$options['images']['sm']);    
    echo "\n";
    if(is_array($size)){
        echo "\t\t if(\$w>{$size[0]} || \$h>{$size[1]})\n";
        echo "\t\t\$image->resize({$size[0]},{$size[1]});\n";
        echo "\t\t\$image->save('upload/{$modelClass}/sm/'.\$fileName);\n";
    }else{
        echo "\t\t\$image->resize(100,100);";
        echo "\t\t\$image->save('upload/{$modelClass}/sm/'.\$fileName);\n";
    }
    
}
//echo "\t\tif(is_file('upload/{$modelClass}/sm/'.\$tmp))\n\t\t\tunlink('upload/{$modelClass}/sm/'.\$tmp);\n";
echo "\t\t if(\$delete){if(is_file('upload/{$modelClass}/sm/'.\$tmp))unlink('upload/{$modelClass}/sm/'.\$tmp);}\n";
$delete[]='/sm/';

?>
                    unlink('upload/tmp_<?php echo $modelClass; ?>_'.$fileName);
                }else {
                    if($delete){if(is_file('upload/<?php echo $modelClass; ?>/'.$tmp))unlink('upload/<?php echo $modelClass; ?>/'.$tmp);}
                    $UPimage->saveAs('upload/<?php echo $modelClass; ?>/'.$fileName); // save the uploaded file
                }
                return $fileName;
            }elseif($_POST[$name.'-src']!=''){
                return $_POST[$name.'-src'];
            }
        }
        return $tmp;
    }
    <? endif;?>
<?
if($image || $file):?>
     public function deleteFile($model,$name=null){
    <? foreach ($delete as $val): ?>
            if(is_file('upload/<?=$modelClass.$val?>'.$model->$name))
                unlink('upload/<?=$modelClass.$val?>'.$model->$name);
    <? endforeach; ?>
     }
    <? endif;?>



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request			
            $model=$this->loadModel();
<? if($image):?>
            $this->deleteFile($model,'<?=$image?>');
            $imageOnly=(bool)Yii::app()->request->getParam('imageOnly');
            if ($imageOnly)
            {
                $model->image="";
                $model->save();
            }else
            {
<? endif;?>
<? if($file):?>
            $this->deleteFile($model,'<?=$file?>');
<? endif;?>
<?if ($parent):?>
            if(<?php echo $modelClass; ?>::model()->count("parent_id='{$model->id}'")>0){
                <?php echo $modelClass; ?>::model()->updateAll(array('parent_id'=>$model->parent_id),"parent_id='{$model->id}'");
            }
<? endif;?>
            $model->delete();
<? if($image)://CLOSINIG BRACKET IF "imageOnly" parameter ?>
            }
<? endif;?>
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

 <?if ($parent):?>
      public function get<?php echo $modelClass; ?>($id=0) {
        $models=<?php echo $modelClass; ?>::model()->findAll('parent_id='.$id);
        foreach ($models as $model) {            
            $c=<?php echo $modelClass; ?>::model()->count('parent_id='.$model->id)>0?true:false;
            $t=array(
                    'text'=>Yii::app()->controller->renderPartial('_view',array('data'=>$model),true),
                    'id'=>$model->id,
                    'hasChildren'=>$c,
                    'expanded'=>false,
            );
            if($c) {
                $t['children']=$this->get<?php echo $modelClass; ?>($model->id);
            }
            $data[]=$t;
        }
        return $data;
    }
    <?endif;?>

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new <?php echo $this->modelClass; ?>('search');
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
                    $id=(int)Yii::app()->request->getParam('id');
			if($id>0)
				$this->_model=<?php echo $this->modelClass; ?>::model()->findbyPk($id);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	

    function actionAjax() {
        switch ($_POST['action']) {
            case 'on':
            case 'off':
                $p=str_replace('change_', '', $_POST['id']);
                $p = explode('_',$p);                
                if($p[0]!='' && $p[1]>0) {
                    if($_POST['action']=='on') {
                         <?php echo $modelClass; ?>::model()->updateByPk($p[1],array($p[0]=>'1'));
                    }elseif($_POST['action']=='off') {
                         <?php echo $modelClass; ?>::model()->updateByPk($p[1],array($p[0]=>'0'));
                    }
                }
                break;
            default:
                break;
        }
    }


    public function actionOrder() {
        if (Yii::app()->request->isPostRequest && isset($_POST['Order'])) {
            $models = explode(',', $_POST['Order']);
            for ($i = 0; $i < sizeof($models); $i++) {
                if ($model =  <?php echo $modelClass; ?>::model()->findbyPk($models[$i])) {
                    $model->weight = $i;
                    $model->save();
                }
            }
        }else {
            $dataProvider = new CActiveDataProvider(' <?php echo $modelClass; ?>', array(
                            'pagination' => false,
                            'criteria' => array(
                                    'order' => 'weight ASC, id DESC',
                            ),
            ));
            $this->render('order',array(
                    'dataProvider' => $dataProvider,
            ));
        }
    }   
	
	
}
