<h1>Генератор модулей (подсайтов)</h1>

<p>Создаёт карса для подсайта который будет изолирован от основного сайта, но при этом работать с ним.<br>
Например: <strong>Админка</strong>, <strong>Личные кабинеты</strong> и т.д. </p>

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<div class="row control-group">
		<?php echo $form->labelEx($model,'moduleID',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'moduleID',array('size'=>65)); ?>
			<div class="tooltip">
				Имя чувствительно к регистру.<br>
				Должно содержать только буквы.<br>	<br>				
				Например, имя <code>forum</code> создаст <code>ForumModule</code>.
			</div>
			<?php echo $form->error($model,'moduleID'); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
