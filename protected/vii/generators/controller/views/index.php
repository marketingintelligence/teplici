<h1>Генератор контроллера</h1>

<p>Позволяет быстро сгенерировать контроллер и файлы видов к указанным действиям контроллера.</p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row control-group">
		<?php echo $form->labelEx($model,'controller',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'controller',array('size'=>65)); ?>
			<div class="tooltip">
				Имя чувствительно к регистру. Например:
				<ul>
					<li><code>post</code> генератор создаст <code>PostController.php</code></li>
					<li><code>postTag</code> генератор создаст <code>PostTagController.php</code></li>
					<li><code>frontend/user</code> генератор создаст в папку <code>frontend/UserController.php</code>.<br></li>
					<li>Если указать имя модуля, то контроллер будет сгенерирован внутри него.
						<code>timesafe/news</code> генератор создаст <code>modules/controllers/NewsController.php</code></li>
				</ul>
			</div>
			<?php echo $form->error($model,'controller'); ?>
		</div>
	</div>
	
	<div class="row control-group">
		<?php echo $form->labelEx($model,'actions',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'actions',array('size'=>65)); ?>
			<div class="tooltip">
				Имена чувствительны к регистру.
				Для разделения используй запятую.
			</div>
			<?php echo $form->error($model,'actions'); ?>
		</div>
	</div>

	<div class="row control-group">
		<?php echo $form->labelEx($model,'baseClass',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'baseClass',array('size'=>65)); ?>
			<div class="tooltip">
				Наследования контроллера
			</div>
			<?php echo $form->error($model,'baseClass'); ?>
		</div>
	</div>


<?php $this->endWidget(); ?>
