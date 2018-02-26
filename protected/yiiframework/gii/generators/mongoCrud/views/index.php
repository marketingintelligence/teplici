<?php
Yii::app()->clientScript->registerScript('gii.crud',"
$('#CrudCode_controller').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#CrudCode_model').bind('keyup change', function(){
	var controller=$('#CrudCode_controller');
	if(!controller.data('changed')) {
		var id=new String($(this).val().match(/\\w*$/));
		if(id.length>0)
			id=id.substring(0,1).toLowerCase()+id.substring(1);
		controller.val(id);
	}
});
");
?>
<h1>Генератор MongoTree</h1>

<p>Генерирует основу для редактирования древовидной структуры в Mongo</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>65)); ?>
		<div class="tooltip">
			Модель регистрозависима. Она должна совпадать с именем класса (например: <code>Post</code>)
		    или путь к классы (например: <code>application.models.Post</code>).
		</div>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'controller'); ?>
		<?php echo $form->textField($model,'controller',array('size'=>65)); ?>
		<div class="tooltip">
            Контроллер регистрозависим. Контроллеры обычно генерируются на основе классов
			с которыми работают. Например:
			<ul>
				<li><code>post</code> генерирует <code>PostController.php</code></li>
				<li><code>postTag</code> генерирует <code>PostTagController.php</code></li>
				<li><code>admin/user</code> генерирует <code>admin/UserController.php</code></li>
			</ul>
		</div>
		<?php echo $form->error($model,'controller'); ?>
	</div>

	<div class="row sticky">
		<?php echo $form->labelEx($model,'baseControllerClass'); ?>
		<?php echo $form->textField($model,'baseControllerClass',array('size'=>65)); ?>
		<div class="tooltip">
            Класс-предок необходимо чтобы он существовал и был загружен.
		</div>
		<?php echo $form->error($model,'baseControllerClass'); ?>
	</div>

<?php $this->endWidget(); ?>
