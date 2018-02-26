<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="wide form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false || stripos($field,'metatitle')!==false  || stripos($field,'keywords')!==false  || stripos($field,'description')!==false || stripos($field,'image')!==false  || stripos($field,'file')!==false || stripos($column->dbType,'text')!==false || stripos($column->name,'_at')!==false || stripos($column->name,'date')!==false)

		continue;
        ?>
	<div class="row">
		<?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	</div>

<?php endforeach; ?>
	<div class="buttons">
            <button class="btn" type="submit" ><span><span class="search">Поиск</span></span></button>	
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->