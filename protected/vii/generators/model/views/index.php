<?php
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.model',"
$('#{$class}_modelClass').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_tableName').bind('keyup change', function(){
	var model=$('#{$class}_modelClass');
	var tableName=$(this).val();
	if(tableName.substring(tableName.length-1)!='*') {
		$('.form .row.model-class').show();
	}
	else {
		$('#{$class}_modelClass').val('');
		$('.form .row.model-class').hide();
	}
	if(!model.data('changed')) {
		var i=tableName.lastIndexOf('.');
		if(i>=0)
			tableName=tableName.substring(i+1);
		var tablePrefix=$('#{$class}_tablePrefix').val();
		if(tablePrefix!='' && tableName.indexOf(tablePrefix)==0)
			tableName=tableName.substring(tablePrefix.length);
		var modelClass='';
		$.each(tableName.split('_'), function() {
			if(this.length>0)
				modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
		});
		model.val(modelClass);
	}
});
$('.form .row.model-class').toggle($('#{$class}_tableName').val().substring($('#{$class}_tableName').val().length-1)!='*');
");
?>
<h1>Генератор моделей</h1>

<p>Создаст модель на основе таблицы.</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row sticky control-group">
		<?php echo $form->labelEx($model,'tablePrefix',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'tablePrefix', array('size'=>65)); ?>
			<div class="tooltip">
			Например префикс: <code>data_</code> для таблицы <code>data_post</code>
			создаст модель <code>Post</code>.
			</div>
			<?php echo $form->error($model,'tablePrefix'); ?>
		</div>
	</div>
	<div class="row control-group">
		<?php echo $form->labelEx($model,'tableName',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'tableName', array('size'=>65)); ?>
			<div class="tooltip">
			Также можно использовать <code>*</code> для генерации моделей для всех таблиц в БД.
			</div>
			<?php echo $form->error($model,'tableName'); ?>
		</div>	
	</div>	
	<div class="control-group <?=count($model->labels)>0?'':'hide'?>">
		<label for="" class="control-label">Названия полей</label>
		<div class="controls well clearfix " id="fields-labels">
			<? foreach ($model->labels as $field=>$label):?>
			<div class="span3">
				<span class="label label-important"><?=$field?></span>
				<input type="text" name="ModelCode[labels][<?=$field?>]" class="span3" value="<?=$label?>"/>
			</div>
			<? endforeach; ?>
		</div>
	</div>
	<div class="row model-class control-group">
		<?php echo $form->label($model,'modelClass',array('required'=>true,'class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'modelClass', array('size'=>65)); ?>
			<div class="tooltip">
			Имя модели, например <code>Post</code>, <code>Comment</code>.
			Регистрозависимое.
			</div>
			<?php echo $form->error($model,'modelClass'); ?>
		</div>
	</div>
	<div class="row control-group">
		<?php echo $form->label($model,'modelClassName',array('required'=>true,'class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'modelClassName', array('size'=>65)); ?>
			<div class="tooltip">
			Название класса модели, например  модель<code>Post</code> это <code>Записи в блоге</code>, <code>Comment</code> это <code>Комментарии</code>.		
			</div>
			<?php echo $form->error($model,'modelClassName'); ?>
		</div>
	</div>
	<div class="row sticky control-group">
		<?php echo $form->labelEx($model,'baseClass',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'baseClass',array('size'=>65)); ?>
			<div class="tooltip">
				Наследование модели
			</div>
			<?php echo $form->error($model,'baseClass'); ?>
		</div>
	</div>
	<div class="row sticky control-group">
		<?php echo $form->labelEx($model,'modelPath',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'modelPath', array('size'=>65)); ?>
			<div class="tooltip">
				Путь к директории где будет располагаться модель.				
			</div>
			<?php echo $form->error($model,'modelPath'); ?>
		</div>
	</div>
	<div class="row control-group">
		<?php echo $form->labelEx($model,'buildRelations',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'buildRelations'); ?>
			<div class="tooltip">
				Создание связей для модели. Будет полное сканирование БД, если в БД очень много таблиц, то лучше эту опцию отключить.
			</div>
			<?php echo $form->error($model,'buildRelations'); ?>
		</div>
	</div>
	<div class="row control-group">
		<?php echo $form->labelEx($model,'trash',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'trash'); ?>
			<div class="tooltip">
				К модели будет добавлено поведение "<code>удаление в корзину</code>".				
			</div>
			<?php echo $form->error($model,'trash'); ?>
		</div>
	</div>
	<div class="row control-group">
		<label for="" class="control-label">Есть изображения?</label>
		<div class="controls">

			<?php echo $form->checkBox($model,'hasImage',array('onchange'=>'js:$("#imageOptions").slideToggle()')); ?>
			<div class="tooltip">
				Укажите размеры для изображений
			</div>
			<?php echo $form->error($model,'hasImage'); ?>
		</div>
	</div>
	<div class="control-group <?=$model->hasImage?'':'hide'?>" id="imageOptions">
		<label for="" class="control-label">Размеры</label>
		<div class="controls">
		<div id="image-size">
		<? foreach ($model->images['path'] as $key=>$path): 
		if(!$path) continue;
		?>
			<?=CHtml::textField('ModelCode[images][path][]',$model->images['path'][$key],array('class'=>'span1'))?>
			<?=CHtml::textField('ModelCode[images][size][]',$model->images['size'][$key],array('class'=>'span2'))?>			
			<?=CHtml::dropDownList('ModelCode[images][type][]',$model->images['type'][$key], array('resize'=>'Масштабировать','crop'=>'Обрезать'),array('class'=>'span3 nchosen')) ;?>	<br>
			<? endforeach; ?>
		</div>
			<a href="" id="add-image-size" class="btn btn-success btn-mini"><i class="icon-plus"></i> Добавить</a>

			<div class="hint">
				<code>full</code> - большие изображения<br>
				<code>sm</code> - уменьшенные изображения<br>
				<code>tm</code> - изображения используемые Timesafe. Желательно не трогать.<br>
				Укажи размеры используемых изображений и пути к ним. Например <code>sm => 120x90</code>, <code>full => 450x300</code><br>
				Если указать одну ширину, то это значение будет использовано и для высоты <code>100</code> => <code>100x100</code><br><br>
				<code>Папки под изображения создаются автоматически, при необходимости их нужно удалить.</code>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
	var timeTable = null
	$(function(){
		$('#add-image-size').click(function(e){
			$('#image-size').append('<div><input type="text" name="ModelCode[images][path][]" value="" class="span1"> <input type="text"  name="ModelCode[images][size][]" value="" class="span2"> <select name="ModelCode[images][type][]" class="span3 nchosen"><option selected="selected" value="resize">Масштабировать</option><option value="crop">Обрезать</option></select> <button class="remove-image-size btn error small">удалить</button></div>');
			e.preventDefault();
		});
		$('#remove-image-size').live('click',function(e){
			$(this).parent().remove();
			e.preventDefault();
		});
		$('#ModelCode_tableName').keyup(function(){
			timeTable = null;
			return true;
		});
		$('#ModelCode_tableName').change(function(){
			var table = $(this).val();
			timeTable = setTimeout(function(){
				$('#fields-labels').parent().slideUp();
				$.ajax({
					url:'<?=$this->createUrl('tableInfo')?>',
					dataType:'json',
					type:'get',
					data:{table:table},
					success:function(m){						
						html = '';
						for (field in m){
							html +='<div class="span3">'+field+'<input type="text" class="span3" value="'+m[field]+'" name="ModelCode[labels]['+field+']"></div>';
						}
						$('#fields-labels').html(html).parent().slideDown();
						$('.tooltip').hide();
					}
				});
			},500)
		});
	});
</script>