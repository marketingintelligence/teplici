<?php
$class = get_class($model);
Yii::app()->clientScript->registerScript('gii.crud', "
$('#{$class}_controller').change(function(){
	$(this).data('changed', $(this).val() != '');
});
$('#{$class}_model').bind('keyup change', function(){
	var controller = $('#{$class}_controller');
	if (!controller.data('changed'))
	{
		var id = new String($(this).val().match(/\\w*$/));
		if (id.length > 0)
		{
			id = id.substring(0, 1).toLowerCase() + id.substring(1);
		}
		controller.val('timesafe/'+id);
		if(id=='') controller.val('');
	}
});
");
?>
<style type="text/css">
	#fields-labels div.span5 {
    display: inline;
    float: left;
    margin-left: 20px;    
    height:50px;
}
.hint ul, .hint ul li{
	margin-left: 5px;
	list-style:none;
}
</style>
<h1>Генератор на основе "Bootstrap"</h1>
<?php $form = $this->beginWidget('CCodeForm', array(
	'model' => $model,
)); ?>
	<div class="control-group row">
		<?php echo $form->labelEx($model, 'model',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model, 'model', array('size' => 65)); ?>
			<div class="tooltip">
				Имя чувствительно к регистру. Например <code>Post</code> или <code>Catalog</code>
			</div>
			<?php echo $form->error($model, 'model'); ?>
		</div>
		</div>		
	<div class="control-group <?=count($model->filter)>0?'':'hide'?>">
		<label for="" class="control-label">Фильтр полей</label>
		<div class="controls">
			<div id="fields-labels" class="control-group well">
				<? foreach ($model->filter as $field=>$label):?>
				<div class="span5">
					<span class="label label-important"><?=$field?></span><br>
					<?=CHtml::dropDownList(
						'CrudCode[filter]['.$field.']',
						$label,
						array(
							''=>'Нет',
							'text'=>'Поиск',
							'checkbox'=>'Опция',
							'date'=>'Дата',
							'parent'=>'Связь',
							'custom'=>'Эксперт'
						), 
						array('class'=>'span2 nchosen')
					)?>
					<?=CHtml::textField('CrudCode[filterExpert]['.$field.']',$model->filterExpert[$field],array('class'=>'span2','style'=>$model->filterExpert[$field]?'':'display:none'))?>
				</div>
				<? endforeach; ?>		
				
			</div>	
			<div class="hint">Выбери поля которые будут использованы в фильтре: 
				<ul>
					<li> - <code>Поиск</code> - фильтр по тексту (<code>LIKE %%</code>)</li>
				 	<li> - <code>Опция</code> - все, "активные", "неактивные"</li>
				 	<li> - <code>Дата</code> - все, за день, за 3 дня и т.д.</li>
				 	<li> - <code>Связь</code> - автозаполнение по связи <code>FOREIGN KEY</code></li>
				 	<li> - <code>Эксперт</code> - Установление параметров вручную. Пример <code>parent|title|email</code> - <code>parent</code> -тип фильтра <code>title</code> - поле поиска (<code>title_ru</code>) <code>email</code> - дополнительное поле поиска.</li>
				 </ul>
			 </div>
		</div>

	</div>
	<div class="control-group row">
		<?php echo $form->labelEx($model, 'controller',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model, 'controller', array('size' => 65)); ?>
			<div class="tooltip">
				Путь к контроллеру, регистрозависим.<br>
				<ul>
					<li><code>post</code> создаст <code>PostController.php</code></li>
					<li><code>postTag</code> создаст <code>PostTagController.php</code></li>
					<li><code>admin/user</code> создаст <code>admin/UserController.php</code>.<br>
						Если в приложении активет модуль <code>admin</code> ,
						то будет создан <code>UserController</code> внутри модуля.
					</li>
				</ul>
			</div>
			<?php echo $form->error($model, 'controller'); ?>
		</div>
	</div>
	<div class="control-group row  sticky">
		<?php echo $form->labelEx($model, 'baseControllerClass',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model, 'baseControllerClass', array('size' => 65)); ?>
			<div class="tooltip">
				This is the class that the new CRUD controller class will extend from.
				Please make sure the class exists and can be autoloaded.
			</div>
			<?php echo $form->error($model, 'baseControllerClass'); ?>
		</div>		
	</div>
	
	<div class="control-group row">
		<?php echo $form->labelEx($model, 'generateLangs',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($model, 'generateLangs'); ?>
			<div class="tooltip">
				Добавляет переключатель языковых версий в форму
			</div>
			<?php echo $form->error($model, 'generateComponents'); ?>
		</div>
	</div>
	<div class="control-group row">
		<?php echo $form->labelEx($model, 'generateMeta',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->checkBox($model, 'generateMeta'); ?>
			<div class="tooltip">
				Добавляет виджет мета-информации
			</div>
			<?php echo $form->error($model, 'generateComponents'); ?>
		</div>
	</div>	
<?php $this->endWidget(); ?>

<script type="text/javascript">
	var timeTable = null
	$(function(){		
		$('#CrudCode_model').keyup(function(){
			timeTable = null;
			return true;
		});
		$('#CrudCode_model').change(function(){
			var table = $(this).val();
			timeTable = setTimeout(function(){
				$('#fields-labels').parents('.control-group').slideUp();
				$.ajax({
					url:'<?=$this->createUrl('modelInfo')?>',
					dataType:'json',
					type:'get',
					data:{model:table},
					success:function(m){						
						html = '';
						for (field in m){
							html +='<div class="span5">\
								<span class="label important">'+field+'</span><br>\
								<select id="CrudCode_filter_title_ru" name="CrudCode[filter]['+field+']" class="span2 nchosen">\
									<option value="">Нет</option>\
									<option value="text" '+(m[field]=='text'?'selected="selected"':'')+'>Поиск</option>\
									<option value="checkbox" '+(m[field]=='checkbox'?'selected="selected"':'')+'>Опция</option>\
									<option value="date" '+(m[field]=='date'?'selected="selected"':'')+'>Дата</option>\
									<option value="parent" '+(m[field]=='parent'?'selected="selected"':'')+'>Связь</option>\
									<option value="custom">Эксперт</option>\
								</select>\
								<input type="text" id="CrudCode_filterExpert_'+field+'" name="CrudCode[filterExpert]['+field+']" style="display:none" class="span2">\
							</div>';
						}
						$('#fields-labels').html(html).parents('.control-group').slideDown();
						$('.tooltip').hide();
					}
				});
			},500)
		});
		$('#fields-labels select').live('change',function(){
			if($(this).val()=='custom'){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
		});
	});
</script>