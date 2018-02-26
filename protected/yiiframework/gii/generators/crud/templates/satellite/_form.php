<?php
/**
 * This is the template for generating the form view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>\n"; ?>

    <div class="action-top">        
        <button class="btn" type="submit" ><span><span class="save">Сохранить</span></span></button>
        <button class="btn" type="button" onclick="document.location.href='<?php echo "<?=\$this->createUrl('index')?>"; ?>'" ><span><span class="cancel">Отмена</span></span></button>
    </div>
	<p class="note"><span class="required">*</span> Обязательные поля</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
$modelClass=$this->modelClass;
$langs=array('ru','en','kz','cn','uz','kg','es');
foreach($this->tableSchema->columns as $column)
{
	//echo '<pre>'.print_r($column,1).'</pre>';
    if($column->isPrimaryKey)
        continue;
    $c = explode('_', $column->name);
    $l = $c[sizeof($c) - 1];
    $la=false;
    if (sizeof($c) > 1 && in_array($l, $langs)) {
       $la=' lang '.$l;
    }

?>
        <div class="row<?=$la?$la:''?>" <? echo stripos($column->dbType,'text')!==false?'style="width:100%"':''?>>
        <?php echo "<?php echo ".$this->generateActiveLabel($modelClass,$column)."; ?>\n"; ?>
        <?php echo "<?php echo ".$this->generateInputField($modelClass,$column)."; ?>\n"; ?>
        <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
        <?php
        if(stripos($column->dbType,'text')!==false){
            echo "<?php \$this->widget('application.extensions.elrte.elRTE', array('model'=>\$model,'attribute'=>'{$column->name}')); ?>";
        }
        if(stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false){
            echo "<?php \$this->widget('application.extensions.calendar.JCalendar',array('inputField'=>'{$column->name}','startDate'=>'01-01-2005'))?>";
        }
        if( stripos($column->name,'image')!==false){
             echo "<?php echo is_file('upload/".$modelClass."/sm/'.\$model->".$column->name.".'')?'<div class=\"picture\">'.CHtml::link(CHtml::image('/upload/".$modelClass."/sm/'.\$model->".$column->name."),'/upload/".$modelClass."/'.\$model->".$column->name.",array('target'=>'_blank')).'</div>':''; ?>\n\t";
             echo "<?php echo is_file('upload/".$modelClass."/'.\$model->".$column->name.")?CHtml::hiddenField('{$column->name}-src',\$model->".$column->name."):''; ?>\n";
        }
        if( stripos($column->name,'file')!==false){
             echo "<?php echo is_file('upload/".$modelClass."/'.\$model->".$column->name.".'')?'<div class=\"file\">'.CHtml::link('Скачать файл','/upload/".$modelClass."/'.\$model->".$column->name.",array('target'=>'_blank')).'</div>':''; ?>\n\t";
             echo "<?php echo is_file('upload/".$modelClass."/'.\$model->".$column->name.")?CHtml::hiddenField('{$column->name}-src',\$model->".$column->name."):''; ?>\n";
        }?>

    </div>
    <?
}
?>
    <div class="action">
        <button class="btn" type="submit" ><span><span class="save">Сохранить</span></span></button>
        <button class="btn" type="button" onclick="document.location.href='<?php echo "<?=\$this->createUrl('index')?>"; ?>'" ><span><span class="cancel">Отмена</span></span></button>
        <?php echo "<? if(\$create===true): echo CHtml::checkBox('_addAgain',Yii::app()->user->getState('_addAgain'),array('id'=>'_addAgain'));  ?>"; ?>
        <label for="_addAgain" >Добавить ещё?</label>
        <?php echo "<? endif; ?>"; ?>
    </div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->