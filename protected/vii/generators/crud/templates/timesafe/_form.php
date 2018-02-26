<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
$firstColumn = null;
foreach ($this->tableSchema->columns as $column)
{
	if ($column->autoIncrement)
	{
		continue;
	}
	if ($firstColumn == null)
	{
		$firstColumn = $column->name;
		break;
	}
}
?>
<?='<?php'?> $form = $this->beginWidget('BootActiveForm', array(
    'id' => '<?=strtolower($this->modelClass)?>-form',             
    'type'=>'horizontal',
    'enableAjaxValidation' => true,    
    <?php echo $firstColumn != null ? "\t'focus' => array(\$model, '{$firstColumn}'),\n" : ''; ?>    
    'htmlOptions' => array(
        'class' => 'form form-horizontal',
        'enctype'=>'multipart/form-data'
    ),
));
echo CHtml::hiddenField('<?=$this->modelClass?>_page',$_GET['<?=$this->modelClass?>_page']);
?>
    <div class="form-actions">
        <button class="btn btn-success" type="submit">
            <?='<?='?>$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>        
    	<?='<?='?>CHtml::link('назад', array('list','<?=$this->modelClass?>_page'=>$_GET['<?=$this->modelClass?>_page'])); ?><? if($this->generateLangs): echo "\n\t\t<? "?> $this->widget('timesafe.components.WLang',array('errors'=>$model->getErrors()))?><? echo "\n"; endif;  ?>
    </div>
    <?php foreach($this->tableSchema->columns as $column): if (!$column->autoIncrement  && $column->name!='is_removed'):?>
	<?php echo '<?php echo ' . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
	<?php
        if(stripos($column->dbType,'text')!==false){
    echo "\t\t<?php \$this->widget('application.extensions.redactor.VRedactor', array('model'=>\$model,'attribute'=>'{$column->name}')); ?>";
        }
        endif; endforeach; ?>    
    <? if($this->generateMeta): echo '<?'?> $this->widget('timesafe.components.WMeta',array('model'=>$model))?><? echo "\n"; endif;?>
    <div class="form-actions">
        <button class="btn btn-success" type="submit">
            <?='<?='?>$model->isNewRecord ? 'Добавить' : 'Сохранить'; ?>
        </button>
        <span class="text_button_padding">или</span>
        <?='<?='?>CHtml::link('назад', array('list','<?=$this->modelClass?>_page'=>$_GET['<?=$this->modelClass?>_page'])); ?>
	</div>
<?='<?'?> $this->endWidget(); ?>
